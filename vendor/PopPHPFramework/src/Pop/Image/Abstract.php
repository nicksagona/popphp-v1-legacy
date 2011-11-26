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
 * Pop_Image_Abstract
 *
 * @category   Pop
 * @package    Pop_Image
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

abstract class Pop_Image_Abstract extends Pop_File
{

    /**
     * Constant for inner border
     * @var int
     */
    const INNER_BORDER = 1;

    /**
     * Constant for outer border
     * @var int
     */
    const OUTER_BORDER = 2;

    /**
     * Constant for regular blur
     * @var int
     */
    const BLUR = 3;

    /**
     * Constant for gaussian blur
     * @var int
     */
    const GAUSSIAN_BLUR = 4;

    /**
     * Image width
     * @var int
     */
    protected $_width = 0;

    /**
     * Image height
     * @var int
     */
    protected $_height = 0;

    /**
     * Image channels
     * @var int
     */
    protected $_channels = null;

    /**
     * Image bit depth
     * @var int
     */
    protected $_depth = null;

    /**
     * Image mode
     * @var string
     */
    protected $_mode = null;

    /**
     * Image alpha
     * @var boolean
     */
    protected $_alpha = false;

    /**
     * Image quality
     * @var int|string
     */
    protected $_quality = null;

    /**
     * Image fill color
     * @var mixed
     */
    protected $_fillColor = null;

    /**
     * Image background color
     * @var mixed
     */
    protected $_backgroundColor = null;

    /**
     * Image stroke color
     * @var mixed
     */
    protected $_strokeColor = null;

    /**
     * Image stroke width
     * @var int
     */
    protected $_strokeWidth = null;

    /**
     * Image resource
     * @var image
     */
    protected $_resource = null;

    /**
     * Constructor
     *
     * Instantiate an image file object based on either a pre-existing
     * image file on disk, or a new image file.
     *
     * @param  string     $img
     * @param  int|string $w
     * @param  int|string $h
     * @param  array      $rgb
     * @param  array      $types
     * @throws Exception
     * @return void
     */
    public function __construct($img, $w = null, $h = null, $rgb = null, $types = null)
    {
        parent::__construct($img, $types);
    }

    /**
     * Set the image quality based on the type of image.
     *
     * @param  int|string $q
     * @return mixed
     */
    abstract public function setQuality($q = null);

    /**
     * Get the image width.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->_width;
    }

    /**
     * Get the image height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->_height;
    }

    /**
     * Get the number of image channels.
     *
     * @return int
     */
    public function getChannels()
    {
        return $this->_channels;
    }

    /**
     * Get the image bit depth.
     *
     * @return int
     */
    public function getDepth()
    {
        return $this->_depth;
    }

    /**
     * Get the image color mode.
     *
     * @return string
     */
    public function getColorMode()
    {
        return $this->_mode;
    }

    /**
     * Get whether or not the image has an alpha channel.
     *
     * @return boolean
     */
    public function hasAlpha()
    {
        return $this->_alpha;
    }

    /**
     * Set the fill color.
     *
     * @param  mixed $color
     * @return mixed
     */
    public function setFillColor(Pop_Color_Interface $color = null)
    {
        $this->_fillColor = $color;
        return $this;
    }

    /**
     * Set the background color.
     *
     * @param  mixed $color
     * @return mixed
     */
    public function setBackgroundColor(Pop_Color_Interface $color = null)
    {
        $this->_backgroundColor = $color;
        return $this;
    }

    /**
     * Set the stroke color.
     *
     * @param  mixed $color
     * @return mixed
     */
    public function setStrokeColor(Pop_Color_Interface $color = null)
    {
        $this->_strokeColor = $color;
        return $this;
    }

    /**
     * Set the stroke width.
     *
     * @param  int|string $wid
     * @return mixed
     */
    public function setStrokeWidth($wid = null)
    {
        $this->_strokeWidth = $wid;
        return $this;
    }

    /**
     * Set the opacity.
     *
     * @param  int|string $opac
     * @return mixed
     */
    abstract public function setOpacity($opac);

    /**
     * Resize the image object to the width parameter passed.
     *
     * @param  int|string $wid
     * @return mixed
     */
    abstract public function resizeToWidth($wid);

