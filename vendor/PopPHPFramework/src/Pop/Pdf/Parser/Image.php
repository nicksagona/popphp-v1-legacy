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
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @category   Pop
 * @package    Pop_Pdf
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */

/**
 * @namespace
 */
namespace Pop\Pdf\Parser;
use Pop\Dir\Dir,
    Pop\Image\Gd,
    Pop\Pdf\Object;

class Image extends Gd
{

    /**
     * Image X Coordinate
     * @var array
     */
    protected $_x = 0;

    /**
     * Image Y Coordinate
     * @var array
     */
    protected $_y = 0;

    /**
     * PDF next index
     * @var array
     */
    protected $_index = 0;

    /**
     * Image objects
     * @var array
     */
    protected $_objects = array();

    /**
     * XObject string
     * @var string
     */
    protected $_xobject = null;

    /**
     * Stream string
     * @var string
     */
    protected $_stream = null;

    /**
     * Image data
     * @var string
     */
    protected $_imageData = null;

    /**
     * Image data length
     * @var int
     */
    protected $_imageDataLength = null;

    /**
     * Scaled image path
     * @var string
     */
    protected $_scaledImage = null;

    /**
     * Converted image path
     * @var string
     */
    protected $_convertedImage = null;

    /**
     * Constructor
     *
     * Instantiate a image parser object to be used by Pop_Pdf.
     *
     * @param  string    $img
     * @param  int       $x
     * @param  int       $y
     * @param  int       $i
     * @param  int|float $scl
     * @return void
     */
    public function __construct($img, $x, $y, $i, $scl = null)
    {

        $this->_x = $x;
        $this->_y = $y;
        $this->_index = $i;

        parent::__construct($img);

        // If a scale value is passed, scale the image.
        if (null !== $scl) {
            $this->_scaleImage($scl);
        }

        // Set the initial image data and data length.
        $this->_imageData = $this->read();
        $this->_imageDataLength = strlen($this->_imageData);

        // If a JPEG, parse the JPEG
        if ($this->_mime == 'image/jpeg') {
            $this->_parseJpeg();
        // Else parse the PNG or GIF.
        } else if (($this->_mime == 'image/png') || ($this->_mime == 'image/gif')) {
            // If the image is a GIF, convert to a PNG and re-read image data.
            if ($this->_mime == 'image/gif') {
                $this->_convertImage();
            }
            $this->_parsePng();
        } else {
            throw new Exception($this->_lang->__('Error: That image type is not supported. Only GIF, JPG and PNG image types are supported.'));
        }

        // Define the xobject object and stream.
        $this->_xobject = "/I{$this->_index} {$this->_index} 0 R";
        $this->_stream = "\nq\n" . $this->getWidth() . " 0 0 " . $this->getHeight() . " {$this->_x} {$this->_y} cm\n/I{$this->_index} Do\nQ\n";

        // Image clean-up.
        if ((null !== $this->_scaledImage) && file_exists($this->_scaledImage)) {
            unlink($this->_scaledImage);
        }
        if ((null !== $this->_convertedImage) && file_exists($this->_convertedImage)) {
            unlink($this->_convertedImage);
        }

    }

    /**
     * Method to get the image objects.
     *
     * @return array
     */
    public function getObjects()
    {

        return $this->_objects;

    }

    /**
     * Method to get the xobject string.
     *
     * @return string
     */
    public function getXObject()
    {

        return $this->_xobject;

    }

    /**
     * Method to get the stream string.
     *
     * @return string
     */
    public function getStream()
    {

        return $this->_stream;

    }

    /**
     * Method to scale or resize the image.
     *
     * @param $int|float $scl
     * @return void
     */
    protected function _scaleImage($scl)
    {

        // Define the temp scaled image.
        $this->_scaledImage = Dir::getUploadTemp() . DIRECTORY_SEPARATOR . $this->filename . '_' . time() . '.' . $this->ext;

        // Scale or resize the image
        if (is_float($scl)) {
            $this->scale($scl);
        } else {
            $this->resize($scl);
        }

        // Save and clear the output buffer.
        $this->save(100, $this->_scaledImage);
        $this->_output = null;

        // Re-instantiate the newly scaled image object.
        parent::__construct($this->_scaledImage);

    }

    /**
     * Method to convert the image.
     *
     * @return void
     */
    protected function _convertImage()
    {

        // Define the temp converted image.
        $this->_convertedImage = Dir::getUploadTemp() . DIRECTORY_SEPARATOR . $this->filename . '_' . time() . '.png';

        // Convert the GIF to PNG, save and clear the output buffer.
        $this->convert('png')->save(null, $this->_convertedImage);
        $this->_output = null;

        // Re-instantiate the newly converted image object and re-read the image data.
        parent::__construct($this->_convertedImage);
        $this->_imageData = $this->read();

    }

