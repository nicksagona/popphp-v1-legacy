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
 * @package    Pop_Image
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @category   Pop
 * @package    Pop_Image
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */

/**
 * @namespace
 */
namespace Pop\Image;
use Pop\Color\ColorInterface,
    Pop\Color\Rgb,
    Pop\Http\Response,
    Pop\Image\AbstractImage;

class Gd extends AbstractImage
{

    /**
     * GD info
     * @var ArrayObject
     */
    public $gd = null;

    /**
     * Array of allowed file types.
     * @var array
     */
    protected $_allowed = array('gif'  => 'image/gif',
                                'jpe'  => 'image/jpeg',
                                'jpg'  => 'image/jpeg',
                                'jpeg' => 'image/jpeg',
                                'png'  => 'image/png');

    /**
     * Image color opacity
     * @var int
     */
    protected $_opacity = 0;

    /**
     * Constructor
     *
     * Instantiate an image file object based on either a pre-existing
     * image file on disk, or a new image file.
     *
     * @param  string     $img
     * @param  int|string $w
     * @param  int|string $h
     * @param  mixed      $color
     * @param  array      $types
     * @throws Exception
     * @return void
     */
    public function __construct($img, $w = null, $h = null, ColorInterface $color = null, $types = null)
    {
        parent::__construct($img, $types);

        // Check to see if GD is installed.
        if (!self::isGdInstalled()) {
            throw new Exception($this->_lang->__('Error: The GD library extension must be installed to use the Pop_Image_Gd component.'));
        } else {
            $this->_getGdInfo();

            // If image exists, get image info and store in an array.
            if (file_exists($this->fullpath) && ($this->_size > 0)) {
                $imgSize = getimagesize($img);

                // Set image object properties.
                $this->_width = $imgSize[0];
                $this->_height = $imgSize[1];
                $this->_channels = (isset($imgSize['channels'])) ? $imgSize['channels'] : null;
                $this->_depth = (isset($imgSize['bits'])) ? $imgSize['bits'] : null;
                $this->setQuality(100);

                // If the image is a GIF
                if ($this->_mime == 'image/gif') {
                    $this->_mode = 'Indexed';
                // Else if the image is a PNG
                } else if ($this->_mime == 'image/png') {
                    $imgData = $this->read();
                    $colorType = ord($imgData[25]);
                    switch ($colorType) {
                        case 0:
                            $this->_channels = 1;
                            $this->_mode = 'Gray';
                            break;
                        case 2:
                            $this->_channels = 3;
                            $this->_mode = 'RGB';
                            break;
                        case 3:
                            $this->_channels = 3;
                            $this->_mode = 'Indexed';
                            break;
                        case 4:
                            $this->_channels = 1;
                            $this->_mode = 'Gray';
                            $this->_alpha = true;
                            break;
                        case 6:
                            $this->_channels = 3;
                            $this->_mode = 'RGB';
                            $this->_alpha = true;
                            break;
                    }
                // Else if the image is a JPEG.
                } else if ($this->_channels == 1) {
                    $this->_mode = 'Gray';
                } else if ($this->_channels == 3) {
                    $this->_mode = 'RGB';
                } else if ($this->_channels == 4) {
                    $this->_mode = 'CMYK';
                }
            // If image does not exists, check to make sure the width and
            // height properties of the new image have been passed.
            } else {
                if ((null === $w) || (null === $h)) {
                    throw new Exception($this->_lang->__('Error: You must define a width and height for a new image object.'));
                } else {
                    // Set image object properties.
                    $this->_width = $w;
                    $this->_height = $h;
                    $this->_channels = null;

                    // Create a new image and allocate the background color.
                    if ($this->_mime == 'image/gif') {
                        $this->_resource = imagecreate($w, $h);
                        $this->setBackgroundColor((null === $color) ? new Rgb(255, 255, 255) : $color);
                        $clr = $this->_setColor($this->_backgroundColor);
                    } else {
                        $this->_resource = imagecreatetruecolor($w, $h);
                        $this->setBackgroundColor((null === $color) ? new Rgb(255, 255, 255) : $color);
                        $clr = $this->_setColor($this->_backgroundColor);
                        imagefill($this->_resource, 0, 0, $clr);
                    }

                    // Set the quality and create a new, blank image file.
                    unset($clr);
                    $this->setQuality(100);
                    $this->_output = $this->_resource;
                }
            }
        }
    }

