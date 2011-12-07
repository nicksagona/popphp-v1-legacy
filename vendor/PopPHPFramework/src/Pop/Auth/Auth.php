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
    Pop\Filter\Rule,
    Pop\Filter\Rule\Excluded,
    Pop\Filter\Rule\Included,
    Pop\Filter\Rule\Ipv4,
    Pop\Filter\Rule\Ipv6,
    Pop\Filter\Rule\IsSubnetOf,
    Pop\Filter\Rule\LessThan,
    Pop\Filter\Rule\Subnet,
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
     * Array of Pop\Auth\Rule\* objects
     * @var array
     */
    protected $_rules = array(
                            'allowedIps'     => null,
                            'allowedSubnets' => null,
                            'blockedIps'     => null,
                            'blockedSubnets' => null,
                            'loginAttempts'  => null,
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
     * Current number of login attempts
     * @var int
     */
    protected $_loginAttempts = 0;

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
        $this->_ip = $_SERVER['REMOTE_ADDR'];
        $this->_subnet = substr($this->_ip, 0, strrpos($this->_ip, '.'));
    }

    /**
     * Method to get the current number of login attempts
     *
     * @return int
     */
    public function getLoginAttempts()
    {
        return $this->_loginAttempts;
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
                                             $this->_rules['loginAttempts']->getRule()->getValue()
                                             );
                break;
            case self::IP_BLOCKED:
                $msg = Locale::factory()->__('That IP address is blocked.');
                break;
            case self::IP_NOT_ALLOWED:
                $msg = Locale::factory()->__('That IP address is not allowed.');
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
     * Method to add a role
     *
     * @param  Pop\Auth\Role $role
     * @return Pop\Auth\Auth
     */
    public function addRole(Role $role)
    {
        $this->_allowedRoles[$role->getName()] = $role;
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

        if (array_key_exists($roleName, $this->_roles)) {
            unset($this->_roles[$roleName]);
        }

        return $this;
    }

    /**
     * Method to set the number of login attempts allowed
     *
     * @param  int $attempts
     * @return Pop\Auth\Auth
     */
    public function setLoginAttempts($attempts = 0)
    {
        if ($attempts == 0) {
            $this->_rules['loginAttempts'] = null;
        } else {
            $this->_rules['loginAttempts'] = Rule::factory(new LessThan($attempts));
        }
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
            $this->_rules['blockedIps'] = null;
        } else {
            $validIps = $this->_filterIps($ips);
            if (count($validIps) > 0) {
                $this->_rules['blockedIps'] = Rule::factory(new Excluded($validIps));
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
            $this->_rules['blockedSubnets'] = null;
        } else {
            $validSubnets = $this->_filterSubnets($subnets);
            if (count($validSubnets) > 0) {
                $this->_rules['blockedSubnets'] = Rule::factory(new Excluded($validSubnets));
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
            $this->_rules['allowedIps'] = null;
        } else {
            $validIps = $this->_filterIps($ips);
            if (count($validIps) > 0) {
                $this->_rules['allowedIps'] = Rule::factory(new Included($validIps));
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
            $this->_rules['allowedSubnets'] = null;
        } else {
            $validSubnets = $this->_filterSubnets($subnets);
            if (count($validSubnets) > 0) {
                $this->_rules['allowedSubnets'] = Rule::factory(new Included($validSubnets));
            }
        }
        return $this;
    }

    /**
     * Method to set the required role
     *
     * @param  Pop\Auth\Role $role
     * @return Pop\Auth\Auth
     */
    public function setRequiredRole(Role $role)
    {
        $this->_requiredRole = $role;
        return $this;
    }

    /**
     * Method to authenticate a user
     *
     * @param  string        $username
     * @param  string        $password
     * @return int
     */
    public function authenticate($username, $password)
    {
        $this->_processRules();

        if ($this->_result == 0) {
            $this->_user = new User($username, $this->_encryptPassword($password));

            $result = $this->_adapter->authenticate($this->_user->getUsername(), $this->_user->getPassword());
            $this->_result = $result['result'];

            if ((null !== $result['access']) && isset($this->_allowedRoles[$result['access']])) {
                $this->_user->setRole($this->_allowedRoles[$result['access']]);
            }
        }

        return $this->_result;
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
            if ((Rule::factory(new Ipv4())->evaluate($ip)) ||
                (Rule::factory(new Ipv6())->evaluate($ip))) {
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
            if (Rule::factory(new Subnet())->evaluate($subnet)) {
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
     * Method to process the rules
     *
     * @return void
     */
    protected function _processRules()
    {
        foreach ($this->_rules as $name => $rule) {
            if (null !== $rule) {
                switch ($name) {
                    case 'allowedIps':
                        if (!$rule->evaluate($this->_ip)) {
                            $this->_result = self::IP_NOT_ALLOWED;
                        }
                        break;
                    case 'allowedSubnets':
                        if (!$rule->evaluate($this->_subnet)) {
                            $this->_result = self::IP_NOT_ALLOWED;
                        }
                        break;
                    case 'blockedIps':
                        if (!$rule->evaluate($this->_ip)) {
                            $this->_result = self::IP_BLOCKED;
                        }
                        break;
                    case 'blockedSubnets':
                        if (!$rule->evaluate($this->_subnet)) {
                            $this->_result = self::IP_BLOCKED;
                        }
                        break;
                    case 'loginAttempts':
                        if (!$rule->evaluate($this->_loginAttempts)) {
                            $this->_result = self::LOGIN_ATTEMPTS_EXCEEDED;
                        }
                        break;
                }
            }
        }

        $this->_loginAttempts++;
    }

}