    /**
     * Method to parse the JPEG image.
     *
     * @return void
     */
    protected function _parseJpeg()
    {

        // Add the image to the _objects array.
        $colorspace = ($this->getColorMode() == 'CMYK') ? "/DeviceCMYK\n    /Decode [1 0 1 0 1 0 1 0]" : "/Device" . $this->getColorMode();
        $this->_objects[$this->_index] = new Object("{$this->_index} 0 obj\n<<\n    /Type /XObject\n    /Subtype /Image\n    /Width " . $this->getWidth() . "\n    /Height " . $this->getHeight() . "\n    /ColorSpace {$colorspace}\n    /BitsPerComponent 8\n    /Filter /DCTDecode\n    /Length {$this->_imageDataLength}\n>>\nstream\n{$this->_imageData}\nendstream\nendobj\n");

    }

    /**
     * Method to parse the PNG image.
     *
     * @throws Exception
     * @return void
     */
    protected function _parsePng()
    {

        // Define some PNG image-specific variables.
        $PLTE = null;
        $TRNS = null;
        $mask_index = null;
        $mask = null;

        // Make sure the PNG does not contain a true alpha channel.
        if ($this->alpha) {
            throw new Exception($this->_lang->__('Error: PNG alpha channels are not supported. Only 8-bit transparent PNG images are supported.'));
        }

        // Determine the PNG colorspace.
        if ($this->getColorMode() == 'Gray') {
            $colorspace = '/DeviceGray';
            $num_of_colors = 1;
        } else if ($this->getColorMode() == 'RGB') {
            $colorspace = '/DeviceRGB';
            $num_of_colors = 3;
        } else if ($this->getColorMode() == 'Indexed') {
            $colorspace = '/Indexed';
            $num_of_colors = 1;

            // If the PNG is indexed, parse and read the palette and any transparencies that might exist.
            if (strpos($this->_imageData, 'PLTE') !== false) {
                // If a transparency exists, parse it and set the mask accordindly, along with the palette.
                if (strpos($this->_imageData, 'tRNS') !== false) {
                    $PLTE = substr($this->_imageData, (strpos($this->_imageData, "PLTE") + 4), (strpos($this->_imageData, "tRNS") - strpos($this->_imageData, "PLTE") - 4));
                    $TRNS = substr($this->_imageData, (strpos($this->_imageData, "tRNS") + 4), (strpos($this->_imageData, "IDAT") - strpos($this->_imageData, "tRNS") - 4));
                    $mask_index = strpos($TRNS, chr(0));
                    $mask = "    /Mask [" . $mask_index . " " . $mask_index . "]\n";
                // Else, just set the palette.
                } else {
                    $PLTE = substr($this->_imageData, (strpos($this->_imageData, "PLTE") + 4), (strpos($this->_imageData, "IDAT") - strpos($this->_imageData, "PLTE") - 4));
                    $mask = '';
                }
            }

            $colorspace = "[/Indexed /DeviceRGB " . ($this->colorTotal() - 1) . " " . ($this->_index + 1) . " 0 R]";
        }

        // Parse and set the PNG image data and data length.
        $IDAT = substr($this->_imageData, (strpos($this->_imageData, "IDAT") + 4), (strpos($this->_imageData, "IEND") - strpos($this->_imageData, "IDAT") - 4));
        $this->_imageDataLength = strlen($IDAT);

        // Add the image to the _objects array.

        $this->_objects[$this->_index] = new Object("{$this->_index} 0 obj\n<<\n    /Type /XObject\n    /Subtype /Image\n    /Width " . $this->getWidth() . "\n    /Height " . $this->getHeight() . "\n    /ColorSpace {$colorspace}\n    /BitsPerComponent " . $this->getDepth() . "\n    /Filter /FlateDecode\n    /DecodeParms <</Predictor 15 /Colors {$num_of_colors} /BitsPerComponent " . $this->getDepth() . " /Columns " . $this->getWidth() . ">>\n{$mask}    /Length {$this->_imageDataLength}\n>>\nstream\n{$IDAT}\nendstream\nendobj\n");

        // If it exists, add the image palette to the _objects array.
        if ($PLTE != '') {
            $j = $this->_index + 1;
            $this->_objects[$j] = new Object("{$j} 0 obj\n<<\n    /Length " . strlen($PLTE) . "\n>>\nstream\n{$PLTE}\nendstream\nendobj\n");
            $this->_objects[$j]->setPalette(true);
        }

    }

}