    /**
     * Check if GD is installed.
     *
     * @return boolean
     */
    public static function isGdInstalled()
    {
        return function_exists('gd_info');
    }

    /**
     * Set the image quality based on the type of image.
     *
     * @param  int|string $q
     * @return Pop_Image
     */
    public function setQuality($q = null)
    {
        switch ($this->_mime) {
            case 'image/png':
                $this->_quality = ($q < 10) ? 9 : 10 - round(($q / 10), PHP_ROUND_HALF_DOWN);
                break;
            case 'image/jpeg':
                $this->_quality = round($q);
                break;
            default:
                $this->_quality = null;
        }

        return $this;
    }

    /**
     * Set the opacity.
     *
     * @param  int|string $opac
     * @return Pop_Image
     */
    public function setOpacity($opac)
    {
        $this->_opacity = round((127 - (127 * ($opac / 100))));
        return $this;
    }

    /**
     * Resize the image object to the width parameter passed.
     *
     * @param  int|string $wid
     * @return mixed
     */
    public function resizeToWidth($wid)
    {
        $scale = $wid / $this->_width;
        $hgt = round($this->_height * $scale);

        // Create a new image output resource.
        $this->_createResource();
        $this->_output = imagecreatetruecolor($wid, $hgt);

        // Copy newly sized image to the output resource.
        $this->_copyImage($wid, $hgt);

        return $this;
    }

    /**
     * Resize the image object to the height parameter passed.
     *
     * @param  int|string $hgt
     * @return mixed
     */
    public function resizeToHeight($hgt)
    {
        $scale = $hgt / $this->_height;
        $wid = round($this->_width * $scale);

        // Create a new image output resource.
        $this->_createResource();
        $this->_output = imagecreatetruecolor($wid, $hgt);

        // Copy newly sized image to the output resource.
        $this->_copyImage($wid, $hgt);

        return $this;
    }

    /**
     * Resize the image object, allowing for the largest dimension to be scaled
     * to the value of the $px argument. For example, if the value of $px = 200,
     * and the image is 800px X 600px, then the image will be scaled to
     * 200px X 150px.
     *
     * @param  int|string $px
     * @return Pop_Image
     */
    public function resize($px)
    {
        // Determine whether or not the image is landscape or portrait and set
        // the scale, new width and new height accordingly, with the largest
        // dimension being scaled to the value of the $px argument.
        $scale = ($this->_width > $this->_height) ? ($px / $this->_width) : ($px / $this->_height);

        $wid = round($this->_width * $scale);
        $hgt = round($this->_height * $scale);

        // Create a new image output resource.
        $this->_createResource();
        $this->_output = imagecreatetruecolor($wid, $hgt);

        // Copy newly sized image to the output resource.
        $this->_copyImage($wid, $hgt);

        return $this;
    }

    /**
     * Scale the image object, allowing for the dimensions to be scaled
     * proportionally to the value of the $scl argument. For example, if the
     * value of $scl = 0.50, and the image is 800px X 600px, then the image
     * will be scaled to 400px X 300px.
     *
     * @param  float|string $scl
     * @return Pop_Image
     */
    public function scale($scl)
    {
        // Determine the new width and height of the image based on the
        // value of the $scl argument.
        $wid = round($this->_width * $scl);
        $hgt = round($this->_height * $scl);

        // Create a new image output resource.
        $this->_createResource();
        $this->_output = imagecreatetruecolor($wid, $hgt);

        // Copy newly sized image to the output resource.
        $this->_copyImage($wid, $hgt);

        return $this;
    }

    /**
     * Crop the image object to a image whose dimensions are based on the
     * value of the $wid and $hgt argument. The optional $x and $y arguments
     * allow for the adjustment of the crop to select a certain area of the
     * image to be cropped.
     *
     * @param  int|string $wid
     * @param  int|string $hgt
     * @param  int|string $x
     * @param  int|string $y
     * @return mixed
     */
    public function crop($wid, $hgt, $x = 0, $y = 0)
    {
        // Create a new image output resource.
        $this->_createResource();
        $this->_output = imagecreatetruecolor($wid, $hgt);

        // Copy newly sized image to the output resource.
        $this->_copyImage($this->_width, $this->_height, $x, $y);

        return $this;
    }

