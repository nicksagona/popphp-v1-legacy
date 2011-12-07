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

use Pop\Auth\Adapter\AccessFile,
    Pop\Auth\Adapter\AdapterInterface,
    Pop\Auth\Adapter\DbTable,
    Pop\Auth\Rule\AllowedIps,
    Pop\Auth\Rule\Attempts,
    Pop\Auth\Rule\BlockedIps,
    Pop\Auth\Rule\RuleInterface,
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Auth
{

    /**
     * Constant to trigger using no encryption
     * @var int
     */
    const NO_ENCRYPT = 0;

    /**
     * Constant to trigger using md5() encryption
     * @var int
     */
    const MD5 = 1;

    /**
     * Constant to trigger using sha1() encryption
     * @var int
     */
    const SHA1 = 2;

    /**
     * Constant to trigger using crypt() encryption
     * @var int
     */
    const CRYPT = 3;

    /**
     * Auth user object
     * @var Pop\Auth\User
     */
    protected $_user = null;

    /**
     * Required role for authorization
     * @var Pop\Auth\Role
     */
    protected $_requiredRole = null;

    /**
     * Array of Pop\Auth\Rule\* objects
     * @var array
     */
    protected $_rules = array(
                            'attempts'    => null,
                            'ips_blocked' => null,
                            'ips_allowed' => null
                        );

    /**
     * Auth adapter object
     * @var mixed
     */
    protected $_adapter = null;

    /**
     * Encryption method to use
     * @var int
     */
    protected $_encryption = 0;

    /**
     * Encryption salt
     * @var string
     */
    protected $_salt = null;

    /**
     * Number of attempts
     * @var int
     */
    protected $_attempts = 0;

    /**
     * Constructor
     *
     * Instantiate the auth object
     *
     * @return void
     */
    public function __construct(AdapterInterface $adapter, $encryption = 0, $salt = null)
    {
        $this->_adapter = $adapter;

        $enc = (int)$encryption;
        if (($enc >= 0) && ($enc <= 3)) {
            $this->_encryption = $enc;
        }

        $this->_salt = $salt;
    }

    /**
     * Method to set the encryption
     *
     * @param  int $encryption
     * @return Pop\Auth\Auth
     */
    public function setEncryption($encryption = 0)
    {
        $enc = (int)$encryption;
        if (($enc >= 0) && ($enc <= 3)) {
            $this->_encryption = $enc;
        }

        return $this;
    }

    /**
     * Method to set the encryption
     *
     * @param  string $salt
     * @return Pop\Auth\Auth
     */
    public function setSalt($salt = null)
    {
        $this->_salt = $salt;
        return $this;
    }

    /**
     * Method to set the number of login attempts allowed
     *
     * @param  int $attempts
     * @return Pop\Auth\Auth
     */
    public function setAttempts($attempts = 0)
    {
        $this->_attempts = (int)$attempts;
        return $this;
    }

    /**
     * Method to set the required role
     *
     * @param  mixed $role
     * @return Pop\Auth\Auth
     */
    public function setRequiredRole(Role $role)
    {
        $this->_requiredRole = $role;
        return $this;
    }

}
