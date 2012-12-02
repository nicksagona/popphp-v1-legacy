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
 * @package    Pop_Color
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Color;

/**
 * This is the Color class for the Color component.
 *
 * @category   Pop
 * @package    Pop_Color
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.3
 */
class Color
{

    /**
     * Constant to set the get*() return type to associative array
     * @var int
     */
    const ASSOC_ARRAY = 1;

    /**
     * Constant to set the get*() return type to numeric array
     * @var int
     */
    const NUM_ARRAY = 2;

    /**
     * Constant to set the get*() return type to comma-separated string
     * @var int
     */
    const STRING = 3;

    /**
     * Color space objects
     * @var array
     */
    protected $colors = array();

    /**
     * Constructor
     *
     * Instantiate the color object
     *
     * @param  ColorInterface $color
     * @param  boolean        $convert
     * @return void
     */
    public function __construct(ColorInterface $color = null, $convert = true)
    {
        if (null !== $color) {
            $this->addColor($color, $convert);
        }
    }

    /**
     * Static method to instantiate the color object and return itself
     * to facilitate chaining methods together.
     *
     * @param  ColorInterface   $color
     * @param  boolean                    $convert
     * @return Pop\Color\Color
     */
    public static function factory(ColorInterface $color = null, $convert = true)
    {
        return new self($color, $convert);
    }

    /**
     * Method to add a new color space object to the color object.
     *
     * @param  ColorInterface  $color
     * @param  boolean $convert
     * @throws
     * @return Pop\Color\Color
     */
    public function addColor(ColorInterface $color, $convert = true)
    {
        $class = get_class($color);

        $type = strtolower(substr($class, (strrpos($class, '\\') + 1)));
        $this->colors[$type] = $color;

        if ($convert) {
            if ($type != 'cmyk') {
                $this->convertToCmyk($color, true);
            }
            if ($type != 'hex') {
                $this->convertToHex($color, true);
            }
            if ($type != 'hsb') {
                $this->convertToHsb($color, true);
            }
            if ($type != 'lab') {
                $this->convertToLab($color, true);
            }
            if ($type != 'rgb') {
                $this->convertToRgb($color, true);
            }

            ksort($this->colors);
        }

        return $this;
    }

    /**
     * Method to convert a color space object to a CMYK object
     *
     * @param  mixed   $color
     * @param  boolean $save
     * @throws Exception
     * @return Pop\Color\Cmyk
     */
    public function convertToCmyk($color, $save = false)
    {
        $class = get_class($color);

        if ($class == 'Pop\Color\Cmyk') {
            throw new Exception('That color space object is already that type.');
        }

        $type = strtolower(substr($class, (strrpos($class, '\\') + 1)));
        $method = $type . 'ToCmyk';

        $cmyk = $this->$method($color);

        if ($save) {
            $this->colors['cmyk'] = $cmyk;
        }

        return $cmyk;
    }

    /**
     * Method to convert a color space object to a hex RGB object
     *
     * @param  mixed   $color
     * @param  boolean $save
     * @throws Exception
     * @return Pop\Color\Hex
     */
    public function convertToHex($color, $save = false)
    {
        $class = get_class($color);

        if ($class == 'Pop\Color\Hex') {
            throw new Exception('That color space object is already that type.');
        }

        $type = strtolower(substr($class, (strrpos($class, '\\') + 1)));
        $method = $type . 'ToHex';

        $hex = $this->$method($color);

        if ($save) {
            $this->colors['hex'] = $hex;
        }

        return $hex;
    }

    /**
     * Method to convert a color space object to an HSB object
     *
     * @param  mixed   $color
     * @param  boolean $save
     * @throws Exception
     * @return Pop\Color\Hsb
     */
    public function convertToHsb($color, $save = false)
    {
        $class = get_class($color);

        if ($class == 'Pop\Color\Hsb') {
            throw new Exception('That color space object is already that type.');
        }

        $type = strtolower(substr($class, (strrpos($class, '\\') + 1)));
        $method = $type . 'ToHsb';

        $hsb = $this->$method($color);

        if ($save) {
            $this->colors['hsb'] = $hsb;
        }

        return $hsb;
    }

