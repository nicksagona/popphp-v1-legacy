<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Color
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Color\Space;

/**
 * RGB color class
 *
 * @category   Pop
 * @package    Pop_Color
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Rgb implements ColorInterface
{

    /**
     * Red value
     * @var int
     */
    protected $red = null;

    /**
     * Green value
     * @var int
     */
    protected $green = null;

    /**
     * Blue value
     * @var int
     */
    protected $blue = null;

    /**
     * Constructor
     *
     * Instantiate the RGB color object
     *
     * @param int $r
     * @param int $g
     * @param int $b
     * @throws \Pop\Color\Space\Exception
     * @return \Pop\Color\Space\Rgb
     */
    public function __construct($r, $g, $b)
    {
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        if (($max > 255) || ($min < 0)) {
            throw new Exception('One or more of the color values is out of range.');
        }

        $this->red = (int)$r;
        $this->green = (int)$g;
        $this->blue = (int)$b;
    }

    /**
     * Method to get the full RGB value
     *
     * @param  int     $type
     * @param  boolean $css
     * @return string|array
     */
    public function get($type = \Pop\Color\Color::ASSOC_ARRAY, $css = false)
    {
        $rgb = null;

        switch ($type) {
            case 1:
                $rgb = array('r' => $this->red, 'g' => $this->green, 'b' => $this->blue);
                break;
            case 2:
                $rgb = array($this->red, $this->green, $this->blue);
                break;
            case 3:
                if ($css) {
                    $rgb = 'rgb(' . $this->red . ',' . $this->green . ',' . $this->blue . ')';
                } else {
                    $rgb = $this->red . ',' . $this->green . ',' . $this->blue;
                }
                break;
        }

        return $rgb;
    }

    /**
     * Method to get the red value
     *
     * @return int
     */
    public function getRed()
    {
        return $this->red;
    }

    /**
     * Method to get the green value
     *
     * @return int
     */
    public function getGreen()
    {
        return $this->green;
    }

    /**
     * Method to get the blue value
     *
     * @return int
     */
    public function getBlue()
    {
        return $this->blue;
    }

    /**
     * Method to return the string value for printing output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->get(\Pop\Color\Color::STRING);
    }

}