    /**
     * Crop the image object to a square image whose dimensions are based on the
     * value of the $px argument. The optional $x and $y arguments allow for the
     * adjustment of the crop to select a certain area of the image to be
     * cropped. For example, if the values of $px = 50, $x = 20, $y = 0 are
     * passed, then a 50px X 50px image will be created from the original image,
     * with its origins starting at the (20, 0) x-y coordinates.
     *
     * @param  int|string $px
     * @param  int|string $x
     * @param  int|string $y
     * @return Pop_Image
     */
    public function cropThumb($px, $x = 0, $y = 0)
    {
        // Determine whether or not the image is landscape or portrait and set
        // the scale, new width and new height accordingly, with the smallest
        // dimension being scaled to the value of the $px argument to allow
        // for a complete crop.
        $scale = ($this->_width > $this->_height) ? ($px / $this->_height) : ($px / $this->_width);

        $wid = round($this->_width * $scale);
        $hgt = round($this->_height * $scale);

        // Create a new image output resource.
        $this->_createResource();
        $this->_output = imagecreatetruecolor($px, $px);

        // Copy newly sized image to the output resource.
        $this->_copyImage($wid, $hgt, $x, $y);

        return $this;
    }

    /**
     * Rotate the image object, using simple degrees, i.e. -90,
     * to rotate the image.
     *
     * @param  int|string $deg
     * @return Pop_Image
     */
    public function rotate($deg)
    {
        // Create a new image resource and rotate it.
        $this->_createResource();
        $color = $this->_setColor($this->_backgroundColor);
        $this->_output = imagerotate($this->_resource, $deg, $color);
        $this->_resource = $this->_output;

        return $this;
    }

