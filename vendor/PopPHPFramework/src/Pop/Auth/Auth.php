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

use Pop\File\File,
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
     * Constant for password incorrect result
     * @var int
     */
    const PASSWORD_INCORRECT = 3;

    /**
     * Constant for login attempts exceeded result
     * @var int
     */
    const LOGIN_ATTEMPTS_EXCEEDED = 4;

    /**
     * Constant for IP address blocked result
     * @var int
     */
    const IP_BLOCKED = 5;

    /**
     * Constant to trigger using md5()
     * @var int
     */
    const ENCRYPT_MD5 = 6;

    /**
     * Constant to trigger using sha1()
     * @var int
     */
    const ENCRYPT_SHA1 = 7;

    /**
     * Constant to trigger using crypt()
     * @var int
     */
    const ENCRYPT_CRYPT = 8;

    /**
     * User object
     * @var array
     */
    public $user = null;

    /**
     * Auth options
     * @var array
     */
    protected $_options = null;

    /**
     * Encryption method to use
     * @var int
     */
    protected $_encryption = 0;

    /**
     * Encryption salt
     * @var string
     */
    protected $_salt = 0;

    /**
     * Allowed roles.
     * @var array
     */
    protected $_roles = array();

    /**
     * Level of required authorization
     * @var int
     */
    protected $_requiredAuthorization = 0;

    /**
     * Level of user authorization
     * @var int
     */
    protected $_userAuthorization = 0;

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
     * Possible options for the $option array parameter:
     *
     * For a database table. The table option must be an extended child class of Pop_Record.
     * $options = array(
     *                'table'          => 'Some_Table_Users',
     *                'username_field' => 'username',
     *                'password_field' => 'password',
     *                'access_field'   => 'access',
     *                'login_attempts' => 3,
     *                'blocked_ips'    => array('123.456.789.123', '123.456.789.*')
     *            );
     *
     * For a file on disk. This is more limited. Three delimited columns are allowed
     * (with the 3rd 'access' column being optional): username|password|access
     * The delimiter option defaults to a pipe '|', but you can set a different one.
     * $options = array(
     *                'file'      => 'path/to/file/access.txt',
     *                'delimiter' => ',',
     *                'login_attempts' => 3,
     *                'blocked_ips'    => array('123.456.789.123', '123.456.789.*')
     *            );
     *
     * @param  array  $options
     * @param  int    $encypt
     * @param  string $salt
     * @throws Exception
     * @return void
     */
    public function __construct($options, $encrypt = 0, $salt = null)
    {
        if (!is_array($options)) {
            throw new Exception(Locale::factory()->__('The options parameter must be an array.'));
        } else if (!isset($options['table']) && !isset($options['file'])) {
            throw new Exception(Locale::factory()->__('The options parameter must be an array that contains either a \'table\' or \'file\' key.'));
        } else {
            $this->_options = new \ArrayObject($options, \ArrayObject::ARRAY_AS_PROPS);
            $this->setEncryption($encrypt);
            $this->_salt = $salt;
        }
    }

    /**
     * Method to set the current number of attempts.
     *
     * @param  int $atts
     * @return Pop_Auth
     */
    public function setAttempts($atts = 0)
    {
        $this->_attempts = $atts;
        return $this;
    }

    /**
     * Method to get the current number of attempts.
     *
     * @return int
     */
    public function getAttempts()
    {
        return $this->_attempts;
    }

    /**
     * Method to set the current encryption.
     *
     * @param  int $enc
     * @return Pop_Auth
     */
    public function setEncryption($enc = 0)
    {
        switch ($enc) {
            case self::ENCRYPT_MD5:
                $this->_encryption = self::ENCRYPT_MD5;
                break;
            case self::ENCRYPT_SHA1:
                $this->_encryption = self::ENCRYPT_SHA1;
                break;
            case self::ENCRYPT_CRYPT:
                $this->_encryption = self::ENCRYPT_CRYPT;
                break;
            default:
                $this->_encryption = 0;
        }

        return $this;
    }

    /**
     * Method to get the current encryption.
     *
     * @return int
     */
    public function getEncryption()
    {
        return $this->_encryption;
    }

    /**
     * Method to set the allowed roles.
     *
     * @param  string|array $roles
     * @param  int          $level
     * @return Pop_Auth
     */
    public function setRoles($roles, $level = null)
    {
        if (is_string($roles) && (null !== $level)) {
            $this->_roles[$roles] = (int)$level;
        } else if (is_array($roles)) {
            foreach ($roles as $role => $lev) {
                $this->_roles[$role] = (int)$lev;
            }
        }

        return $this;
    }

    /**
     * Method to get the allowed roles.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->_roles;
    }

    /**
     * Method to authenticate the user
     *
     * @param  string $user
     * @param  string $pass
     * @param  array  $opts
     * @throws Exception
     * @return int
     */
    public function authenticate($user, $pass)
    {
        $result = -1;

        // Check if the IP or subnet of IP's are blocked
        if (isset($this->_options->blocked_ips) && ($this->_isBlockedIp($this->_options->blocked_ips))) {
            $this->_attempts++;
            $result = self::IP_BLOCKED;
        // Else, check if the number of login attempts have been exceeded
        } else if (isset($this->_options->login_attempts) && ($this->_options->login_attempts > 0) && ($this->_attempts > $this->_options->login_attempts)) {
            $this->_attempts++;
            $result = self::LOGIN_ATTEMPTS_EXCEEDED;
        // Else, check for a valid user and password
        } else {
            $lang = new Locale();

            // If the source is a file, check for user/pass in the file contents
            if (isset($this->_options->file) && ($this->_options->file != '') && file_exists($this->_options->file)) {
                $users = $this->_parseFile($this->_options->file);

                if (!array_key_exists($user, $users)) {
                    $this->_attempts++;
                    $result = self::USER_NOT_FOUND;
                } else if ($users[$user]['password'] != $this->_encryptPassword($pass, ((null !== $this->_salt) ? $this->_salt : $users[$user]['password']))) {
                    $this->_attempts++;
                    $result = self::PASSWORD_INCORRECT;
                } else {
                    $this->_attempts = 0;
                    $this->setUserAuthorization($users[$user]['access']);
                    $this->user = new \ArrayObject(array('username' => $user, 'access' => $users[$user]['access']), \ArrayObject::ARRAY_AS_PROPS);
                    $result = self::USER_IS_VALID;
                }
            // Else, if the source is a database table, check for user/pass in the database table
            } else if (isset($this->_options->table) && (class_exists($this->_options->table)) && isset($this->_options->username_field) && isset($this->_options->password_field)) {
                $table = $this->_options->table;
                $usernameField = $this->_options->username_field;
                $passwordField = $this->_options->password_field;
                $accessField = (isset($this->_options->access_field)) ? $this->_options->access_field : null;

                $tableObject = new $table();
                $tableObject->findBy($usernameField, $user);

                if (!isset($tableObject->$usernameField)) {
                    $this->_attempts++;
                    $result = self::USER_NOT_FOUND;
                } else if ($tableObject->$passwordField != $this->_encryptPassword($pass, ((null !== $this->_salt) ? $this->_salt : $tableObject->$passwordField))) {
                    $this->_attempts++;
                    $result = self::PASSWORD_INCORRECT;
                } else {
                    $this->_attempts = 0;
                    $this->setUserAuthorization((null !== $accessField) ? $tableObject->$accessField : 0);
                    $this->user = $tableObject;
                    $result = self::USER_IS_VALID;
                }
            } else {
                throw new Exception($lang->__('No source file or database table was passed.'));
            }
        }

        return $result;
    }

    /**
     * Method to set the required level of authorization
     *
     * @param  string|int $requiredAccess
     * @return Pop_Auth
     */
    public function setRequiredAuthorization($requiredAccess = 0)
    {
        if (is_string($requiredAccess)) {
            $requiredLevel = (isset($this->_roles[$requiredAccess])) ? $this->_roles[$requiredAccess] : 0;
        } else {
            $requiredLevel = (int)$requiredAccess;
        }

        $this->_requiredAuthorization = $requiredLevel;

        return $this;
    }

    /**
     * Method to set the user level of authorization
     *
     * @param  string|int $requiredAccess
     * @return Pop_Auth
     */
    public function setUserAuthorization($userAccess = 0)
    {
        if (is_string($userAccess)) {
            $userLevel = (isset($this->_roles[$userAccess])) ? $this->_roles[$userAccess] : 0;
        } else {
            $userLevel = (int)$userAccess;
        }

        $this->_userAuthorization = $userLevel;

        return $this;
    }

    /**
     * Method to determine if the user is authorized
     *
     * @param  string|int $userAccess
     * @return boolean
     */
    public function isAuthorized()
    {
        return ($this->_userAuthorization >= $this->_requiredAuthorization);
    }

    /**
     * Method to encrypt the password
     *
     * @param  string $pwd
     * @param  string $salt
     * @return string
     */
    protected function _encryptPassword($pwd, $salt = null)
    {
        $encrypted = $pwd;

        if ($this->_encryption == self::ENCRYPT_MD5) {
            $encrypted = md5($pwd);
        } else if ($this->_encryption == self::ENCRYPT_SHA1) {
            $encrypted = sha1($pwd);
        } else if ($this->_encryption == self::ENCRYPT_CRYPT) {
            $encrypted = crypt($pwd, $salt);
        }

        return $encrypted;
    }

    /**
     * Method to determine if the IP address or set of IP addresses are blocked
     *
     * @param  array|string $blocked
     * @return boolean
     */
    protected function _isBlockedIp($blocked)
    {
        $isBlocked = false;

        $ip = $_SERVER['REMOTE_ADDR'];
        $subnet = substr($_SERVER['REMOTE_ADDR'], 0, strrpos($_SERVER['REMOTE_ADDR'], '.')) . '.*';

        if (!is_array($blocked)) {
            $blocked = array($blocked);
        }

        if (in_array($ip, $blocked)) {
            $isBlocked = true;
        } else if (in_array($subnet, $blocked)) {
            $isBlocked = true;
        }

        return $isBlocked;
    }

    /**
     * Method to parse a source file.
     *
     * @param  string $fle
     * @return array
     */
    protected function _parseFile($fle)
    {
        $entryResults = array();
        $delim = (isset($this->_options->delimiter)) ? $this->_options->delimiter : '|';

        $userfile = new File($fle);
        $entries = trim($userfile->read());

        $entriesAry = explode(PHP_EOL, $entries);

        foreach ($entriesAry as $entry) {
            $ent = trim($entry);
            $entAry = explode($delim , $ent);
            if (isset($entAry[0]) && isset($entAry[1])) {
                $entryResults[$entAry[0]] = array(
                                                'password' => $entAry[1],
                                                'access'   => (isset($entAry[2]) ? $entAry[2] : 0)
                                            );
            }
        }

        return $entryResults;
    }

    /**
     * Set method to set the property to the value of _options[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->_options->$name = $value;
    }

    /**
     * Get method to return the value of _options[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (isset($this->_options->$name)) ? $this->_options->$name : null;
    }

}