    /**
     * Method to convert a color space object to a LAB object
     *
     * @param  mixed   $color
     * @param  boolean $save
     * @throws Exception
     * @return Pop\Color\Lab
     */
    public function convertToLab($color, $save = false)
    {
        $class = get_class($color);

        if ($class == 'Pop\Color\Lab') {
            throw new Exception('That color space object is already that type.');
        }

        $type = strtolower(substr($class, (strrpos($class, '\\') + 1)));
        $method = $type . 'ToLab';

        $lab = $this->$method($color);

        if ($save) {
            $this->colors['lab'] = $lab;
        }

        return $lab;
    }

    /**
     * Method to convert a color space object to an integer RGB object
     *
     * @param  mixed   $color
     * @param  boolean $save
     * @throws Exception
     * @return Pop\Color\Rgb
     */
    public function convertToRgb($color, $save = false)
    {
        $class = get_class($color);

        if ($class == 'Pop\Color\Rgb') {
            throw new Exception('That color space object is already that type.');
        }

        $type = strtolower(substr($class, (strrpos($class, '\\') + 1)));
        $method = $type . 'ToRgb';

        $rgb = $this->$method($color);

        if ($save) {
            $this->colors['rgb'] = $rgb;
        }

        return $rgb;
    }

    /**
     * Method to convert an integer RGB object to a hex RGB object
     *
     * @param  Rgb $rgb
     * @return Pop\Color\Hex
     */
    public function rgbToHex(Rgb $rgb)
    {
        $hex = dechex($rgb->getRed()) . dechex($rgb->getGreen()) . dechex($rgb->getBlue());
        return new Hex($hex);
    }

    /**
     * Method to convert an integer RGB object to a CMYK object
     *
     * @param  Rgb $rgb
     * @return Pop\Color\Cmyk
     */
    public function rgbToCmyk(Rgb $rgb)
    {
        $K = 1;

        // Calculate CMY.
        $cyan = 1 - ($rgb->getRed() / 255);
        $magenta = 1 - ($rgb->getGreen() / 255);
        $yellow = 1 - ($rgb->getBlue() / 255);

        // Calculate K.
        if ($cyan < $K) {
            $K = $cyan;
        }
        if ($magenta < $K) {
            $K = $magenta;
        }
        if ($yellow < $K) {
            $K = $yellow;
        }

        if ($K == 1) {
            $cyan = 0;
            $magenta = 0;
            $yellow = 0;
        } else {
            $cyan = round((($cyan - $K) / (1 - $K)) * 100);
            $magenta = round((($magenta - $K) / (1 - $K)) * 100);
            $yellow = round((($yellow - $K) / (1 - $K)) * 100);
        }

        $black = round($K * 100);

        return new Cmyk($cyan, $magenta, $yellow, $black);
    }

    /**
     * Method to convert an integer RGB object to an HSB object
     *
     * @param  Rgb $rgb
     * @return Pop\Color\Hsb
     */
    public function rgbToHsb(Rgb $rgb)
    {
        // Calculate the hue.
        $r = $rgb->getRed();
        $g = $rgb->getGreen();
        $b = $rgb->getBlue();

        $min = min($r, min($g, $b));
        $max = max($r, max($g, $b));
        $delta = $max - $min;
        $h = 0;

        if ($delta > 0) {
            if ($max == $r && $max != $g) $h += ($g - $b) / $delta;
            if ($max == $g && $max != $b) $h += (2 + ($b - $r) / $delta);
            if ($max == $b && $max != $r) $h += (4 + ($r - $g) / $delta);
            $h /= 6;
        }

        // Calculate the saturation and brightness.
        $r = $rgb->getRed() / 255;
        $g = $rgb->getGreen() / 255;
        $b = $rgb->getBlue() / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        $s = $max;
        $b = $max;
        $d = $max - $min;
        $s = ($d == 0) ? 0 : $d / $max;

        return new Hsb(round($h * 360), round($s * 100), round($b * 100));
    }