    /**
     * Create text within the an image object and output it. A true-type font
     * file is required for the font argument. The size, rotation and position
     * can be set by those respective arguments. This is a useful method for
     * creating CAPTCHA images or rendering sensitive information to the user
     * that cannot or should not be rendered by HTML (i.e. email addresses.)
     *
     * @param  string     $str
     * @param  int|string $size
     * @param  int|string $x
     * @param  int|string $y
     * @param  string     $font
     * @param  int|string $rotate
     * @param  boolean    $stroke
     * @return Pop_Image
     */
    public function text($str, $size, $x, $y, $font = null, $rotate = null, $stroke = false)
    {
        // Set the image resource and color.
        $this->_createResource();
        $color = $this->_setColor($this->_fillColor);

        // Write the text to the image.
        if ((null !== $font) && function_exists('imagettftext')) {
            if ($stroke) {
                $stroke = $this->_setColor($this->_strokeColor);
                imagettftext($this->_resource, $size, $rotate, $x, ($y - 1), $stroke, $font, $str);
                imagettftext($this->_resource, $size, $rotate, $x, ($y + 1), $stroke, $font, $str);
                imagettftext($this->_resource, $size, $rotate, ($x - 1), $y, $stroke, $font, $str);
                imagettftext($this->_resource, $size, $rotate, ($x + 1), $y, $stroke, $font, $str);
            }
            imagettftext($this->_resource, $size, $rotate, $x, $y, $color, $font, $str);
        } else {
            imagestring($this->_resource, $size, $x, $y,  $str, $color);
        }

        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to add a line to the image.
     *
     * @param  int $x1
     * @param  int $y1
     * @param  int $x2
     * @param  int $y2
     * @return Pop_Image
     */
    public function addLine($x1, $y1, $x2, $y2)
    {
        // Create an image resource and set the stroke color.
        $this->_createResource();

        $strokeWidth = (null === $this->_strokeWidth) ? 1 : $this->_strokeWidth;
        $strokeColor = (null === $this->_strokeColor) ? $this->_setColor(new Rgb(0, 0, 0)) : $this->_setColor($this->_strokeColor);

        // Draw the line.
        imagesetthickness($this->_resource, $strokeWidth);
        imageline($this->_resource, $x1, $y1, $x2, $y2, $strokeColor);
        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to add a rectangle to the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @return Pop_Image
     */
    public function addRectangle($x, $y, $w, $h = null)
    {
        $x2 = $x + $w;
        $y2 = $y + ((null === $h) ? $w : $h);

        // Create an image resource.
        $this->_createResource();

        // Set fill color and create rectangle.
        if ((null === $this->_fillColor) && (null === $this->_backgroundColor)) {
            $fill = $this->_setColor(new Rgb(255, 255, 255));
        } else if (null === $this->_fillColor) {
            $fill = $this->_setColor($this->_backgroundColor);
        } else {
            $fill = $this->_setColor($this->_fillColor);
        }

        imagefilledrectangle($this->_resource, $x, $y, $x2, $y2, $fill);

            // Create stroke, if applicable.
        if (null !== $this->_strokeColor) {
            $stroke = $this->_setColor($this->_strokeColor);
            if (null === $this->_strokeWidth) {
                $this->_strokeWidth = 1;
            }
            imagesetthickness($this->_resource, $this->_strokeWidth);
            imagerectangle($this->_resource, $x, $y, $x2, $y2, $stroke);
        }
        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to add a square to the image.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @return Pop_Image
     */
    public function addSquare($x, $y, $w)
    {
        $this->addRectangle($x, $y, $w, $w);
        return $this;
    }

    /**
     * Method to add an ellipse to the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @return Pop_Image
     */
    public function addEllipse($x, $y, $w, $h = null)
    {
        $wid = $w * 2;
        $hgt = ((null === $h) ? $w : $h) * 2;

        // Create an image resource.
        $this->_createResource();

        // Create stroke, if applicable.
        if (null !== $this->_strokeColor) {
            $stroke = $this->_setColor($this->_strokeColor);
            if (null === $this->_strokeWidth) {
                $this->_strokeWidth = 1;
            }
            imagefilledellipse($this->_resource, $x, $y, ($wid + $this->_strokeWidth), ($hgt + $this->_strokeWidth), $stroke);
        }

        // Set fill color and create ellipse.
        if ((null === $this->_fillColor) && (null === $this->_backgroundColor)) {
            $fill = $this->_setColor(new Rgb(255, 255, 255));
        } else if (null === $this->_fillColor) {
            $fill = $this->_setColor($this->_backgroundColor);
        } else {
            $fill = $this->_setColor($this->_fillColor);
        }

        imagefilledellipse($this->_resource, $x, $y, $wid, $hgt, $fill);

        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to add a circle to the image.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @return Pop_Image
     */
    public function addCircle($x, $y, $w)
    {
        $this->addEllipse($x, $y, $w, $w);
       return $this;

    }

    /**
     * Method to add an arc to the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @return Pop_Image
     */
    public function addArc($x, $y, $start, $end, $w, $h = null)
    {
        $wid = $w * 2;
        $hgt = ((null === $h) ? $w : $h) * 2;

        // Create an image resource.
        $this->_createResource();

        // Set fill color and create rectangle.
        if ((null === $this->_fillColor) && (null === $this->_backgroundColor)) {
            $fill = $this->_setColor(new Rgb(255, 255, 255));
        } else if (null === $this->_fillColor) {
            $fill = $this->_setColor($this->_backgroundColor);
        } else {
            $fill = $this->_setColor($this->_fillColor);
        }

        imagefilledarc($this->_resource, $x, $y, $wid, $hgt, $start, $end, $fill, IMG_ARC_PIE);

        // Create stroke, if applicable.
        if (null !== $this->_strokeColor) {
            $x1 = $w * cos($start / 180 * pi());
            $y1 = $h * sin($start / 180 * pi());
            $x2 = $w * cos($end / 180 * pi());
            $y2 = $h * sin($end / 180 * pi());

            $stroke = $this->_setColor($this->_strokeColor);

            if (null === $this->_strokeWidth) {
                $this->_strokeWidth = 1;
            }

            imagesetthickness($this->_resource, $this->_strokeWidth);
            imagearc($this->_resource, $x, $y, $wid, $hgt, $start, $end, $stroke);
            imageline($this->_resource, $x, $y, $x + $x1, $y + $y1, $stroke);
            imageline($this->_resource, $x, $y, $x + $x2, $y + $y2, $stroke);
        }

        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to add a polygon to the image.
     *
     * @param  array $points
     * @return Pop_Image
     */
    public function addPolygon($points)
    {
        $realPoints = array();
        foreach ($points as $coord) {
            if (isset($coord['x']) && isset($coord['y'])) {
                $realPoints[] = $coord['x'];
                $realPoints[] = $coord['y'];
            }
        }

        // Create an image resource.
        $this->_createResource();

        // Set fill color and create rectangle.
        if ((null === $this->_fillColor) && (null === $this->_backgroundColor)) {
            $fill = $this->_setColor(new Rgb(255, 255, 255));
        } else if (null === $this->_fillColor) {
            $fill = $this->_setColor($this->_backgroundColor);
        } else {
            $fill = $this->_setColor($this->_fillColor);
        }

        imagefilledpolygon($this->_resource, $realPoints, count($points), $fill);

        // Create stroke, if applicable.
        if (null !== $this->_strokeColor) {
            $stroke = $this->_setColor($this->_strokeColor);
            if (null === $this->_strokeWidth) {
                $this->_strokeWidth = 1;
            }
            imagesetthickness($this->_resource, $this->_strokeWidth);
            imagepolygon($this->_resource, $realPoints, count($points), $stroke);
        }

        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to adjust the brightness of the image.
     *
     * @param  int $b
     * @return Pop_Image
     */
    public function brightness($b)
    {
        // Create an image resource.
        $this->_createResource();
        imagefilter($this->_resource, IMG_FILTER_BRIGHTNESS, $b);
        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to adjust the contrast of the image.
     *
     * @param  int $amount
     * @return Pop_Image
     */
    public function contrast($amount)
    {
        // Create an image resource.
        $this->_createResource();
        imagefilter($this->_resource, IMG_FILTER_CONTRAST, (0 - $amount));
        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to desaturate the image.
     *
     * @return Pop_Image
     */
    public function desaturate()
    {
        // Create an image resource.
        $this->_createResource();
        imagefilter($this->_resource, IMG_FILTER_GRAYSCALE);
        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to sharpen the image.
     *
     * @param  int amount
     * @return Pop_Image
     */
    public function sharpen($amount)
    {
        // Create an image resource.
        $this->_createResource();
        imagefilter($this->_resource, IMG_FILTER_SMOOTH, (0 - $amount));
        $this->_output = $this->_resource;

        return $this;
    }
    /**
     * Method to blur the image.
     *
     * @param  int $amount
     * @param  int $type
     * @return Pop_Image
     */
    public function blur($amount, $type = Gd::GAUSSIAN_BLUR)
    {
        // Create an image resource.
        $this->_createResource();
        $blurType = ($type == self::GAUSSIAN_BLUR) ? IMG_FILTER_GAUSSIAN_BLUR : IMG_FILTER_SELECTIVE_BLUR;

        for ($i = 1; $i <= $amount; $i++) {
            imagefilter($this->_resource, $blurType);
        }

        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to add a border to the image.
     *
     * @param  int $w
     * @param  int $h
     * @param  int $type
     * @return Pop_Image
     */
    public function border($w, $h = null, $type = Gd::INNER_BORDER)
    {
        $h = (null === $h) ? $w : $h;

        $this->_fillColor = $this->_strokeColor;
        $this->setOpacity(100);

        if ($type == self::INNER_BORDER) {
            $this->addRectangle(0, 0, $this->_width, $h);
            $this->addRectangle(0, ($this->_height - $h), $this->_width, $this->_height);
            $this->addRectangle(0, 0, $w, $this->_height);
            $this->addRectangle(($this->_width - $w), 0, $this->_width, $this->_height);
        } else {
            $newWidth = $this->_width + ($w * 2);
            $newHeight = $this->_height + ($h * 2);
            $this->_createResource();
            $oldResource = $this->_resource;
            $this->_resource = imagecreatetruecolor($newWidth, $newHeight);
            $color = $this->_setColor($this->_fillColor);
            imagefill($this->_resource, 0, 0, $color);
            imagealphablending($this->_resource, true);
            imagecopy($this->_resource, $oldResource, $w, $h, 0, 0, imagesx($oldResource), imagesy($oldResource));
            $this->_output = $this->_resource;
        }

        return $this;
    }

    /**
     * Overlay an image onto the current image.
     *
     * @param  string     $ovr
     * @param  int|string $x
     * @param  int|string $y
     * @return Pop_Image
     */
    public function overlay($ovr, $x = 0, $y = 0)
    {
        // Create image resource and turn on alpha blending
        $this->_createResource();
        imagealphablending($this->_resource, true);

        // Create an image resource from the overlay image.
        if (stripos($ovr, '.gif') !== false) {
            $overlay = imagecreatefromgif($ovr);
        } else if (stripos($ovr, '.png') !== false) {
            $overlay = imagecreatefrompng($ovr);
        } else if (stripos($ovr, '.jp') !== false) {
            $overlay = imagecreatefromjpeg($ovr);
        }

        // Copy the overlay image ontop of the main image resource.
        imagecopy($this->_resource, $overlay, $x, $y, 0, 0, imagesx($overlay), imagesy($overlay));

        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to colorize the image with the color passed.
     *
     * @param  mixed $color
     * @return Pop_Image
     */
    public function colorize(ColorInterface $color)
    {
        // Create an image resource.
        $this->_createResource();
        imagefilter($this->_resource, IMG_FILTER_COLORIZE, $color->getRed(), $color->getGreen(), $color->getBlue());
        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Method to invert the image (create a negative.)
     *
     * @return Pop_Image
     */
    public function invert()
    {
        // Create an image resource.
        $this->_createResource();
        imagefilter($this->_resource, IMG_FILTER_NEGATE);
        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Apply a mosiac pixelate effect to the image
     *
     * @param  int $px
     * @return Pop_Image
     */
    public function pixelate($px)
    {
        // Create an image resource.
        $this->_createResource();
        imagefilter($this->_resource, IMG_FILTER_PIXELATE, $px, true);
        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Apply a pencil/sketch effect to the image
     *
     * @return Pop_Image
     */
    public function pencil()
    {
        // Create an image resource.
        $this->_createResource();
        imagefilter($this->_resource, IMG_FILTER_MEAN_REMOVAL);
        $this->_output = $this->_resource;

        return $this;
    }

    /**
     * Return the number of colors in the palette of indexed images.
     * Returns 0 for true color images.
     *
     * @return int
     */
    public function colorTotal()
    {
        // Set the image resource and get the total number of colors.
        $this->_createResource();
        $colors = imagecolorstotal($this->_resource);

        // Destroy the image resource.
        $this->destroy();

        return $colors;
    }

    /**
     * Return all of the colors in the palette in an array format, omitting any
     * repeats. It is strongly advised that this method only be used for smaller
     * image files, preferably with small palettes, as any large images with
     * many colors will cause this method to run slowly. Default format of the
     * values in the returned array is the 6-digit HEX value, but if 'RGB' is
     * passed, then the format of the values in the returned array will be
     * 'R,G,B', i.e. '235,123,12'.
     *
     * @param  string $format
     * @return array
     */
    public function getColors($format = 'HEX')
    {
        // Initialize the colors array and the image resource.
        $colors = array();
        $this->_createResource();

        // Loop through each pixel of the image, recording the color result
        // in the color array.
        for ($h = 0; $h < $this->_height; $h++) {
            for ($w = 0; $w < $this->_width; $w++) {
                // Get the color index at the pixel location, translating
                // into human readable form.
                $color_index = imagecolorat($this->_resource, $w, $h);
                $color_trans = imagecolorsforindex($this->_resource, $color_index);

                // Convert to the proper HEX or RGB format.
                if ($format == 'HEX') {
                    $rgb = sprintf('%02s', dechex($color_trans['red'])) . sprintf('%02s', dechex($color_trans['green'])) . sprintf('%02s', dechex($color_trans['blue']));
                } else {
                    $rgb = $color_trans['red'] . "," . $color_trans['green'] . "," . $color_trans['blue'];
                }

                // If the color is not already in the array, add to it.
                if (!in_array($rgb, $colors)) {
                    $colors[] = $rgb;
                }
            }
        }

        // Destroy the image resource.
        $this->destroy();

        // Return the colors array.
        return $colors;
    }

    /**
     * Convert the image object to the new specified image type.
     *
     * @param  string     $type
     * @throws Exception
     * @return Pop_Image
     */
    public function convert($type)
    {
        $type = strtolower($type);

        // Check if the permissions are set correctly.
        if ((null !== $this->_perm['file']) && ($this->_perm['file'] != 777)) {
            throw new Exception($this->_lang->__('Error: Permission denied.'));
        // Check if the requested image type is supported.
        } else if (!array_key_exists($type, $this->_allowed)) {
            throw new Exception($this->_lang->__('Error: That image type is not supported. Only GIF, JPG and PNG image types are supported.'));
        // Check if the image is already the requested image type.
        } else if (strtolower($this->ext) == $type) {
            throw new Exception($this->_lang->__('Error: This image file is already a %1 image file.', strtoupper($type)));
        // Else, save the image as the new type.
        } else {
            // Open a new image, maintaining the GIF image's palette and
            // transparency where applicable.
            if ($this->_mime == 'image/gif') {
                $this->_createResource();
                imageinterlace($this->_resource, 0);

                // Change the type of the image object to the new,
                // requested image type.
                $this->ext = $type;
                $this->_mime = $this->_allowed[$this->ext];

                // Redefine the image object properties with the new values.
                $this->fullpath = $this->dir . $this->filename . '.' . $this->ext;
                $this->basename = basename($this->fullpath);

            // Else, open a new true color image.
            } else {
                if ($type == 'gif') {
                    $this->_createResource();

                    // Change the type of the image object to the new,
                    // requested image type.
                    $this->ext = $type;
                    $this->_mime = $this->_allowed[$this->ext];

                    // Redefine the image object properties with the new values.
                    $this->fullpath = $this->dir . $this->filename . '.' . $this->ext;
                    $this->basename = basename($this->fullpath);
                } else {
                    $new = imagecreatetruecolor($this->_width, $this->_height);

                    // Create a new, blank image file and copy the image over.
                    $this->_createResource();

                    // Change the type of the image object to the new,
                    // requested image type.
                    $this->ext = $type;
                    $this->_mime = $this->_allowed[$this->ext];

                    // Redefine the image object properties with the new values.
                    $this->fullpath = $this->dir . $this->filename . '.' . $this->ext;
                    $this->basename = basename($this->fullpath);

                    // Create and save the image in it's new, proper format.
                    imagecopyresampled($new, $this->_resource, 0, 0, 0, 0, $this->_width, $this->_height, $this->_width, $this->_height);
                }
            }

            return $this;
        }
    }

    /**
     * Output the image object directly.
     *
     * @param  boolean $download
     * @return Pop_Image
     */
    public function output($download = false)
    {
        // Determine if the force download argument has been passed.
        $attach = ($download) ? 'attachment; ' : null;
        $headers = array(
                       'Content-type' => $this->_mime,
                       'Content-disposition' => $attach . 'filename=' . $this->basename
                   );

        $response = new Response(200, $headers);

        if ($_SERVER['SERVER_PORT'] == 443) {
            $response->setSslHeaders();
        }

        if (null === $this->_resource) {
            $this->_createResource();
        }

        if (null === $this->_output) {
            $this->_output = $this->_resource;
        }

        // Create the image resource and output it
        $response->sendHeaders();
        $this->_createImage($this->_output, null, $this->_quality);

        // Destroy the image resource.
        $this->destroy();

        return $this;
    }

    /**
     * Save the image object to disk.
     *
     * @param  string  $to
     * @param  boolean $append
     * @return void
     */
    public function save($to = null, $append = false)
    {
        if ((null === $this->_output) && (null === $this->_resource)) {
            throw new Exception($this->_lang->__('Error: The image resource has not been created.'));
        } else {
            if (null === $this->_output) {
                $this->_output = $this->_resource;
            }

            $this->_createImage($this->_output, ((null === $to) ? $this->fullpath : $to), $this->_quality);
            clearstatcache();

            $this->_setFile((null === $to) ? $this->fullpath : $to);

            $imgSize = getimagesize($this->fullpath);

            // Set image object properties.
            $this->_width = $imgSize[0];
            $this->_height = $imgSize[1];
            $this->_channels = (isset($imgSize['channels'])) ? $imgSize['channels'] : null;

            return $this;
        }
    }

    /**
     * Destroy the image object and the related image file directly.
     *
     * @param  boolean $file
     * @return void
     */
    public function destroy($file = false)
    {
        // Destroy the image resource.
        if (null !== $this->_resource) {
            if (!is_string($this->_resource)) {
                imagedestroy($this->_resource);
            }
            $this->_resource = null;
        }
        // Destroy the image output resource.
        if (null !== $this->_output) {
            if (!is_string($this->_output)) {
                imagedestroy($this->_output);
            }
            $this->_output = null;
        }

        // Clear PHP's file status cache.
        clearstatcache();

        // If the $file flag is passed, delete the image file.
        if ($file) {
            $this->delete();
        }
    }

    /**
     * Get GD Info.
     *
     * @return void
     */
    protected function _getGdInfo()
    {
        $gd = gd_info();
        $gdInfo = array('version'             => $gd['GD Version'],
                        'freeTypeSupport'     => $gd['FreeType Support'],
                        'freeTypeLinkage'     => $gd['FreeType Linkage'],
                        't1LibSupport'        => $gd['T1Lib Support'],
                        'gifReadSupport'      => $gd['GIF Read Support'],
                        'gifCreateSupport'    => $gd['GIF Create Support'],
                        'jpegSupport'         => $gd['JPEG Support'],
                        'pngSupport'          => $gd['PNG Support'],
                        'wbmpSupport'         => $gd['WBMP Support'],
                        'xpmSupport'          => $gd['XPM Support'],
                        'xbmSupport'          => $gd['XBM Support'],
                        'japaneseFontSupport' => $gd['JIS-mapped Japanese Font Support']);

        $this->gd = new \ArrayObject($gdInfo, \ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * Set and return a color identifier.
     *
     * @param  mixed $color
     * @throws Exception
     * @return mixed
     */
    protected function _setColor(ColorInterface $color = null)
    {
        if (null === $this->_resource) {
            throw new Exception($this->_lang->__('Error: The image resource has not been created.'));
        } else {
            $opac = (null === $this->_opacity) ? 0 : $this->_opacity;
            if (null !== $color) {
                $color = imagecolorallocatealpha($this->_resource, (int)$color->getRed(), (int)$color->getGreen(), (int)$color->getBlue(), $opac);
            } else {
                $color = imagecolorallocatealpha($this->_resource, 0, 0, 0, $opac);
            }
        }

        return $color;
    }

    /**
     * Create a new image resource based on the current image type
     * of the image object.
     *
     * @return void
     */
    protected function _createResource()
    {
        if (null !== $this->_output) {
            $this->_resource = (is_string($this->_output)) ? imagecreatefromstring($this->_output) : $this->_output;
        } else if (file_exists($this->fullpath)) {
            switch ($this->_mime) {
                case 'image/gif':
                    $this->_resource = imagecreatefromgif($this->fullpath);
                    break;
                case 'image/png':
                    $this->_resource = imagecreatefrompng($this->fullpath);
                    break;
                case 'image/jpeg':
                    $this->_resource = imagecreatefromjpeg($this->fullpath);
                    break;
            }
        }
    }

    /**
     * Create and save the new image file in the correct format.
     *
     * @param  string $new
     * @param  string $img
     * @param  int|string $q
     * @return void
     */
    protected function _createImage($new, $img = null, $q = null)
    {
        if (is_string($new)) {
            $new = imagecreatefromstring($new);
        }

        switch ($this->_mime) {
            case 'image/gif':
                imagegif($new, $img);
                break;
            case 'image/png':
                imagepng($new, $img, $q);
                break;
            case 'image/jpeg':
                imagejpeg($new, $img, $q);
                break;
        }
    }

    /**
     * Copy the image resource to the image output resource with the set parameters.
     *
     * @param  int|string $w
     * @param  int|string $h
     * @param  int|string $x
     * @param  int|string $y
     * @return void
     */
    protected function _copyImage($w, $h, $x = 0, $y = 0)
    {
        imagecopyresampled($this->_output, $this->_resource, 0, 0, $x, $y, $w, $h, $this->_width, $this->_height);
        $this->_width = imagesx($this->_output);
        $this->_height = imagesy($this->_output);
    }

}
