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
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Auth;

/**
 * This is the User class for the Auth component.
 *
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.2.0
 */
class User
{

    /**
     * Username
     * @var string
     */
    protected $username = null;

    /**
     * Password
     * @var string
     */
    protected $password = null;

    /**
     * User role
     * @var \Pop\Auth\Role
     */
    protected $role = null;

    /**
     * User fields
     * @var array
     */
    protected $fields = array();

    /**
     * Constructor
     *
     * Instantiate the user object
     *
     * @param  string $username
     * @param  string $password
     * @param  Role   $role
     * @return \Pop\Auth\User
     */
    public function __construct($username = null, $password = null, Role $role = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
        $this->fields['username'] = $username;
        $this->fields['password'] = $password;
    }

    /**
     * Static method to instantiate the user object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $username
     * @param  string $password
     * @param  Role   $role
     * @return \Pop\Auth\User
     */
    public static function factory($username = null, $password = null, Role $role = null)
    {
        return new self($username, $password, $role);
    }

    /**
     * Method to get the username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Method to get the password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Method to get the role
     *
     * @return \Pop\Auth\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Method to set the username
     *
     * @param  string $username
     * @return \Pop\Auth\User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Method to set the password
     *
     * @param  string $password
     * @return \Pop\Auth\User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Method to set the role
     *
     * @param  Role $role
     * @return \Pop\Auth\User
     */
    public function setRole(Role $role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Method to set the user fields
     *
     * @param  array $fields
     * @return \Pop\Auth\User
     */
    public function setFields(array $fields)
    {
        foreach ($fields as $key => $value) {
            $this->fields[$key] = $value;
        }
        return $this;
    }

    /**
     * Method to evaluate if the user is authorized
     *
     * @param  Role $requiredRole
     * @return boolean
     */
    public function isAuthorizedAs(Role $requiredRole)
    {
        $result = false;

        // If user role is defined and is greater than or equal to required role
        if ((null !== $this->role) && ($this->role->compare($requiredRole) >= 0)) {
            $result = true;
        }

        return $result;
    }

    /**
     * Get method to return the value of _fields[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (isset($this->fields[$name])) ? $this->fields[$name] : null;
    }

}