    /**
     * Resize the image object to the height parameter passed.
     *
     * @param  int|string $hgt
     * @return mixed
     */
    abstract public function resizeToHeight($hgt);

    /**
     * Resize the image object, allowing for the largest dimension to be scaled
     * to the value of the $px argument. For example, if the value of $px = 200,
     * and the image is 800px X 600px, then the image will be scaled to
     * 200px X 150px.
     *
     * @param  int|string $px
     * @return mixed
     */
    abstract public function resize($px);

    /**
     * Scale the image object, allowing for the dimensions to be scaled
     * proportionally to the value of the $scl argument. For example, if the
     * value of $scl = 0.50, and the image is 800px X 600px, then the image
     * will be scaled to 400px X 300px.
     *
     * @param  float|string $scl
     * @return mixed
     */
    abstract public function scale($scl);

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
    abstract public function crop($wid, $hgt, $x = 0, $y = 0);

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
     * @return mixed
     */
    abstract public function cropThumb($px, $x = 0, $y = 0);

    /**
     * Rotate the image object, using simple degrees, i.e. -90,
     * to rotate the image.
     *
     * @param  int|string $deg
     * @return mixed
     */
    abstract public function rotate($deg);

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
    abstract public function text($str, $size, $x, $y, $font = null, $rotate = null, $stroke = false);

    /**
     * Method to add a line to the image.
     *
     * @param  int $x1
     * @param  int $y1
     * @param  int $x2
     * @param  int $y2
     * @return void
     */
    abstract public function addLine($x1, $y1, $x2, $y2);

    /**
     * Method to add a rectangle to the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @return void
     */
    abstract public function addRectangle($x, $y, $w, $h = null);

    /**
     * Method to add a square to the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @return void
     */
    abstract public function addSquare($x, $y, $w);

    /**
     * Method to add an ellipse to the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @return void
     */
    abstract public function addEllipse($x, $y, $w, $h = null);

    /**
     * Method to add a circle to the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @return void
     */
    abstract public function addCircle($x, $y, $w);

    /**
     * Method to add an arc to the image.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @return void
     */
    abstract public function addArc($x, $y, $start, $end, $w, $h = null);

    /**
     * Method to add a polygon to the image.
     *
     * @param  array $points
     * @return void
     */
    abstract public function addPolygon($points);

    /**
     * Method to adjust the brightness of the image.
     *
     * @param  int $b
     * @return mixed
     */
    abstract public function brightness($b);

    /**
     * Method to adjust the contrast of the image.
     *
     * @param  int $amount
     * @return mixed
     */
    abstract public function contrast($amount);

    /**
     * Method to add a border to the image.
     *
     * @param  int $w
     * @param  int $h
     * @param  int $type
     * @return mixed
     */
    abstract public function border($w, $h = null, $type = Pop_Image_Abstract::INNER_BORDER);

    /**
     * Method to colorize the image with the color passed.
     *
     * @param  mixed $color
     * @return mixed
     */
    abstract public function colorize(Pop_Color_Interface $color);

    /**
     * Method to invert the image (create a negative.)
     *
     * @return mixed
     */
    abstract public function invert();

    /**
     * Overlay an image onto the current image.
     *
     * @param  string     $ovr
     * @param  int|string $x
     * @param  int|string $y
     * @return mixed
     */
    abstract public function overlay($ovr, $x = 0, $y = 0);

    /**
     * Return the number of colors in the palette of indexed images.
     * Returns 0 for true color images.
     *
     * @return int
     */
    abstract public function colorTotal();

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
    abstract public function getColors($format = 'HEX');

    /**
     * Convert the image object to the new specified image type.
     *
     * @param  string     $type
     * @throws Exception
     * @return mixed
     */
    abstract public function convert($type);

    /**
     * Destroy the image object and the related image file directly.
     *
     * @param  boolean $file
     * @return void
     */
    abstract public function destroy($file = false);

    /**
     * Set and return a color identifier.
     *
     * @param  mixed $color
     * @throws Exception
     * @return mixed
     */
    abstract protected function _setColor(Pop_Color_Interface $color = null);

}
