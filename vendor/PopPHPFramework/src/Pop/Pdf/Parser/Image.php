<?php
/**
 * Pop PHP Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.TXT.
 * It is also available through the world-wide-web at this URL:
 * http://www.popphp.org/LICENSE.TXT
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@popphp.org so we can send you a copy immediately.
 *
 * @category   Pop
 * @package    Pop_Pdf
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Pdf\Parser;

use Pop\Dir\Dir,
    Pop\Image\Gd,
    Pop\Image\Imagick,
    Pop\Pdf\Object;

/**
 * @category   Pop
 * @package    Pop_Pdf
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Image
{

    /**
     * Image object
     * @var mixed
     */
    protected $img = 0;

    /**
     * Image X Coordinate
     * @var array
     */
    protected $x = 0;

    /**
     * Image Y Coordinate
     * @var array
     */
    protected $y = 0;

    /**
     * PDF next index
     * @var array
     */
    protected $index = 0;

    /**
     * Image objects
     * @var array
     */
    protected $objects = array();

    /**
     * XObject string
     * @var string
     */
    protected $xobject = null;

    /**
     * Stream string
     * @var string
     */
    protected $stream = null;

    /**
     * Image data
     * @var string
     */
    protected $imageData = null;

    /**
     * Image data length
     * @var int
     */
    protected $imageDataLength = null;

    /**
     * Scaled image path
     * @var string
     */
    protected $scaledImage = null;

    /**
     * Converted image path
     * @var string
     */
    protected $convertedImage = null;

    /**
     * Constructor
     *
     * Instantiate a image parser object to be used by Pop_Pdf.
     *
     * @param  string  $img
     * @param  int     $x
     * @param  int     $y
     * @param  int     $i
     * @param  mixed   $scl
     * @param  boolean $preserveRes
     * @return void
     */
    public function __construct($img, $x, $y, $i, $scl = null, $preserveRes = false)
    {
        $this->x = $x;
        $this->y = $y;
        $this->index = $i;

        //$this->img = (Imagick::isImagickInstalled()) ? new Imagick($img) : new Gd($img);
        //$this->img = new Imagick($img);
        $this->img = new Gd($img);

        // If a scale value is passed, scale the image.
        if (null !== $scl) {
            if ($preserveRes) {
                $dims = $this->getScaledDimensions($scl);
                $imgWidth = $dims['w'];
                $imgHeight = $dims['h'];
            } else {
                $this->scaleImage($scl);
                $imgWidth = $this->img->getWidth();
                $imgHeight = $this->img->getHeight();
            }
        } else {
            $imgWidth = $this->img->getWidth();
            $imgHeight = $this->img->getHeight();
        }

        // Set the initial image data and data length.
        $this->imageData = $this->img->read();
        $this->imageDataLength = strlen($this->imageData);

        // If a JPEG, parse the JPEG
        if ($this->img->getMime() == 'image/jpeg') {
            $this->parseJpeg();
        // Else parse the PNG or GIF.
        } else if (($this->img->getMime() == 'image/png') || ($this->img->getMime() == 'image/gif')) {
            // If the image is a GIF, convert to a PNG and re-read image data.
            if ($this->img->getMime() == 'image/gif') {
                $this->convertImage();
            }
            $this->parsePng();
        } else {
            throw new Exception('Error: That image type is not supported. Only GIF, JPG and PNG image types are supported.');
        }

        // Define the xobject object and stream.
        $this->xobject = "/I{$this->index} {$this->index} 0 R";
        $this->stream = "\nq\n" . $imgWidth . " 0 0 " . $imgHeight. " {$this->x} {$this->y} cm\n/I{$this->index} Do\nQ\n";

        // Image clean-up.
        if ((null !== $this->scaledImage) && file_exists($this->scaledImage)) {
            unlink($this->scaledImage);
        }
        if ((null !== $this->convertedImage) && file_exists($this->convertedImage)) {
            unlink($this->convertedImage);
        }
    }

    /**
     * Method to get the image objects.
     *
     * @return array
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * Method to get the xobject string.
     *
     * @return string
     */
    public function getXObject()
    {
        return $this->xobject;
    }

    /**
     * Method to get the stream string.
     *
     * @return string
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Method to get scaled dimensions of the image, while preserving the resolution.
     *
     * @param mixed $scl
     * @throws Exception
     * @return array
     */
    protected function getScaledDimensions($scl)
    {
        // Scale or resize the image
        if (is_array($scl) && (isset($scl['w']) || isset($scl['h']))) {
            if (isset($scl['w'])) {
                $wid = $scl['w'];
                $scale = $wid / $this->img->getWidth();
                $hgt = round($this->img->getHeight() * $scale);
            } else if (isset($scl['h'])) {
                $hgt = $scl['h'];
                $scale = $hgt / $this->img->getHeight();
                $wid = round($this->img->getWidth() * $scale);
            }
        } else if (is_float($scl)) {
            $wid = round($this->img->getWidth() * $scl);
            $hgt = round($this->img->getHeight() * $scl);
        } else if (is_int($scl)) {
            $scale = ($this->img->getWidth() > $this->img->getHeight()) ? ($scl / $this->img->getWidth()) : ($scl / $this->img->getHeight());
            $wid = round($this->img->getWidth() * $scale);
            $hgt = round($this->img->getHeight() * $scale);
        } else {
            throw new Exception('Error: The image scale value is not valid.');
        }

        $dims = array('w' => $wid, 'h' => $hgt);

        return $dims;
    }

    /**
     * Method to scale or resize the image.
     *
     * @param mixed $scl
     * @throws Exception
     * @return void
     */
    protected function scaleImage($scl)
    {
        // Define the temp scaled image.
        $this->scaledImage = Dir::getUploadTemp() . DIRECTORY_SEPARATOR . $this->img->filename . '_' . time() . '.' . $this->img->ext;

        // Scale or resize the image
        if (is_array($scl) && (isset($scl['w']) || isset($scl['h']))) {
            if (isset($scl['w'])) {
                $this->img->resizeToWidth($scl['w']);
            } else if (isset($scl['h'])) {
                $this->img->resizeToHeight($scl['h']);
            }
        } else if (is_float($scl)) {
            $this->img->scale($scl);
        } else if (is_int($scl)) {
            $this->img->resize($scl);
        } else {
            throw new Exception('Error: The image scale value is not valid.');
        }

        // Save and clear the output buffer.
        $this->img->save($this->scaledImage);

        // Re-instantiate the newly scaled image object.
        $this->img = (Imagick::isImagickInstalled()) ? new Imagick($this->scaledImage) : new Gd($this->scaledImage);
    }

    /**
     * Method to convert the image.
     *
     * @return void
     */
    protected function convertImage()
    {
        // Define the temp converted image.
        $this->convertedImage = Dir::getUploadTemp() . DIRECTORY_SEPARATOR . $this->img->filename . '_' . time() . '.png';

        // Convert the GIF to PNG, save and clear the output buffer.
        $this->img->convert('png')->save($this->convertedImage);

        // Re-instantiate the newly converted image object and re-read the image data.
        $this->img = (Imagick::isImagickInstalled()) ? new Imagick($this->convertedImage) : new Gd($this->convertedImage);
        $this->imageData = $this->img->read();
    }

    /**
     * Method to parse the JPEG image.
     *
     * @return void
     */
    protected function parseJpeg()
    {
        // Add the image to the _objects array.
        $colorspace = ($this->img->getColorMode() == 'CMYK') ? "/DeviceCMYK\n    /Decode [1 0 1 0 1 0 1 0]" : "/Device" . $this->img->getColorMode();
        $this->objects[$this->index] = new Object("{$this->index} 0 obj\n<<\n    /Type /XObject\n    /Subtype /Image\n    /Width " . $this->img->getWidth() . "\n    /Height " . $this->img->getHeight() . "\n    /ColorSpace {$colorspace}\n    /BitsPerComponent 8\n    /Filter /DCTDecode\n    /Length {$this->imageDataLength}\n>>\nstream\n{$this->imageData}\nendstream\nendobj\n");
    }

    /**
     * Method to parse the PNG image.
     *
     * @throws Exception
     * @return void
     */
    protected function parsePng()
    {
        // Define some PNG image-specific variables.
        $PLTE = null;
        $TRNS = null;
        $mask_index = null;
        $mask = null;

        // Make sure the PNG does not contain a true alpha channel.
        if ($this->img->hasAlpha()) {
            throw new Exception('Error: PNG alpha channels are not supported. Only 8-bit transparent PNG images are supported.');
        }

        // Determine the PNG colorspace.
        if ($this->img->getColorMode() == 'Gray') {
            $colorspace = '/DeviceGray';
            $num_of_colors = 1;
        } else if ($this->img->getColorMode() == 'RGB') {
            $colorspace = '/DeviceRGB';
            $num_of_colors = 3;
        } else if ($this->img->getColorMode() == 'Indexed') {
            $colorspace = '/Indexed';
            $num_of_colors = 1;

            // If the PNG is indexed, parse and read the palette and any transparencies that might exist.
            if (strpos($this->imageData, 'PLTE') !== false) {
                // If a transparency exists, parse it and set the mask accordindly, along with the palette.
                if (strpos($this->imageData, 'tRNS') !== false) {
                    $PLTE = substr($this->imageData, (strpos($this->imageData, "PLTE") + 4), (strpos($this->imageData, "tRNS") - strpos($this->imageData, "PLTE") - 4));
                    $TRNS = substr($this->imageData, (strpos($this->imageData, "tRNS") + 4), (strpos($this->imageData, "IDAT") - strpos($this->imageData, "tRNS") - 4));
                    $mask_index = strpos($TRNS, chr(0));
                    $mask = "    /Mask [" . $mask_index . " " . $mask_index . "]\n";
                // Else, just set the palette.
                } else {
                    $PLTE = substr($this->imageData, (strpos($this->imageData, "PLTE") + 4), (strpos($this->imageData, "IDAT") - strpos($this->imageData, "PLTE") - 4));
                    $mask = '';
                }
            }

            $colorspace = "[/Indexed /DeviceRGB " . ($this->img->colorTotal() - 1) . " " . ($this->index + 1) . " 0 R]";
        }

        // Parse and set the PNG image data and data length.
        $IDAT = substr($this->imageData, (strpos($this->imageData, "IDAT") + 4), (strpos($this->imageData, "IEND") - strpos($this->imageData, "IDAT") - 4));
        $this->imageDataLength = strlen($IDAT);

        // Add the image to the _objects array.

        $this->objects[$this->index] = new Object("{$this->index} 0 obj\n<<\n    /Type /XObject\n    /Subtype /Image\n    /Width " . $this->img->getWidth() . "\n    /Height " . $this->img->getHeight() . "\n    /ColorSpace {$colorspace}\n    /BitsPerComponent " . $this->img->getDepth() . "\n    /Filter /FlateDecode\n    /DecodeParms <</Predictor 15 /Colors {$num_of_colors} /BitsPerComponent " . $this->img->getDepth() . " /Columns " . $this->img->getWidth() . ">>\n{$mask}    /Length {$this->imageDataLength}\n>>\nstream\n{$IDAT}\nendstream\nendobj\n");

        // If it exists, add the image palette to the _objects array.
        if ($PLTE != '') {
            $j = $this->index + 1;
            $this->objects[$j] = new Object("{$j} 0 obj\n<<\n    /Length " . strlen($PLTE) . "\n>>\nstream\n{$PLTE}\nendstream\nendobj\n");
            $this->objects[$j]->setPalette(true);
        }
    }

}