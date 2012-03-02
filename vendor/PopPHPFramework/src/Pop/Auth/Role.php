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
 * This is the Role class for the Auth component.
 *
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
    protected $name = null;

    /**
     * Role level value
     * @var int
     */
    protected $level = 0;

    /**
     * Constructor
     *
     * Instantiate the role object
     *
     * @param  string $name
     * @param  int    $level
     * @return void
     */
    public function __construct($name, $level)
    {
        $this->name = $name;
        $this->level = (int)$level;
    }

    /**
     * Static method to instantiate the role object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $name
     * @param  int    $level
     * @return Pop\Auth\Role
     */
    public static function factory($name, $level)
    {
        return new self($name, $level);
    }

    /**
     * Method to get the role name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Method to get the role level value
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Method to set the role name
     *
     * @param  string $name
     * @return Pop\Auth\Role
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Method to get the role level value
     *
     * @param  int $level
     * @return Pop\Auth\Role
     */
    public function setLevel($level)
    {
        $this->level = (int)$level;
        return $this;
    }

    /**
     * Method to compare role object to another role object
     *
     * @param Role $role
     * @return int
     */
    public function compare(Role $role)
    {
        $value = 0;

        if ($this->level < $role->getLevel()) {
            $value = -1;
        } else if ($this->level > $role->getLevel()) {
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
        $level = 0;
        if ($name == $this->name) {
            $level = $this->level;
        }

        return $level;
    }

    /**
     * Method to return the string value of the name of the role..
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

}
