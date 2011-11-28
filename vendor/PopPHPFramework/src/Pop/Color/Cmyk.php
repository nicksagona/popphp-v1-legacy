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

use Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Color
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Cmyk implements ColorInterface
{

    /**
     * Cyan percentage value
     * @var int
     */
    protected $_cyan = null;

    /**
     * Magenta percentage value
     * @var int
     */
    protected $_magenta = null;

    /**
     * Yellow percentage value
     * @var int
     */
    protected $_yellow = null;

    /**
     * Black percentage value
     * @var int
     */
    protected $_black = null;

    /**
     * Constructor
     *
     * Instantiate the CMYK color object
     *
     * @param int $c
     * @param int $m
     * @param int $y
     * @param int $k
     * @return void
     */
    public function __construct($c, $m, $y, $k)
    {

        $max = max($c, $m, $y, $k);
        $min = min($c, $m, $y, $k);

        if (($max > 100) || ($min < 0)) {
            throw new Exception(Locale::factory()->__('One or more of the color values is out of range.'));
        } else {
            $this->_cyan = (int)$c;
            $this->_magenta = (int)$m;
            $this->_yellow = (int)$y;
            $this->_black = (int)$k;
        }

    }

    /**
     * Method to get the full CMYK value
     *
     * @param  int $type
     * @return string|array
     */
    public function getCmyk($type = Color::ASSOC_ARRAY)
    {

        $cmyk = null;

        switch ($type) {
            case 1:
                $cmyk = array('c' => $this->_cyan, 'm' => $this->_magenta, 'y' => $this->_yellow, 'k' => $this->_black);
                break;
            case 2:
                $cmyk = array($this->_cyan, $this->_magenta, $this->_yellow, $this->_black);
                break;
            case 3:
                $cmyk = $this->_cyan . ',' . $this->_magenta . ',' . $this->_yellow . ',' . $this->_black;
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
        return $this->_cyan;
    }

    /**
     * Method to get the magenta value
     *
     * @return int
     */
    public function getMagenta()
    {
        return $this->_magenta;
    }

    /**
     * Method to get the yellow value
     *
     * @return int
     */
    public function getYellow()
    {
        return $this->_yellow;
    }

    /**
     * Method to get the black value
     *
     * @return int
     */
    public function getBlack()
    {
        return $this->_black;
    }

    /**
     * Method to return the string value for printing output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getCmyk(Color::STRING);
    }

}
