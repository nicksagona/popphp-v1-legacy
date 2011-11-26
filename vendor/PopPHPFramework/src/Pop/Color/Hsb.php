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
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Color_Hsb
 *
 * @category   Pop
 * @package    Pop_Color
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Color_Hsb implements Pop_Color_Interface
{

    /**
     * Hue angle value in degrees
     * @var int
     */
    protected $_hue = null;

    /**
     * Saturation percentage value
     * @var int
     */
    protected $_saturation = null;

    /**
     * Brightness percentage value
     * @var int
     */
    protected $_brightness = null;

    /**
     * Constructor
     *
     * Instantiate the RGB color object
     *
     * @param int $h
     * @param int $s
     * @param int $b
     * @return void
     */
    public function __construct($h, $s, $b)
    {

        $max = max($s, $b);
        $min = min($s, $b);

        if (($h > 360) || ($h < 0) || ($max > 100) || ($min < 0)) {
            throw new Exception(Pop_Locale::load()->__('One or more of the color values is out of range.'));
        } else {
            $this->_hue = (int)$h;
            $this->_saturation = (int)$s;
            $this->_brightness = (int)$b;
        }

    }

    /**
     * Method to get the full HSB value
     *
     * @param  int     $type
     * @return string|array
     */
    public function getHsb($type = Pop_Color::ASSOC_ARRAY)
    {

        $hsb = null;

        switch ($type) {
            case 1:
                $hsb = array('h' => $this->_hue, 's' => $this->_saturation, 'b' => $this->_brightness);
                break;
            case 2:
                $hsb = array($this->_hue, $this->_saturation, $this->_brightness);
                break;
            case 3:
                $hsb = $this->_hue . ',' . $this->_saturation . ',' . $this->_brightness;
                break;
        }

        return $hsb;

    }

    /**
     * Method to get the hue value
     *
     * @return int
     */
    public function getHue()
    {
        return $this->_hue;
    }

    /**
     * Method to get the saturation value
     *
     * @return int
     */
    public function getSaturation()
    {
        return $this->_saturation;
    }

    /**
     * Method to get the brightness value
     *
     * @return int
     */
    public function getBrightness()
    {
        return $this->_brightness;
    }

    /**
     * Method to return the string value for printing output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getHsb(Pop_Color::STRING);
    }

}