    /**
     * Method to convert an integer RGB object to a LAB object
     *
     * @param  Rgb $rgb
     * @return Pop\Color\Lab
     */
    public function rgbToLab(Rgb $rgb)
    {
        $r = $rgb->getRed() / 255;
        $g = $rgb->getGreen() / 255;
        $b = $rgb->getBlue() / 255;

        if ($r > 0.04045) {
            $r = pow((($r + 0.055 ) / 1.055), 2.4);
        } else {
            $r = $r / 12.92;
        }
        if ($g > 0.04045) {
            $g = pow((($g + 0.055 ) / 1.055), 2.4);
        } else {
            $g = $g / 12.92;
        }
        if ($b > 0.04045) {
            $b = pow((($b + 0.055 ) / 1.055), 2.4);
        } else {
            $b = $b / 12.92;
        }

        $r = $r * 100;
        $g = $g * 100;
        $b = $b * 100;

        $x = (($r * 0.4124) + ($g * 0.3576) + ($b * 0.1805)) / 95.047;
        $y = (($r * 0.2126) + ($g * 0.7152) + ($b * 0.0722)) / 100.000;
        $z = (($r * 0.0193) + ($g * 0.1192) + ($b * 0.9505)) / 108.883;

        if ($x > 0.008856) {
            $x = pow($x, (1/3));
        } else {
            $x = (7.787 * $x) + (16 / 116);
        }
        if ($y > 0.008856) {
            $y = pow($y, (1/3));
        } else {
            $y = (7.787 * $y) + (16 / 116);
        }
        if ($z > 0.008856) {
            $z = pow($z, (1/3));
        } else {
            $z = (7.787 * $z) + (16 / 116);
        }

        $l = (116 * $y) - 16;
        $a = 500 * ($x - $y);
        $b = 200 * ($y - $z);

        return new Lab($l, $a, $b);
    }

    /**
     * Method to convert a CMYK object to an integer RGB object
     *
     * @param  Cmyk $cmyk
     * @return Pop\Color\Rgb
     */
    public function cmykToRgb(Cmyk $cmyk)
    {
        $cmykAry = array();

        // Calculate CMY.
        $cmykAry['c'] = $cmyk->getCyan() / 100;
        $cmykAry['m'] = $cmyk->getMagenta() / 100;
        $cmykAry['y'] = $cmyk->getYellow() / 100;
        $cmykAry['k'] = $cmyk->getBlack() / 100;

        $cyan = (($cmykAry['c'] * (1 - $cmykAry['k'])) + $cmykAry['k']);
        $magenta = (($cmykAry['m'] * (1 - $cmykAry['k'])) + $cmykAry['k']);
        $yellow = (($cmykAry['y'] * (1 - $cmykAry['k'])) + $cmykAry['k']);

        // Calculate RGB.
        $r = round((1 - $cyan) * 255);
        $g = round((1 - $magenta) * 255);
        $b = round((1 - $yellow) * 255);

        return new Rgb($r, $g, $b);
    }

    /**
     * Method to convert a CMYK object to a hex RGB object
     *
     * @param  Cmyk $cmyk
     * @return Pop\Color\Hex
     */
    public function cmykToHex(Cmyk $cmyk)
    {
        return $this->rgbToHex($this->cmykToRgb($cmyk));
    }

    /**
     * Method to convert a CMYK object to an HSB object
     *
     * @param  Cmyk $cmyk
     * @return Pop\Color\Hsb
     */
    public function cmykToHsb(Cmyk $cmyk)
    {
        return $this->rgbToHsb($this->cmykToRgb($cmyk));
    }

    /**
     * Method to convert a CMYK object to a LAB object
     *
     * @param  Cmyk $cmyk
     * @return Pop\Color\Lab
     */
    public function cmykToLab(Cmyk $cmyk)
    {
        return $this->rgbToLab($this->cmykToRgb($cmyk));
    }

    /**
     * Method to convert an HSB object to an integer RGB object
     *
     * @param  Hsb $hsb
     * @return Pop\Color\Rgb
     */
    public function hsbToRgb(Hsb $hsb)
    {
        $s = $hsb->getSaturation() / 100;
        $v = $hsb->getBrightness() / 100;

        if ($hsb->getSaturation() == 0) {
            $r = round($v * 255);
            $g = round($v * 255);
            $b = round($v * 255);
        } else {
            $h = $hsb->getHue() / 360;
            $h = $h * 6;
            if ($h == 6) {
                $h = 0;
            }

            $i = floor($h);
            $var1 = $v * (1 - $s);
            $var2 = $v * (1 - ($s * ($h - $i)));
            $var3 = $v * (1 - ($s * (1 - ($h - $i))));

            switch ($i) {
                case 0:
                    $r = $v;
                    $g = $var3;
                    $b = $var1;
                    break;
                case 1:
                    $r = $var2;
                    $g = $v;
                    $b = $var1;
                    break;
                case 2:
                    $r = $var1;
                    $g = $v;
                    $b = $var3;
                    break;
                case 3:
                    $r = $var1;
                    $g = $v;
                    $b = $var3;
                    break;
                case 4:
                    $r = $var3;
                    $g = $var1;
                    $b = $v;
                    break;
                default:
                    $r = $v;
                    $g = $var1;
                    $b = $var2;
            }

            $r = round($r * 255);
            $g = round($g * 255);
            $b = round($b * 255);
        }

        return new Rgb($r, $g, $b);
    }

