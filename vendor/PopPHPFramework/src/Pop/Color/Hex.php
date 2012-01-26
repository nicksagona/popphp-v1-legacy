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
 * @category   Pop
 * @package    Pop_Color
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Hex implements ColorInterface
{

    /**
     * Red value
     * @var string
     */
    protected $_red = null;

    /**
     * Green value
     * @var string
     */
    protected $_green = null;

    /**
     * Blue value
     * @var string
     */
    protected $_blue = null;

    /**
     * Hex value
     * @var string
     */
    protected $_hex = null;

    /**
     * Shorthand hex value
     * @var string
     */
    protected $_shorthand = null;

    /**
     * Constructor
     *
     * Instantiate the hex color object
     *
     * @param string $hex
     * @return void
     */
    public function __construct($hex)
    {


        $hex = (substr($hex, 0, 1) == '#') ? substr($hex, 1) : $hex;

        if (strlen($hex) == 3) {
            $this->_hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
            $this->_shorthand = $hex;
        } else {
            $this->_hex = $hex;
        }
        $this->_red = substr($this->_hex, 0, 2);
        $this->_green = substr($this->_hex, 2, 2);
        $this->_blue = substr($this->_hex, 4, 2);

        $dR = base_convert($this->_red, 16, 10);
        $dG = base_convert($this->_green, 16, 10);
        $dB = base_convert($this->_blue, 16, 10);

        $max = max($dR, $dG, $dB);
        $min = min($dR, $dG, $dB);

        if (($max > 255) || ($min < 0)) {
            throw new Exception('One or more of the color values is out of range.');
        }

        $r = null;
        $g = null;
        $b = null;

        if (substr($this->_hex, 0, 1) == substr($this->_hex, 1, 1)) {
            $r = substr($this->_hex, 0, 1);
        }
        if (substr($this->_hex, 2, 1) == substr($this->_hex, 3, 1)) {
            $g = substr($this->_hex, 2, 1);
        }
        if (substr($this->_hex, 4, 1) == substr($this->_hex, 5, 1)) {
            $b = substr($this->_hex, 4, 1);
        }

        if ((null !== $r) && (null !== $g) && (null !== $b)) {
            $this->_shorthand = $r . $g . $b;
        } else {
            $this->_shorthand = null;
        }
    }

    /**
     * Method to get the full RGB hex value
     *
     * @param  boolean $hash
     * @param  boolean $short
     * @return string
     */
    public function getHex($hash = false, $short = false)
    {

        $hex = null;

        if (($short) && (null !== $this->_shorthand)) {
            $hex = ($hash) ? '#' . $this->_shorthand : $this->_shorthand;
        } else {
            $hex = ($hash) ? '#' . $this->_hex : $this->_hex;
        }

        return $hex;

    }

    /**
     * Method to get the red hex value
     *
     * @return int
     */
    public function getRed()
    {
        return $this->_red;
    }

    /**
     * Method to get the green hex value
     *
     * @return int
     */
    public function getGreen()
    {
        return $this->_green;
    }

    /**
     * Method to get the blue hex value
     *
     * @return int
     */
    public function getBlue()
    {
        return $this->_blue;
    }

    /**
     * Method to return the string value for printing output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getHex(true);
    }

}
