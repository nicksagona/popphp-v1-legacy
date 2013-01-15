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
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Color;

/**
 * This is the Cmyk class for the Color component.
 *
 * @category   Pop
 * @package    Pop_Color
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
class Cmyk implements ColorInterface
{

    /**
     * Cyan percentage value
     * @var int
     */
    protected $cyan = null;

    /**
     * Magenta percentage value
     * @var int
     */
    protected $magenta = null;

    /**
     * Yellow percentage value
     * @var int
     */
    protected $yellow = null;

    /**
     * Black percentage value
     * @var int
     */
    protected $black = null;

    /**
     * Constructor
     *
     * Instantiate the CMYK color object
     *
     * @param int $c
     * @param int $m
     * @param int $y
     * @param int $k
     * @throws \Pop\Color\Exception
     * @return \Pop\Color\Cmyk
     */
    public function __construct($c, $m, $y, $k)
    {

        $max = max($c, $m, $y, $k);
        $min = min($c, $m, $y, $k);

        if (($max > 100) || ($min < 0)) {
            throw new Exception('One or more of the color values is out of range.');
        }

        $this->cyan = (int)$c;
        $this->magenta = (int)$m;
        $this->yellow = (int)$y;
        $this->black = (int)$k;
    }

    /**
     * Method to get the full CMYK value
     *
     * @param  int $type
     * @return string|array
     */
    public function get($type = Color::ASSOC_ARRAY)
    {

        $cmyk = null;

        switch ($type) {
            case 1:
                $cmyk = array('c' => $this->cyan, 'm' => $this->magenta, 'y' => $this->yellow, 'k' => $this->black);
                break;
            case 2:
                $cmyk = array($this->cyan, $this->magenta, $this->yellow, $this->black);
                break;
            case 3:
                $cmyk = $this->cyan . ',' . $this->magenta . ',' . $this->yellow . ',' . $this->black;
                break;
        }

        return $cmyk;

    }

    /**
     * Method to get the cyan value
     *
     * @return int
     */
    public function getCyan()
    {
        return $this->cyan;
    }

    /**
     * Method to get the magenta value
     *
     * @return int
     */
    public function getMagenta()
    {
        return $this->magenta;
    }

    /**
     * Method to get the yellow value
     *
     * @return int
     */
    public function getYellow()
    {
        return $this->yellow;
    }

    /**
     * Method to get the black value
     *
     * @return int
     */
    public function getBlack()
    {
        return $this->black;
    }

    /**
     * Method to return the string value for printing output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->get(Color::STRING);
    }

}
