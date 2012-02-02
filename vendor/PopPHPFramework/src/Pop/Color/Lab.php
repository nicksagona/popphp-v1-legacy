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
class Lab implements ColorInterface
{

    /**
     * Lightness value
     * @var int
     */
    protected $l = null;

    /**
     * A value
     * @var int
     */
    protected $a = null;

    /**
     * B value
     * @var int
     */
    protected $b = null;

    /**
     * Constructor
     *
     * Instantiate the LAB color object
     *
     * @param int $l
     * @param int $a
     * @param int $b
     * @return void
     */
    public function __construct($l, $a, $b)
    {

        $max = max($l, $a, $b);
        $min = min($l, $a, $b);

        if (($l > 100) || ($l < 0) || ($max > 127) || ($min < -128)) {
            throw new Exception('One or more of the color values is out of range.');
        }

        $this->l = (int)$l;
        $this->a = (int)$a;
        $this->b = (int)$b;
    }

    /**
     * Method to get the full LAB value
     *
     * @param  int     $type
     * @return string|array
     */
    public function getLab($type = Color::ASSOC_ARRAY)
    {

        $lab = null;

        switch ($type) {
            case 1:
                $lab = array('l' => $this->l, 'a' => $this->a, 'b' => $this->b);
                break;
            case 2:
                $lab = array($this->l, $this->a, $this->b);
                break;
            case 3:
                $lab = $this->l . ',' . $this->a . ',' . $this->b;
                break;
        }

        return $lab;

    }

    /**
     * Method to get the L value
     *
     * @return int
     */
    public function getL()
    {
        return $this->l;
    }

    /**
     * Method to get the A value
     *
     * @return int
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * Method to get the B value
     *
     * @return int
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * Method to return the string value for printing output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getLab(Color::STRING);
    }

}
