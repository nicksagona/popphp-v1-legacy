<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Auth;

/**
 * Auth role class
 *
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.2
 */
class Role
{

    /**
     * Role name
     * @var string
     */
    protected $name = null;

    /**
     * Role value value
     * @var int
     */
    protected $value = 0;

    /**
     * Constructor
     *
     * Instantiate the role object
     *
     * @param  string $name
     * @param  int    $value
     * @return \Pop\Auth\Role
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = (int)$value;
    }

    /**
     * Static method to instantiate the role object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $name
     * @param  int    $value
     * @return \Pop\Auth\Role
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
        return $this->name;
    }

    /**
     * Method to get the role value value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Method to set the role name
     *
     * @param  string $name
     * @return \Pop\Auth\Role
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Method to get the role value value
     *
     * @param  int $value
     * @return \Pop\Auth\Role
     */
    public function setValue($value)
    {
        $this->value = (int)$value;
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

        if ($this->value < $role->getValue()) {
            $value = -1;
        } else if ($this->value > $role->getValue()) {
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
        $value = 0;
        if ($name == $this->name) {
            $value = $this->value;
        }

        return $value;
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
