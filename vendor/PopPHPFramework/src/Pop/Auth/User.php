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

use Pop\Auth\Role,
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class User
{

    /**
     * Username
     * @var string
     */
    protected $_username = null;

    /**
     * Password
     * @var string
     */
    protected $_password = null;

    /**
     * User role
     * @var Pop\Auth\Role
     */
    protected $_role = null;

    /**
     * Constructor
     *
     * Instantiate the user object
     *
     * @param  string        $username
     * @param  string        $password
     * @param  Pop\Auth\Role $role
     * @return void
     */
    public function __construct($username, $password, Role $role = null)
    {
        $this->_username = $username;
        $this->_password = $password;
        $this->_role = $role;
    }

    /**
     * Static method to instantiate the user object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string        $username
     * @param  string        $password
     * @param  Pop\Auth\Role $role
     * @return Pop\Auth\User
     */
    public static function factory($username, $password, $role = null)
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
        return $this->_username;
    }

    /**
     * Method to get the username
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Method to get the role
     *
     * @return Pop\Auth\Role
     */
    public function getRole()
    {
        return $this->_role;
    }


    /**
     * Method to get the role
     *
     * @return Pop\Auth\Role $role
     * @return Pop\Auth\User
     */
    public function setRole(Role $role)
    {
        $this->_role = $role;
        return $this;
    }

    /**
     * Method to get the role
     *
     * @param  Pop\Auth\Role $requiredRole
     * @param  boolean $equal
     * @throws Exception
     * @return string
     */
    public function isAuthorized(Role $requiredRole, $equal = true)
    {
        if (null === $this->_role) {
            throw new Exception(Locale::factory()->__('The user role has not been defined to evaluate against.'));
        }

        $result = false;

        // If user role is greater than or equal to required role
        if ($equal) {
            if ($this->_role->compare($requiredRole) >= 0) {
                $result = true;
            }
        // Else, if user role is greater than required role
        } else {
            if ($this->_role->compare($requiredRole) > 0) {
                $result = true;
            }
        }

        return $result;
    }

}