    /**
     * Method to convert an HSB object to a hex RGB object
     *
     * @param  Hsb $hsb
     * @return Pop\Color\Hex
     */
    public function hsbToHex(Hsb $hsb)
    {
        return $this->rgbToHex($this->hsbToRgb($hsb));
    }

    /**
     * Method to convert an HSB object to a CMYK object
     *
     * @param  Hsb $hsb
     * @return Pop\Color\Cmyk
     */
    public function hsbToCmyk(Hsb $hsb)
    {
        return $this->rgbToCmyk($this->hsbToRgb($hsb));
    }

    /**
     * Method to convert an HSB object to a LAB object
     *
     * @param  Hsb $hsb
     * @return Pop\Color\Lab
     */
    public function hsbToLab(Hsb $hsb)
    {
        return $this->rgbToLab($this->hsbToRgb($hsb));
    }

    /**
     * Method to convert a LAB object to an integer RGB object
     *
     * @param  Lab $lab
     * @return Pop\Color\Rgb
     */
    public function labToRgb(Lab $lab)
    {
        $y = ($lab->getL() + 16) / 116;
        $x = ($lab->getA() / 500) + $y;
        $z = $y - ($lab->getB() / 200);

        if (pow($y, 3) > 0.008856) {
            $y = pow($y, 3);
        } else {
            $y = ($y - (16 / 116)) / 7.787;
        }
        if (pow($x, 3) > 0.008856) {
            $x = pow($x, 3);
        } else {
            $x = ($x - (16 / 116)) / 7.787;
        }
        if (pow($z, 3) > 0.008856) {
            $z = pow($z, 3);
        } else {
            $z = ($z - (16 / 116)) / 7.787;
        }

        $x = ($x * 95.047) / 100;
        $y = ($y * 100.000) / 100;
        $z = ($z * 108.883) / 100;

        $r = ($x * 3.2406) + ($y * -1.5372) + ($z * -0.4986);
        $g = ($x * -0.9689) + ($y * 1.8758) + ($z *  0.0415);
        $b = ($x * 0.0557) + ($y * -0.2040) + ($z *  1.0570);

        if ($r > 0.0031308) {
            $r = 1.055 * (pow($r, (1 / 2.4)) - 0.055);
        } else {
            $r = 12.92 * $r;
        }
        if ($g > 0.0031308) {
            $g = 1.055 * (pow($g, (1 / 2.4)) - 0.055);
        } else {
            $g = 12.92 * $g;
        }
        if ($b > 0.0031308) {
            $b = 1.055 * (pow($b, (1 / 2.4)) - 0.055);
        } else {
            $b = 12.92 * $b;
        }

        if ($r > 1) {
            $r -= 1;
        }
        if ($g > 1) {
            $g -= 1;
        }
        if ($b > 1) {
            $b -= 1;
        }

        $r = round($r * 255);
        $g = round($g * 255);
        $b = round($b * 255);

        return new Rgb($r, $g, $b);
    }

    /**
     * Method to convert a LAB object to a hex RGB object
     *
     * @param  Lab $lab
     * @return Pop\Color\Hex
     */
    public function labToHex(Lab $lab)
    {
        return $this->rgbToHex($this->labToRgb($lab));
    }

    /**
     * Method to convert a LAB object to a CMYK object
     *
     * @param  Lab $lab
     * @return Pop\Color\Cmyk
     */
    public function labToCmyk(Lab $lab)
    {
        return $this->rgbToCmyk($this->labToRgb($lab));
    }

    /**
     * Method to convert a LAB object to an HSB object
     *
     * @param  Lab $lab
     * @return Pop\Color\Hsb
     */
    public function labToHsb(Lab $lab)
    {
        return $this->rgbToHsb($this->labToRgb($lab));
    }

    /**
     * Get method to return the value of _colors[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        $name = strtolower($name);
        return array_key_exists($name, $this->colors) ? $this->colors[$name] : null;
    }

    /**
     * Return the isset value of _colors[$name].
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->colors[strtolower($name)]);
    }

    /**
     * Unset _colors[$name].
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        $name = strtolower($name);

        if (isset($this->colors[$name])) {
            unset($this->colors[$name]);
        }
    }

}
