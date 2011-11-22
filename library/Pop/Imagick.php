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
 * @package    Pop_Imagick
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Imagick
 *
 * @category   Pop
 * @package    Pop_Imagick
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Imagick extends Pop_Image_Abstract
{

    /**
     * Constant for motion blur
     * @var int
     */
    const MOTION_BLUR = 5;

    /**
     * Constant for radial blur
     * @var int
     */
    const RADIAL_BLUR = 6;

    /**
     * Imagick version
     * @var string
     */
    public $version = null;

    /**
     * Imagick version number
     * @var string
     */
    public $versionString = null;

    /**
     * Array of allowed file types.
     * @var array
     */
    protected $_allowed = array('afm'   => 'application/x-font-afm',
                                'ai'    => 'application/postscript',
                                'avi'   => 'video/x-msvideo',
                                'bmp'   => 'image/x-ms-bmp',
                                'eps'   => 'application/octet-stream',
                                'gif'   => 'image/gif',
                                'html'  => 'text/html',
                                'htm'   => 'text/html',
                                'jpe'   => 'image/jpeg',
                                'jpg'   => 'image/jpeg',
                                'jpeg'  => 'image/jpeg',
                                'mov'   => 'video/quicktime',
                                'mp4'   => 'video/mp4',
                                'mpg'   => 'video/mpeg',
                                'mpeg'  => 'video/mpeg',
                                'otf'   => 'application/x-font-otf',
                                'pdf'   => 'application/pdf',
                                'pfb'   => 'application/x-font-pfb',
                                'pfm'   => 'application/x-font-pfm',
                                'png'   => 'image/png',
                                'ps'    => 'application/postscript',
                                'psb'   => 'image/x-photoshop',
                                'psd'   => 'image/x-photoshop',
                                'shtml' => 'text/html',
                                'shtm'  => 'text/html',
                                'svg'   => 'image/svg+xml',
                                'tif'   => 'image/tiff',
                                'tiff'  => 'image/tiff',
                                'tsv'   => 'text/tsv',
                                'ttf'   => 'application/x-font-ttf',
                                'txt'   => 'text/plain',
                                'xhtml' => 'application/xhtml+xml',
                                'xml'   => 'application/xml');

    /**
     * Image color opacity
     * @var float
     */
    protected $_opacity = 1.0;

    /**
     * Image compression
     * @var int|string
     */
    protected $_compression = null;

    /**
     * Image filter
     * @var int
     */
    protected $_filter = Imagick::FILTER_LANCZOS;

    /**
     * Image blur
     * @var int
     */
    protected $_blur = 1;

    /**
     * Image overlay
     * @var int
     */
    protected $_overlay = Imagick::COMPOSITE_ATOP;

    /**
     * Constructor
     *
     * Instantiate an Imagick file object based on either a pre-existing image
     * file on disk, or a new image file.
     *
     * As of July 28th, 2011, stable testing was successful with the
     * following versions of the required software:
     *
     * ImageMagick 6.5.*
     * Ghostscript 8.70 or 8.71
     * Imagick PHP Extension 3.0.1
     *
     * Any variation in the versions of the required software may contribute to
     * the Pop_Imagick component not functioning properly.
     *
     * @param  string     $img
     * @param  int|string $w
     * @param  int|string $h
     * @param  mixed      $color
     * @param  array      $types
     * @throws Exception
     * @return void
     */
    public function __construct($img, $w = null, $h = null, Pop_Color_Interface $color = null, $types = null)
    {
        $imagickFile = null;
        $imgFile = null;

        if (!file_exists($img) && (strpos($img, '[') !== false)) {
            $imagickFile = $img;
            $imgFile = trim(substr($img, 0, strpos($img, '[')));
            $imgFile .= substr($img, (strpos($img, ']') + 1));
            $img = $imgFile;
        } else {
            $imgFile = $img;
            $imagickFile = $img;
        }

        parent::__construct($img, $types);

        // Check to see if Imagick is installed.
        if (!self::isImagickInstalled()) {
            throw new Exception($this->_lang->__('Error: The Imagick library extension must be installed to use the Pop_Imagick component.'));
        } else {
            // If image exists, get image info and store in an array.
            if (file_exists($this->fullpath) && ($this->_size > 0)) {
                $this->_resource = new Imagick($imagickFile);
                $this->_setImageInfo();
                $this->setQuality(100);
            // If image does not exists, check to make sure the width and height
            // properties of the new image have been passed.
            } else {
                $this->_resource = new Imagick();

                if (is_null($w) || is_null($h)) {
                    throw new Exception($this->_lang->__('Error: You must define a width and height for a new image object.'));
                } else {
                    // Set image object properties.
                    $this->_width = $w;
                    $this->_height = $h;
                    $this->_channels = null;

                    $color = (is_null($color)) ? new Pop_Color_Rgb(255, 255, 255) : $color;
                    $clr = $this->_setColor($color);

                    // Create a new image and allocate the background color.
                    $this->_resource->newImage($w, $h, $clr, $this->ext);

                    // Set the quality and create a new, blank image file.
                    $this->setQuality(100);
                }
            }

            $this->_getImagickInfo();
        }
    }

    /**
     * Set the image quality.
     *
     * @param  int $q
     * @return Pop_Imagick
     */
    public function setQuality($q = null)
    {
        $this->_quality = (!is_null($q)) ? (int)$q : null;
        return $this;
    }

    /**
     * Set the opacity.
     *
     * @param  float $opac
     * @return Pop_Imagick
     */
    public function setOpacity($opac)
    {
        $this->_opacity = $opac;
        return $this;
    }

    /**
     * Set the image quality.
     *
     * @param  int $comp
     * @return Pop_Imagick
     */
    public function setCompression($comp = null)
    {
        $this->_compression = (!is_null($comp)) ? (int)$comp : null;
        return $this;
    }

    /**
     * Set the image filter.
     *
     * @param  int|string $filter
     * @return Pop_Imagick
     */
    public function setFilter($filter = null)
    {
        $this->_filter = $filter;
        return $this;
    }

    /**
     * Set the image blur.
     *
     * @param  int|string $blur
     * @return Pop_Imagick
     */
    public function setBlur($blur = null)
    {
        $this->_blur = $blur;
        return $this;
    }

    /**
     * Set the image overlay.
     *
     * @param  int|string $ovr
     * @return Pop_Imagick
     */
    public function setOverlay($ovr = null)
    {
        $this->_overlay = $ovr;
        return $this;
    }

    /**
     * Get the Imagick resource to directly interface with the Imagick object.
     *
     * @return Imagick
     */
    public function imagick()
    {
        return $this->_resource;
    }

    /**
     * Resize the image object to the width parameter passed.
     *
     * @param  int|string $wid
     * @return mixed
     */
    public function resizeToWidth($wid)
    {
        $this->_setImageInfo();

        $scale = $wid / $this->_width;
        $hgt = round($this->_height * $scale);

        // Create a new image output resource.
        $this->_resource->resizeImage($wid, $hgt, $this->_filter, $this->_blur);

        $this->_setImageInfo();

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
        $this->_setImageInfo();

        $scale = $hgt / $this->_height;
        $wid = round($this->_width * $scale);

        // Create a new image output resource.
        $this->_resource->resizeImage($wid, $hgt, $this->_filter, $this->_blur);

        $this->_setImageInfo();

        return $this;
    }

    /**
     * Resize the image object, allowing for the largest dimension to be scaled
     * to the value of the $px argument. For example, if the value of $px = 200,
     * and the image is 800px X 600px, then the image will be scaled to
     * 200px X 150px.
     *
     * @param  int|string $px
     * @return Pop_Imagick
     */
    public function resize($px)
    {
        // Determine whether or not the image is landscape or portrait and set
        // the scale, new width and new height accordingly, with the largest
        // dimension being scaled to the value of the $px argument.
        $this->_setImageInfo();
        $scale = ($this->_width > $this->_height) ? ($px / $this->_width) : ($px / $this->_height);

        $wid = round($this->_width * $scale);
        $hgt = round($this->_height * $scale);

        // Create a new image output resource.
        $this->_resource->resizeImage($wid, $hgt, $this->_filter, $this->_blur);

        $this->_setImageInfo();

        return $this;
    }

    /**
     * Scale the image object, allowing for the dimensions to be scaled
     * proportionally to the value of the $scl argument. For example, if the
     * value of $scl = 0.50, and the image is 800px X 600px, then the image
     * will be scaled to 400px X 300px.
     *
     * @param  float|string $scl
     * @return Pop_Imagick
     */
    public function scale($scl)
    {
        // Determine the new width and height of the image based on the
        // value of the $scl argument.
        $this->_setImageInfo();
        $wid = round($this->_width * $scl);
        $hgt = round($this->_height * $scl);

        // Create a new image output resource.
        $this->_resource->resizeImage($wid, $hgt, $this->_filter, $this->_blur);

        $this->_setImageInfo();

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
        $this->_resource->cropImage($wid, $hgt, $x, $y);
        $this->_setImageInfo();

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
     * @return Pop_Imagick
     */
    public function cropThumb($px, $x = 0, $y = 0)
    {
        // Determine whether or not the image is landscape or portrait and set
        // the scale, new width and new height accordingly, with the smallest
        // dimension being scaled to the value of the $px argument to allow
        // for a complete crop.
        $this->_setImageInfo();
        $scale = ($this->_width > $this->_height) ? ($px / $this->_height) : ($px / $this->_width);

        $wid = round($this->_width * $scale);
        $hgt = round($this->_height * $scale);

        // Create a new image output resource.
        $this->_resource->resizeImage($wid, $hgt, $this->_filter, $this->_blur);
        $this->_resource->cropImage($px, $px, $x, $y);

        $this->_setImageInfo();

        return $this;
    }

    /**
     * Rotate the image object, using simple degrees, i.e. -90,
     * to rotate the image.
     *
     * @param  int|string $deg
     * @return Pop_Imagick
     */
    public function rotate($deg)
    {
        // Create a new image resource and rotate it.
        $color = $this->_setColor($this->_backgroundColor);
        $this->_resource->rotateImage($color, $deg);

        $this->_setImageInfo();

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
     * @return Pop_Imagick
     */
    public function text($str, $size, $x, $y, $font = 'Arial', $rotate = null, $stroke = false)
    {
        $draw = new ImagickDraw();
        $draw->setFont($font);
        $draw->setFontSize($size);
        $draw->setFillColor($this->_setColor($this->_fillColor));

        if (!is_null($rotate)) {
            $draw->rotate($rotate);
        }

        if ($stroke) {
            $draw->setStrokeColor($this->_setColor($this->_strokeColor));
            $draw->setStrokeWidth((is_null($this->_strokeWidth) ? 1 : $this->_strokeWidth));
        }

        $draw->annotation($x, $y, $str);
        $this->_resource->drawImage($draw);

        return $this;
    }

    /**
     * Method to add a line to the image.
     *
     * @param  int $x1
     * @param  int $y1
     * @param  int $x2
     * @param  int $y2
     * @return Pop_Imagick
     */
    public function addLine($x1, $y1, $x2, $y2)
    {
        $draw = new ImagickDraw();
        $draw->setStrokeColor($this->_setColor($this->_strokeColor));
        $draw->setStrokeWidth((is_null($this->_strokeWidth) ? 1 : $this->_strokeWidth));
        $draw->line($x1, $y1, $x2, $y2);
        $this->_resource->drawImage($draw);

        return $this;
    }

    /**
     * Method to add a rectangle to the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @return Pop_Imagick
     */
    public function addRectangle($x, $y, $w, $h = null)
    {
        $x2 = $x + $w;
        $y2 = $y + ((is_null($h)) ? $w : $h);

        $draw = new ImagickDraw();
        $draw->setFillColor($this->_setColor($this->_fillColor));

        if (!is_null($this->_strokeWidth)) {
            $draw->setStrokeColor($this->_setColor($this->_strokeColor));
            $draw->setStrokeWidth((is_null($this->_strokeWidth) ? 1 : $this->_strokeWidth));
        }

        $draw->rectangle($x, $y, $x2, $y2);
        $this->_resource->drawImage($draw);

        return $this;
    }

    /**
     * Method to add a square to the image.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @return Pop_Imagick
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
     * @return Pop_Imagick
     */
    public function addEllipse($x, $y, $w, $h = null)
    {
        $wid = $w;
        $hgt = (is_null($h)) ? $w : $h;

        $draw = new ImagickDraw();
        $draw->setFillColor($this->_setColor($this->_fillColor));

        if (!is_null($this->_strokeWidth)) {
            $draw->setStrokeColor($this->_setColor($this->_strokeColor));
            $draw->setStrokeWidth((is_null($this->_strokeWidth) ? 1 : $this->_strokeWidth));
        }

        $draw->ellipse($x, $y, $wid, $hgt, 0, 360);
        $this->_resource->drawImage($draw);

        return $this;
    }

    /**
     * Method to add a circle to the image.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @return Pop_Imagick
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
     * @return Pop_Imagick
     */
    public function addArc($x, $y, $start, $end, $w, $h = null)
    {
        $wid = $w;
        $hgt = (is_null($h)) ? $w : $h;

        $draw = new ImagickDraw();
        $draw->setFillColor($this->_setColor($this->_fillColor));

        $x1 = $w * cos($start / 180 * pi());
        $y1 = $h * sin($start / 180 * pi());
        $x2 = $w * cos($end / 180 * pi());
        $y2 = $h * sin($end / 180 * pi());

        $points = array(
                        array('x' => $x, 'y' => $y),
                        array('x' => $x + $x1, 'y' => $y + $y1),
                        array('x' => $x + $x2, 'y' => $y + $y2)
                        );

        $draw->polygon($points);

        $draw->ellipse($x, $y, $wid, $hgt, $start, $end);
        $this->_resource->drawImage($draw);

        if (!is_null($this->_strokeWidth)) {
            $draw = new ImagickDraw();

            $draw->setFillColor($this->_setColor($this->_fillColor));
            $draw->setStrokeColor($this->_setColor($this->_strokeColor));
            $draw->setStrokeWidth((is_null($this->_strokeWidth) ? 1 : $this->_strokeWidth));

            $draw->ellipse($x, $y, $wid, $hgt, $start, $end);
            $draw->line($x, $y, $x + $x1, $y + $y1);
            $draw->line($x, $y, $x + $x2, $y + $y2);

            $this->_resource->drawImage($draw);
        }

        return $this;
    }

    /**
     * Method to add a polygon to the image.
     *
     * @param  array $points
     * @return Pop_Imagick
     */
    public function addPolygon($points)
    {
        $draw = new ImagickDraw();
        $draw->setFillColor($this->_setColor($this->_fillColor));

        if (!is_null($this->_strokeWidth)) {
            $draw->setStrokeColor($this->_setColor($this->_strokeColor));
            $draw->setStrokeWidth((is_null($this->_strokeWidth) ? 1 : $this->_strokeWidth));
        }

        $draw->polygon($points);
        $this->_resource->drawImage($draw);

        return $this;
    }

    /**
     * Method to adjust the hue of the image.
     *
     * @param  int $h
     * @return Pop_Imagick
     */
    public function hue($h)
    {
        $this->_resource->modulateImage(100, 100, $h);
        return $this;
    }

    /**
     * Method to adjust the saturation of the image.
     *
     * @param  int $s
     * @return Pop_Imagick
     */
    public function saturation($s)
    {
        $this->_resource->modulateImage(100, $s, 100);
        return $this;
    }

    /**
     * Method to adjust the brightness of the image.
     *
     * @param  int $b
     * @return Pop_Imagick
     */
    public function brightness($b)
    {
        $this->_resource->modulateImage($b, 100, 100);
        return $this;
    }

    /**
     * Method to adjust the HSB of the image altogether.
     *
     * @param  int $h
     * @param  int $s
     * @param  int $b
     * @return Pop_Imagick
     */
    public function hsb($h, $s, $b)
    {
        $this->_resource->modulateImage($h, $s, $b);
        return $this;
    }

    /**
     * Method to adjust the levels of the image using a 0 - 255 range.
     *
     * @param  int   $black
     * @param  float $gamma
     * @param  int   $white
     * @return Pop_Imagick
     */
    public function level($black, $gamma, $white)
    {
        $quantumRange = $this->_resource->getQuantumRange();

        if ($black < 0) {
            $black = 0;
        }
        if ($white > 255) {
            $white = 255;
        }

        $blackPoint = ($black / 255) * $quantumRange['quantumRangeLong'];
        $whitePoint = ($white / 255) * $quantumRange['quantumRangeLong'];

        $this->_resource->levelImage($blackPoint, $gamma, $whitePoint);

        return $this;
    }

    /**
     * Method to adjust the contrast of the image.
     *
     * @param  int $amount
     * @return Pop_Imagick
     */
    public function contrast($amount)
    {
        if ($amount > 0) {
            for ($i = 1; $i <= $amount; $i++) {
                $this->_resource->contrastImage(1);
            }
        } else if ($amount < 0) {
            for ($i = -1; $i >= $amount; $i--) {
                $this->_resource->contrastImage(0);
            }
        }

        return $this;
    }

    /**
     * Method to sharpen the image.
     *
     * @param  int $radius
     * @param  int $sigma
     * @return Pop_Imagick
     */
    public function sharpen($radius = 0, $sigma = 0)
    {
        $this->_resource->sharpenImage($radius, $sigma);
        return $this;
    }

    /**
     * Method to blur the image.
     *
     * @param  int $radius
     * @param  int $sigma
     * @param  int $angle
     * @param  int $type
     * @return Pop_Imagick
     */
    public function blur($radius = 0, $sigma = 0, $angle = 0, $type = Pop_Imagick::BLUR)
    {
        switch ($type) {
            case Pop_Imagick::BLUR:
                $this->_resource->blurImage($radius, $sigma);
                break;
            case Pop_Imagick::GAUSSIAN_BLUR:
                $this->_resource->gaussianBlurImage($radius, $sigma);
                break;
            case Pop_Imagick::MOTION_BLUR:
                $this->_resource->motionBlurImage($radius, $sigma, $angle);
                break;
            case Pop_Imagick::RADIAL_BLUR:
                $this->_resource->radialBlurImage($angle);
                break;
        }

        return $this;
    }

    /**
     * Method to add a border to the image.
     *
     * @param  int $w
     * @param  int $h
     * @param  int $type
     * @return Pop_Imagick
     */
    public function border($w, $h = null, $type = Pop_Imagick::INNER_BORDER)
    {
        $h = is_null($h) ? $w : $h;

        if ($type == Pop_Imagick::INNER_BORDER) {
            $this->setStrokeWidth(($h * 2));
            $this->addLine(0, 0, $this->_width, 0);
            $this->addLine(0, $this->_height, $this->_width, $this->_height);
            $this->setStrokeWidth(($w * 2));
            $this->addLine(0, 0, 0, $this->_height);
            $this->addLine($this->_width, 0, $this->_width, $this->_height);
        } else {
            $this->_resource->borderImage($this->_setColor($this->_strokeColor), $w, $h);
        }

        return $this;
    }

    /**
     * Overlay an image onto the current image.
     *
     * @param  string     $ovr
     * @param  int|string $x
     * @param  int|string $y
     * @return Pop_Imagick
     */
    public function overlay($ovr, $x = 0, $y = 0)
    {
        $overlayImage = new Imagick($ovr);
        if ($this->_opacity < 1) {
            $overlayImage->setImageOpacity($this->_opacity);
        }

        $this->_resource->compositeImage($overlayImage, $this->_overlay, $x, $y);
        return $this;
    }

    /**
     * Method to colorize the image with the color passed.
     *
     * @param  mixed $color
     * @return Pop_Imagick
     */
    public function colorize(Pop_Color_Interface $color)
    {
        $this->_resource->colorizeImage($color->getRgb(Pop_Color::STRING, true), $this->_opacity);
        return $this;
    }

    /**
     * Method to invert the image (create a negative.)
     *
     * @return Pop_Imagick
     */
    public function invert()
    {
        $this->_resource->negateImage(false);
        return $this;
    }

    /**
     * Method to flip the image over the x-axis.
     *
     * @return Pop_Imagick
     */
    public function flip()
    {
        $this->_resource->flipImage();
        return $this;
    }

    /**
     * Method to flip the image over the x-axis.
     *
     * @return Pop_Imagick
     */
    public function flop()
    {
        $this->_resource->flopImage();
        return $this;
    }

    /**
     * Flatten the image layers
     *
     * @return Pop_Imagick
     */
    public function flatten()
    {
        $this->_resource->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        return $this;
    }

    /**
     * Apply an oil paint effect to the image using the pixel radius threshold
     *
     * @param  int $radius
     * @return Pop_Imagick
     */
    public function paint($radius)
    {
        $this->_resource->oilPaintImage($radius);
        return $this;
    }

    /**
     * Apply a posterize effect to the image
     *
     * @param  int     $levels
     * @param  boolean $dither
     * @return Pop_Imagick
     */
    public function posterize($levels, $dither = false)
    {
        $this->_resource->posterizeImage($levels, $dither);
        return $this;
    }

    /**
     * Apply a noise effect to the image
     *
     * @param  int $type
     * @return Pop_Imagick
     */
    public function noise($type = Imagick::NOISE_MULTIPLICATIVEGAUSSIAN)
    {
        $this->_resource->addNoiseImage($type);
        return $this;
    }

    /**
     * Apply a diffusion effect to the image
     *
     * @param  int $radius
     * @return Pop_Imagick
     */
    public function diffuse($radius)
    {
        $this->_resource->spreadImage($radius);
        return $this;
    }

    /**
     * Apply a skew effect to the image
     *
     * @param  mixed $color
     * @param  int   $x
     * @param  int   $y
     * @return Pop_Imagick
     */
    public function skew(Pop_Color_Interface $color, $x, $y)
    {
        $this->_resource->shearImage($color->getRgb(Pop_Color::STRING, true), $x, $y);
        return $this;
    }

    /**
     * Apply a mosiac pixelate effect to the image
     *
     * @param  int $w
     * @param  int $h
     * @return Pop_Imagick
     */
    public function pixelate($w, $h = null)
    {
        $x = $this->_width / $w;
        $y = $this->_height / (is_null($h) ? $w : $h);

        $this->_resource->scaleImage($x, $y);
        $this->_resource->scaleImage($this->_width, $this->_height);

        return $this;
    }

    /**
     * Apply a pencil/sketch effect to the image
     *
     * @param  int $radius
     * @param  int $sigma
     * @param  int $angle
     * @return Pop_Imagick
     */
    public function pencil($radius, $sigma, $angle)
    {
        $this->_resource->sketchImage($radius, $sigma, $angle);
        return $this;
    }

    /**
     * Apply a swirl effect to the image
     *
     * @param  int $degrees
     * @return Pop_Imagick
     */
    public function swirl($degrees)
    {
        $this->_resource->swirlImage($degrees);
        return $this;
    }

    /**
     * Apply a wave effect to the image
     *
     * @param  int $amp
     * @param  int $length
     * @return Pop_Imagick
     */
    public function wave($amp, $length)
    {
        $this->_resource->waveImage($amp, $length);
        return $this;
    }

    /**
     * Return the number of colors in the palette of indexed images.
     *
     * @return int
     */
    public function colorTotal()
    {
        return $this->_resource->getImageColors();
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

        // Loop through each pixel of the image, recording the color result
        // in the color array.
        for ($h = 0; $h < $this->_height; $h++) {
            for ($w = 0; $w < $this->_width; $w++) {
                $point = $this->_resource->getImagePixelColor($w, $h);
                $color = $point->getColor();

                // Convert to the proper HEX or RGB format.
                if ($format == 'HEX') {
                    $rgb = sprintf('%02s', dechex($color['r'])) . sprintf('%02s', dechex($color['g'])) . sprintf('%02s', dechex($color['b']));
                } else {
                    $rgb = $color['r'] . "," . $color['g'] . "," . $color['b'];
                }
                // If the color is not already in the array, add to it.
                if (!in_array($rgb, $colors)) {
                    $colors[] = $rgb;
                }
            }
        }

        // Return the colors array.
        return $colors;
    }

    /**
     * Convert the image object to the new specified image type.
     *
     * @param  string     $type
     * @throws Exception
     * @return Pop_Imagick
     */
    public function convert($type)
    {
        $type = strtolower($type);

        // Check if the permissions are set correctly.
        if (!is_null($this->_perm['file']) && ($this->_perm['file'] != 777)) {
            throw new Exception($this->_lang->__('Error: Permission denied.'));
        // Check if the requested image type is supported.
        } else if (!array_key_exists($type, $this->_allowed)) {
            throw new Exception($this->_lang->__('Error: That image type is not supported.'));
        // Check if the image is already the requested image type.
        } else if (strtolower($this->ext) == $type) {
            throw new Exception($this->_lang->__('Error: This image file is already a %1 image file.', strtoupper($type)));
        // Else, save the image as the new type.
        } else {
            $old = $this->ext;
            $this->ext = $type;
            $this->_mime = $this->_allowed[$this->ext];
            $this->fullpath = $this->dir . $this->filename . '.' . $this->ext;
            $this->basename = basename($this->fullpath);

            if (($old == 'psd') || ($old == 'tif') || ($old == 'tiff')) {
                $this->flatten();
            }
            $this->_resource->setImageFormat($type);

            return $this;
        }
    }

    /**
     * Output the image object directly.
     *
     * @param  int|string $q
     * @param  boolean $download
     * @return void
     */
    public function output($download = false)
    {
        // Begin output of headers.
        header('Content-type: ' . $this->_mime);

        // Determine if the force download argument has been passed.
        $attach = ($download) ? 'attachment; ' : null;

        // Send the file information.
        header('Content-disposition: ' . $attach . 'filename=' . $this->basename);

        // Send cache control headers for IE SSL issue.
        if ($_SERVER['SERVER_PORT'] == 443) {
            header('Expires: 0');
            header('Cache-Control: private, must-revalidate');
            header('Pragma: cache');
        }

        if (!is_null($this->_compression)) {
            $this->_resource->setImageCompression($this->_compression);
        }
        if (!is_null($this->_quality)) {
            $this->_resource->setImageCompressionQuality($this->_quality);
        }

        echo $this->_resource;

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
        if (!is_null($this->_compression)) {
            $this->_resource->setImageCompression($this->_compression);
        }
        if (!is_null($this->_quality)) {
            $this->_resource->setImageCompressionQuality($this->_quality);
        }
        $img = (!is_null($to)) ? $to : $this->fullpath;
        $this->_resource->writeImage($img);

        clearstatcache();

        $this->_setFile($img);
        $this->_setImageInfo();

        return $this;
    }

    /**
     * Destroy the image object and the related image file directly.
     *
     * @param  boolean $file
     * @return void
     */
    public function destroy($file = false)
    {
        $this->_resource->clear();
        $this->_resource->destroy();

        // Clear PHP's file status cache.
        clearstatcache();

        // If the $file flag is passed, delete the image file.
        if ($file) {
            $this->delete();
        }
    }

    /**
     * Check if Imagick is installed.
     *
     * @return boolean
     */
    public static function isImagickInstalled()
    {
        return class_exists('Imagick');
    }

    /**
     * Set the current object formats against the supported formats of Imagick.
     *
     * @return void
     */
    public function setFormats()
    {
        $formats = $this->getFormats();

        foreach ($formats as $format) {
            $frmt = strtolower($format);
            if (!array_key_exists($frmt, $this->_allowed)) {
                $this->_allowed[$frmt] = 'image/' . $frmt;
            }
        }

        ksort($this->_allowed);
    }

    /**
     * Get the array of supported formats of Imagick.
     *
     * @return array
     */
    public function getFormats()
    {
        return $this->_resource->queryFormats();
    }

    /**
     * Get the number of supported formats of Imagick.
     *
     * @return int
     */
    public function getNumberOfFormats()
    {
        return count($this->_resource->queryFormats());
    }

    /**
     * Get Imagick Info.
     *
     * @return void
     */
    protected function _getImagickInfo()
    {
        $imagickVersion = $this->_resource->getVersion();
        $this->versionString = trim(substr($imagickVersion['versionString'], 0, stripos($imagickVersion['versionString'], 'http://')));
        $this->version = substr($this->versionString, (strpos($this->versionString, ' ') + 1));
        $this->version = substr($this->version, 0, strpos($this->version, '-'));
    }

    /**
     * Set the image info
     *
     * @return void
     */
    protected function _setImageInfo()
    {
        // Set image object properties.
        $this->_width = $this->_resource->getImageWidth();
        $this->_height = $this->_resource->getImageHeight();
        $this->_depth = $this->_resource->getImageDepth();
        $this->_quality = null;

        $this->_alpha = ($this->_resource->getImageAlphaChannel() == 1) ? true : false;
        $colorSpace = $this->_resource->getImageColorspace();
        $type = $this->_resource->getImageType();

        switch ($colorSpace) {
            case Imagick::COLORSPACE_UNDEFINED:
                $this->_channels = 0;
                $this->_mode = '';
                break;
            case Imagick::COLORSPACE_RGB:
                if ($type == Imagick::IMGTYPE_PALETTE) {
                    $this->_channels = 3;
                    $this->_mode = 'Indexed';
                } else if ($type == Imagick::IMGTYPE_PALETTEMATTE) {
                    $this->_channels = 3;
                    $this->_mode = 'Indexed';
                } else if ($type == Imagick::IMGTYPE_GRAYSCALE) {
                    $this->_channels = 1;
                    $this->_mode = 'Gray';
                } else if ($type == Imagick::IMGTYPE_GRAYSCALEMATTE) {
                    $this->_channels = 1;
                    $this->_mode = 'Gray';
                } else {
                    $this->_channels = 3;
                    $this->_mode = 'RGB';
                }
                break;
            case Imagick::COLORSPACE_GRAY:
                $this->_channels = 1;
                $this->_mode = (($type == Imagick::IMGTYPE_PALETTE) || ($type == Imagick::IMGTYPE_PALETTEMATTE)) ? 'Indexed' : 'Gray';
                break;
            case Imagick::COLORSPACE_TRANSPARENT:
                $this->_channels = 1;
                $this->_mode = 'Transparent';
                break;
            case Imagick::COLORSPACE_OHTA:
                $this->_channels = 3;
                $this->_mode = 'OHTA';
                break;
            case Imagick::COLORSPACE_LAB:
                $this->_channels = 3;
                $this->_mode = 'LAB';
                break;
            case Imagick::COLORSPACE_XYZ:
                $this->_channels = 3;
                $this->_mode = 'XYZ';
                break;
            case Imagick::COLORSPACE_YCBCR:
                $this->_channels = 3;
                $this->_mode = 'YCbCr';
                break;
            case Imagick::COLORSPACE_YCC:
                $this->_channels = 3;
                $this->_mode = 'YCC';
                break;
            case Imagick::COLORSPACE_YIQ:
                $this->_channels = 3;
                $this->_mode = 'YIQ';
                break;
            case Imagick::COLORSPACE_YPBPR:
                $this->_channels = 3;
                $this->_mode = 'YPbPr';
                break;
            case Imagick::COLORSPACE_YUV:
                $this->_channels = 3;
                $this->_mode = 'YUV';
                break;
            case Imagick::COLORSPACE_CMYK:
                $this->_channels = 4;
                $this->_mode = 'CMYK';
                break;
            case Imagick::COLORSPACE_SRGB:
                $this->_channels = 3;
                $this->_mode = 'sRGB';
                break;
            case Imagick::COLORSPACE_HSB:
                $this->_channels = 3;
                $this->_mode = 'HSB';
                break;
            case Imagick::COLORSPACE_HSL:
                $this->_channels = 3;
                $this->_mode = 'HSL';
                break;
            case Imagick::COLORSPACE_HWB:
                $this->_channels = 3;
                $this->_mode = 'HWB';
                break;
            case Imagick::COLORSPACE_REC601LUMA:
                $this->_channels = 3;
                $this->_mode = 'Rec601';
                break;
            case Imagick::COLORSPACE_REC709LUMA:
                $this->_channels = 3;
                $this->_mode = 'Rec709';
                break;
            case Imagick::COLORSPACE_LOG:
                $this->_channels = 3;
                $this->_mode = 'LOG';
                break;
            case Imagick::COLORSPACE_CMY:
                $this->_channels = 3;
                $this->_mode = 'CMY';
                break;
        }
    }

    /**
     * Set and return a color identifier.
     *
     * @param  mixed $color
     * @throws Exception
     * @return mixed
     */
    protected function _setColor(Pop_Color_Interface $color = null)
    {
        $clr = null;

        if (!is_null($color)) {
            $clr = $color->getRgb(Pop_Color::STRING, true);
        } else {
            $clr = 'rgb(0,0,0)';
        }

        return new ImagickPixel($clr);
    }

}
