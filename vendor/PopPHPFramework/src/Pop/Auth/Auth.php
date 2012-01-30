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

use Pop\Auth\Adapter\AdapterInterface,
    Pop\Validator\Validator,
    Pop\Validator\Validator\Excluded,
    Pop\Validator\Validator\Included,
    Pop\Validator\Validator\Ipv4,
    Pop\Validator\Validator\Ipv6,
    Pop\Validator\Validator\IsSubnetOf,
    Pop\Validator\Validator\LessThan,
    Pop\Validator\Validator\Subnet,
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
     * Constant for user is valid result
     * @var int
     */
    const USER_IS_VALID = 1;

    /**
     * Constant for user not found result
     * @var int
     */
    const USER_NOT_FOUND = 2;

    /**
     * Constant for user is blocked result
     * @var int
     */
    const USER_IS_BLOCKED = 3;

    /**
     * Constant for password incorrect result
     * @var int
     */
    const PASSWORD_INCORRECT = 4;

    /**
     * Constant for login attempts exceeded result
     * @var int
     */
    const LOGIN_ATTEMPTS_EXCEEDED = 5;

    /**
     * Constant for IP address blocked result
     * @var int
     */
    const IP_BLOCKED = 6;

    /**
     * Constant for IP address blocked result
     * @var int
     */
    const IP_NOT_ALLOWED = 7;

    /**
     * Constant for session expired result
     * @var int
     */
    const SESSION_EXPIRED = 8;

    /**
     * Constant to trigger using no encryption
     * @var int
     */
    const ENCRYPT_NONE = 0;

    /**
     * Constant to trigger using md5() encryption
     * @var int
     */
    const ENCRYPT_MD5 = 1;

    /**
     * Constant to trigger using sha1() encryption
     * @var int
     */
    const ENCRYPT_SHA1 = 2;

    /**
     * Constant to trigger using crypt() encryption
     * @var int
     */
    const ENCRYPT_CRYPT = 3;

    /**
     * Auth user object
     * @var Pop\Auth\User
     */
    protected $_user = null;

    /**
     * Allowed roles.
     * @var array
     */
    protected $_allowedRoles = array();

    /**
     * Required role for authorization
     * @var Pop\Auth\Role
     */
    protected $_requiredRole = null;

    /**
     * Array of validator objects
     * @var array
     */
    protected $_validators = array(
        'allowedIps'     => null,
        'allowedSubnets' => null,
        'blockedIps'     => null,
        'blockedSubnets' => null,
        'attempts'       => null,
        'expiration'     => null
    );

    /**
     * Auth adapter object
     * @var mixed
     */
    protected $_adapter = null;

    /**
     * Session start timestamp
     * @var int
     */
    protected $_start = 0;

    /**
     * Expiration time in minutes
     * @var int
     */
    protected $_expiration = 0;

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
     * Current number of login attempts
     * @var int
     */
    protected $_attempts = 0;

    /**
     * Current IP address
     * @var string
     */
    protected $_ip = null;

    /**
     * Current subnet
     * @var array
     */
    protected $_subnet = null;

    /**
     * Authentication result
     * @var int
     */
    protected $_result = 0;

    /**
     * User validation result from authentication
     * @var boolean
     */
    protected $_isValid = false;

    /**
     * Constructor
     *
     * Instantiate the auth object
     * @param AdapterInterface $adapter
     * @param int              $encryption
     * @param string           $salt
     * @return void
     */
    public function __construct(AdapterInterface $adapter, $encryption = 0, $salt = null)
    {
        $this->_adapter = $adapter;
        $this->_start = time();
        $this->setEncryption($encryption);
        $this->_salt = $salt;
    }

    /**
     * Method to add a role
     *
     * @param  mixed $role
     * @return Pop\Auth\Auth
     */
    public function addRoles($role)
    {
        if (is_array($role)) {
            foreach ($role as $r) {
                if ($r instanceof Role) {
                    $this->_allowedRoles[$r->getName()] = $r;
                }
            }
        } else if ($role instanceof Role) {
            $this->_allowedRoles[$role->getName()] = $role;
        }
        return $this;
    }

    /**
     * Method to remove a role
     *
     * @param  mixed $role
     * @return Pop\Auth\Auth
     */
    public function removeRole($role)
    {
        $roleName = ($role instanceof Role) ? $role->getName() : $role;

        if (array_key_exists($roleName, $this->_allowedRoles)) {
            unset($this->_allowedRoles[$roleName]);
        }

        return $this;
    }

    /**
     * Method to get the current number of login attempts
     *
     * @return int
     */
    public function getAttempts()
    {
        return $this->_attempts;
    }

    /**
     * Method to get the session start
     *
     * @return int
     */
    public function getStart()
    {
        return $this->_start;
    }

    /**
     * Method to get the expiration
     *
     * @return int
     */
    public function getExpiration()
    {
        return $this->_expiration;
    }

    /**
     * Method to get the encryption
     *
     * @return int
     */
    public function getEncryption()
    {
        return $this->_encryption;
    }

    /**
     * Method to get the salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->_salt;
    }

    /**
     * Method to get the authentication result
     *
     * @return int
     */
    public function getResult()
    {
        return $this->_result;
    }

    /**
     * Method to get the authentication result message
     *
     * @return string
     */
    public function getResultMessage()
    {
        $msg = null;

        switch ($this->_result) {
            case self::USER_IS_VALID:
                $msg = Locale::factory()->__('The user is valid.');
                break;
            case self::USER_NOT_FOUND:
                $msg = Locale::factory()->__('The user was not found.');
                break;
            case self::USER_IS_BLOCKED:
                $msg = Locale::factory()->__('The user is blocked.');
                break;
            case self::PASSWORD_INCORRECT:
                $msg = Locale::factory()->__('The password was incorrect.');
                break;
            case self::LOGIN_ATTEMPTS_EXCEEDED:
                $msg = Locale::factory()->__(
                    'The allowed login attempts (%1) have been exceeded.',
                    $this->_validators['attempts']->getValidator()->getValue()
                );
                break;
            case self::IP_BLOCKED:
                $msg = Locale::factory()->__('That IP address is blocked.');
                break;
            case self::IP_NOT_ALLOWED:
                $msg = Locale::factory()->__('That IP address is not allowed.');
                break;
            case self::SESSION_EXPIRED:
                $msg = Locale::factory()->__('The session has expired.');
                break;
        }

        return $msg;
    }

    /**
     * Method to get the required role
     *
     * @return Pop\Auth\Role
     */
    public function getRequiredRole()
    {
        return $this->_requiredRole;
    }

    /**
     * Method to get the user
     *
     * @return Pop\Auth\User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Method to set the expiration
     *
     * @param  int $expiration
     * @return Pop\Auth\Auth
     */
    public function setExpiration($expiration = 0)
    {
        $this->_expiration = (int)$expiration;
        if ($this->_expiration == 0) {
            $this->_validators['expiration'] = null;
        } else {
            $exp = time() + ($this->_expiration * 60);
            $this->_validators['expiration'] = Validator::factory(new LessThan($exp));
        }
        return $this;
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
     * Method to set the required role
     *
     * @param  mixed $role
     * @param  int   $level
     * @return Pop\Auth\Auth
     */
    public function setRequiredRole($role = null, $level = 0)
    {
        if (null === $role) {
            $this->_requiredRole = null;
        } else {
            if ($role instanceof Role) {
                if (!array_key_exists($role->getName(), $this->_allowedRoles)) {
                    $this->_allowedRoles[$role->getName()] = $role;
                }
                $this->_requiredRole = $role;
            } else {
                if (!array_key_exists($role, $this->_allowedRoles)) {
                    $this->_allowedRoles[$role] = Role::factory($role, $level);
                }
                $this->_requiredRole = $this->_allowedRoles[$role];
            }
        }

        return $this;
    }

    /**
     * Method to set the number of login attempts allowed
     *
     * @param  int $attempts
     * @return Pop\Auth\Auth
     */
    public function setAttemptLimit($attempts = 0)
    {
        if ($attempts == 0) {
            $this->_validators['attempts'] = null;
        } else {
            $this->_validators['attempts'] = Validator::factory(new LessThan($attempts));
        }
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
     * Method to set the block IP addresses
     *
     * @param  string|array $ips
     * @return Pop\Auth\Auth
     */
    public function setBlockedIps($ips = null)
    {
        if (null === $ips) {
            $this->_validators['blockedIps'] = null;
        } else {
            $validIps = $this->_filterIps($ips);
            if (count($validIps) > 0) {
                $this->_validators['blockedIps'] = Validator::factory(new Excluded($validIps));
            }
        }
        return $this;
    }

    /**
     * Method to set the block subnets
     *
     * @param  string|array $subnets
     * @return Pop\Auth\Auth
     */
    public function setBlockedSubnets($subnets = null)
    {
        if (null === $subnets) {
            $this->_validators['blockedSubnets'] = null;
        } else {
            $validSubnets = $this->_filterSubnets($subnets);
            if (count($validSubnets) > 0) {
                $this->_validators['blockedSubnets'] = Validator::factory(new Excluded($validSubnets));
            }
        }
        return $this;
    }

    /**
     * Method to set the allowed IP addresses
     *
     * @param  string|array $ips
     * @return Pop\Auth\Auth
     */
    public function setAllowedIps($ips = null)
    {
        if (null === $ips) {
            $this->_validators['allowedIps'] = null;
        } else {
            $validIps = $this->_filterIps($ips);
            if (count($validIps) > 0) {
                $this->_validators['allowedIps'] = Validator::factory(new Included($validIps));
            }
        }
        return $this;
    }

    /**
     * Method to set the allowed subnets
     *
     * @param  string|array $subnets
     * @return Pop\Auth\Auth
     */
    public function setAllowedSubnets($subnets = null)
    {
        if (null === $subnets) {
            $this->_validators['allowedSubnets'] = null;
        } else {
            $validSubnets = $this->_filterSubnets($subnets);
            if (count($validSubnets) > 0) {
                $this->_validators['allowedSubnets'] = Validator::factory(new Included($validSubnets));
            }
        }
        return $this;
    }

    /**
     * Method to authenticate a user
     *
     * @param  string $username
     * @param  string $password
     * @return int
     */
    public function authenticate($username, $password)
    {
        $this->_result = 0;

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $this->_ip = $_SERVER['REMOTE_ADDR'];
            $this->_subnet = substr($this->_ip, 0, strrpos($this->_ip, '.'));
        }

        $this->_processValidators();

        if ($this->_result == 0) {
            $this->_user = new User($username, $this->_encryptPassword($password));

            $result = $this->_adapter->authenticate($this->_user->getUsername(), $this->_user->getPassword());
            $this->_result = $result['result'];

            if ((null !== $result['access']) && isset($this->_allowedRoles[$result['access']])) {
                $this->_user->setRole($this->_allowedRoles[$result['access']]);
            }

            if (!is_array($result['user'])) {
                $this->_user->setFields($result['user']->getValues());
            } else {
                $this->_user->setFields($result['user']);
            }
        }

        $this->_isValid = ($this->_result == 1) ? true : false;

        return $this->_result;
    }

    /**
     * Method to reauthenticate a user
     *
     * @return int
     */
    public function validate()
    {
        $this->_result = 0;

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $this->_ip = $_SERVER['REMOTE_ADDR'];
            $this->_subnet = substr($this->_ip, 0, strrpos($this->_ip, '.'));
        }

        $this->_processValidators(false);

        if (($this->_result == 0) && ($this->_isValid)) {
            $this->setExpiration($this->_expiration);
            $this->_result = 1;
        } else {
            $this->_isValid = false;
        }

        return $this->_result;
    }

    /**
     * Method to determine if the user is valid
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->_isValid;
    }

    /**
     * Method to determine if the user is authorized
     *
     * @return boolean
     */
    public function isAuthorized()
    {
        $result = false;

        if (null === $this->_requiredRole) {
            $result = true;
        } else {
            $result = $this->_user->isAuthorizedAs($this->_requiredRole);
        }

        return $result;
    }

    /**
     * Method to filter the ip addresses to confirm their validity
     *
     * @param  string|array $ips
     * @return array
     */
    protected function _filterIps($ips)
    {
        $validIps = array();

        if (!is_array($ips)) {
            $ips = array($ips);
        }

        foreach ($ips as $ip) {
            if ((Validator::factory(new Ipv4())->evaluate($ip)) ||
                (Validator::factory(new Ipv6())->evaluate($ip))) {
                $validIps[] = $ip;
            }
        }

        return $validIps;
    }

    /**
     * Method to filter the subnets to confirm their validity
     *
     * @param  string|array $subnets
     * @return array
     */
    protected function _filterSubnets($subnets)
    {
        $validSubnets = array();

        if (!is_array($subnets)) {
            $subnets = array($subnets);
        }

        foreach ($subnets as $subnet) {
            if (Validator::factory(new Subnet())->evaluate($subnet)) {
                $validSubnets[] = $subnet;
            }
        }

        return $validSubnets;
    }

    /**
     * Method to encrypt the password
     *
     * @param  string $pwd
     * @return string
     */
    protected function _encryptPassword($pwd)
    {
        $encrypted = $pwd;

        if ($this->_encryption == self::ENCRYPT_MD5) {
            $encrypted = md5($pwd);
        } else if ($this->_encryption == self::ENCRYPT_SHA1) {
            $encrypted = sha1($pwd);
        } else if ($this->_encryption == self::ENCRYPT_CRYPT) {
            $encrypted = crypt($pwd, $this->_salt);
        }

        return $encrypted;
    }

    /**
     * Method to process the validators
     *
     * @param  boolean $count
     * @return void
     */
    protected function _processValidators($count = true)
    {
        foreach ($this->_validators as $name => $validator) {
            if (null !== $validator) {
                switch ($name) {
                    case 'allowedIps':
                        if ((null !== $this->_ip) && (!$validator->evaluate($this->_ip))) {
                            $this->_result = self::IP_NOT_ALLOWED;
                        }
                        break;
                    case 'allowedSubnets':
                        if ((null !== $this->_subnet) && (!$validator->evaluate($this->_subnet))) {
                            $this->_result = self::IP_NOT_ALLOWED;
                        }
                        break;
                    case 'blockedIps':
                        if ((null !== $this->_ip) && (!$validator->evaluate($this->_ip))) {
                            $this->_result = self::IP_BLOCKED;
                        }
                        break;
                    case 'blockedSubnets':
                        if ((null !== $this->_subnet) && (!$validator->evaluate($this->_subnet))) {
                            $this->_result = self::IP_BLOCKED;
                        }
                        break;
                    case 'attempts':
                        if (!$validator->evaluate($this->_attempts)) {
                            $this->_result = self::LOGIN_ATTEMPTS_EXCEEDED;
                        }
                        break;
                    case 'expiration':
                        if (!$validator->evaluate(time())) {
                            $this->_result = self::SESSION_EXPIRED;
                        }
                        break;
                }
            }
        }

        if ($count) {
            $this->_attempts++;
        }
    }

}
