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
 * This is the Hsb class for the Color component.
 *
 * @category   Pop
 * @package    Pop_Color
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Hsb implements ColorInterface
{

    /**
     * Hue angle value in degrees
     * @var int
     */
    protected $hue = null;

    /**
     * Saturation percentage value
     * @var int
     */
    protected $saturation = null;

    /**
     * Brightness percentage value
     * @var int
     */
    protected $brightness = null;

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
            throw new Exception('One or more of the color values is out of range.');
        }

        $this->hue = (int)$h;
        $this->saturation = (int)$s;
        $this->brightness = (int)$b;
    }

    /**
     * Method to get the full HSB value
     *
     * @param  int     $type
     * @return string|array
     */
    public function getHsb($type = Color::ASSOC_ARRAY)
    {

        $hsb = null;

        switch ($type) {
            case 1:
                $hsb = array('h' => $this->hue, 's' => $this->saturation, 'b' => $this->brightness);
                break;
            case 2:
                $hsb = array($this->hue, $this->saturation, $this->brightness);
                break;
            case 3:
                $hsb = $this->hue . ',' . $this->saturation . ',' . $this->brightness;
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
        return $this->hue;
    }

    /**
     * Method to get the saturation value
     *
     * @return int
     */
    public function getSaturation()
    {
        return $this->saturation;
    }

    /**
     * Method to get the brightness value
     *
     * @return int
     */
    public function getBrightness()
    {
        return $this->brightness;
    }

    /**
     * Method to return the string value for printing output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getHsb(Color::STRING);
    }

}
