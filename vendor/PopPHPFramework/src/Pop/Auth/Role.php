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
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Auth;

/**
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Role
{

    /**
     * Role name
     * @var string
     */
    protected $_name = null;

    /**
     * Role value
     * @var int
     */
    protected $_value = 0;

    /**
     * Constructor
     *
     * Instantiate the role object
     *
     * @param  string $name
     * @param  int    $value
     * @return void
     */
    public function __construct($name, $value)
    {
        $this->_name = $name;
        $this->_value = (int)$value;
    }

    /**
     * Static method to instantiate the role object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $name
     * @param  int    $value
     * @return Pop\Auth\Role
     */
    public static function factory($name, $value)
    {
        return new self($name, $value);
    }

    /**
     * Method to get the role name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Method to get the role value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Method to compare role object to another role object
     *
     * @return int
     */
    public function compare(Role $role)
    {
        $value = 0;

        if ($this->_value < $role->getValue()) {
            $value = -1;
        } else if ($this->_value > $role->getValue()) {
            $value = 1;
        }

        return $value;
    }

    /**
     * Get method to get the role value by name
     *
     * @param  string $name
     * @return int
     */
    public function __get($name)
    {
        $value = null;
        if ($name == $this->_name) {
            $value = $this->_value;
        }

        return $value;
    }

}
