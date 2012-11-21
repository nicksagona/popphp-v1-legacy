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

use Pop\Validator\Validator,
    Pop\Validator\Validator\Excluded,
    Pop\Validator\Validator\Included,
    Pop\Validator\Validator\Ipv4,
    Pop\Validator\Validator\Ipv6,
    Pop\Validator\Validator\IsSubnetOf,
    Pop\Validator\Validator\LessThan,
    Pop\Validator\Validator\Subnet,
    Pop\Locale\Locale;

/**
 * This is the Auth class for the Auth component.
 *
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
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
    protected $user = null;

    /**
     * Allowed roles.
     * @var array
     */
    protected $allowedRoles = array();

    /**
     * Required role for authorization
     * @var Pop\Auth\Role
     */
    protected $requiredRole = null;

    /**
     * Array of validator objects
     * @var array
     */
    protected $validators = array(
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
    protected $adapter = null;

    /**
     * Session start timestamp
     * @var int
     */
    protected $start = 0;

    /**
     * Expiration time in minutes
     * @var int
     */
    protected $expiration = 0;

    /**
     * Encryption method to use
     * @var int
     */
    protected $encryption = 0;

    /**
     * Encryption salt
     * @var string
     */
    protected $salt = null;

    /**
     * Current number of login attempts
     * @var int
     */
    protected $attempts = 0;

    /**
     * Current IP address
     * @var string
     */
    protected $ip = null;

    /**
     * Current subnet
     * @var array
     */
    protected $subnet = null;

    /**
     * Authentication result
     * @var int
     */
    protected $result = 0;

    /**
     * User validation result from authentication
     * @var boolean
     */
    protected $isValid = false;

    /**
     * Constructor
     *
     * Instantiate the auth object
     * @param Adapter\AdapterInterface $adapter
     * @param int                      $encryption
     * @param string                   $salt
     * @return void
     */
    public function __construct(Adapter\AdapterInterface $adapter, $encryption = 0, $salt = null)
    {
        $this->adapter = $adapter;
        $this->start = time();
        $this->setEncryption($encryption);
        $this->salt = $salt;
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
                    $this->allowedRoles[$r->getName()] = $r;
                }
            }
        } else if ($role instanceof Role) {
            $this->allowedRoles[$role->getName()] = $role;
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

        if (array_key_exists($roleName, $this->allowedRoles)) {
            unset($this->allowedRoles[$roleName]);
        }

        return $this;
    }

    /**
     * Method to get the current number of login attempts
     *
     * @param  string $name
     * @return mixed
     */
    public function getValidator($name)
    {
        return $this->validators[$name];
    }

    /**
     * Method to get the current number of login attempts
     *
     * @return int
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * Method to get the session start
     *
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Method to get the expiration
     *
     * @return int
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Method to get the encryption
     *
     * @return int
     */
    public function getEncryption()
    {
        return $this->encryption;
    }

    /**
     * Method to get the salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Method to get the authentication result
     *
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Method to get the authentication result message
     *
     * @return string
     */
    public function getResultMessage()
    {
        $msg = null;

        switch ($this->result) {
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
                    $this->validators['attempts']->getValidator()->getValue()
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
        return $this->requiredRole;
    }

    /**
     * Method to get the user
     *
     * @return Pop\Auth\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Method to set the expiration
     *
     * @param  int $expiration
     * @return Pop\Auth\Auth
     */
    public function setExpiration($expiration = 0)
    {
        $this->expiration = (int)$expiration;
        if ($this->expiration == 0) {
            $this->validators['expiration'] = null;
        } else {
            $exp = time() + ($this->expiration * 60);
            $this->validators['expiration'] = Validator::factory(new LessThan($exp));
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
            $this->encryption = $enc;
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
        $this->salt = $salt;
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
            $this->requiredRole = null;
        } else {
            if ($role instanceof Role) {
                if (!array_key_exists($role->getName(), $this->allowedRoles)) {
                    $this->allowedRoles[$role->getName()] = $role;
                }
                $this->requiredRole = $role;
            } else {
                if (!array_key_exists($role, $this->allowedRoles)) {
                    $this->allowedRoles[$role] = Role::factory($role, $level);
                }
                $this->requiredRole = $this->allowedRoles[$role];
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
            $this->validators['attempts'] = null;
        } else {
            $this->validators['attempts'] = Validator::factory(new LessThan($attempts));
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
        $this->attempts = (int)$attempts;
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
            $this->validators['blockedIps'] = null;
        } else {
            $validIps = $this->filterIps($ips);
            if (count($validIps) > 0) {
                $this->validators['blockedIps'] = Validator::factory(new Excluded($validIps));
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
            $this->validators['blockedSubnets'] = null;
        } else {
            $validSubnets = $this->filterSubnets($subnets);
            if (count($validSubnets) > 0) {
                $this->validators['blockedSubnets'] = Validator::factory(new Excluded($validSubnets));
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
            $this->validators['allowedIps'] = null;
        } else {
            $validIps = $this->filterIps($ips);
            if (count($validIps) > 0) {
                $this->validators['allowedIps'] = Validator::factory(new Included($validIps));
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
            $this->validators['allowedSubnets'] = null;
        } else {
            $validSubnets = $this->filterSubnets($subnets);
            if (count($validSubnets) > 0) {
                $this->validators['allowedSubnets'] = Validator::factory(new Included($validSubnets));
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
        $this->result = 0;

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->subnet = substr($this->ip, 0, strrpos($this->ip, '.'));
        }

        $this->processValidators();

        if ($this->result == 0) {
            $this->user = new User($username, $this->encryptPassword($password));

            $result = $this->adapter->authenticate($this->user->getUsername(), $this->user->getPassword());
            $this->result = $result['result'];

            if ((null !== $result['access']) && isset($this->allowedRoles[$result['access']])) {
                $this->user->setRole($this->allowedRoles[$result['access']]);
            }

            if (!is_array($result['user'])) {
                $this->user->setFields($result['user']->getValues());
            } else {
                $this->user->setFields($result['user']);
            }
        }

        $this->isValid = ($this->result == 1) ? true : false;

        return $this->result;
    }

    /**
     * Method to reauthenticate a user
     *
     * @return int
     */
    public function validate()
    {
        $this->result = 0;

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->subnet = substr($this->ip, 0, strrpos($this->ip, '.'));
        }

        $this->processValidators(false);

        if (($this->result == 0) && ($this->isValid)) {
            $this->setExpiration($this->expiration);
            $this->result = 1;
        } else {
            $this->isValid = false;
        }

        return $this->result;
    }

    /**
     * Method to determine if the user is valid
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * Method to determine if the user is authorized
     *
     * @return boolean
     */
    public function isAuthorized()
    {
        $result = false;

        if (null === $this->requiredRole) {
            $result = true;
        } else {
            $result = $this->user->isAuthorizedAs($this->requiredRole);
        }

        return $result;
    }

    /**
     * Method to filter the ip addresses to confirm their validity
     *
     * @param  string|array $ips
     * @return array
     */
    protected function filterIps($ips)
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
    protected function filterSubnets($subnets)
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
    protected function encryptPassword($pwd)
    {
        $encrypted = $pwd;

        if ($this->encryption == self::ENCRYPT_MD5) {
            $encrypted = md5($pwd);
        } else if ($this->encryption == self::ENCRYPT_SHA1) {
            $encrypted = sha1($pwd);
        } else if ($this->encryption == self::ENCRYPT_CRYPT) {
            $encrypted = crypt($pwd, $this->salt);
        }

        return $encrypted;
    }

    /**
     * Method to process the validators
     *
     * @param  boolean $count
     * @return void
     */
    protected function processValidators($count = true)
    {
        foreach ($this->validators as $name => $validator) {
            if (null !== $validator) {
                switch ($name) {
                    case 'allowedIps':
                        if ((null !== $this->ip) && (!$validator->evaluate($this->ip))) {
                            $this->result = self::IP_NOT_ALLOWED;
                        }
                        break;
                    case 'allowedSubnets':
                        if ((null !== $this->subnet) && (!$validator->evaluate($this->subnet))) {
                            $this->result = self::IP_NOT_ALLOWED;
                        }
                        break;
                    case 'blockedIps':
                        if ((null !== $this->ip) && (!$validator->evaluate($this->ip))) {
                            $this->result = self::IP_BLOCKED;
                        }
                        break;
                    case 'blockedSubnets':
                        if ((null !== $this->subnet) && (!$validator->evaluate($this->subnet))) {
                            $this->result = self::IP_BLOCKED;
                        }
                        break;
                    case 'attempts':
                        if (!$validator->evaluate($this->attempts)) {
                            $this->result = self::LOGIN_ATTEMPTS_EXCEEDED;
                        }
                        break;
                    case 'expiration':
                        if (!$validator->evaluate(time())) {
                            $this->result = self::SESSION_EXPIRED;
                        }
                        break;
                }
            }
        }

        if ($count) {
            $this->attempts++;
        }
    }

}
