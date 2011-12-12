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
namespace Pop\Auth\Adapter;

use Pop\Auth\Auth;

/**
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class AuthTable implements AdapterInterface
{

    /**
     * DB table name / class name
     * @var string
     */
    protected $_tableName = null;

    /**
     * Username field
     * @var string
     */
    protected $_usernameField = null;

    /**
     * Password field
     * @var string
     */
    protected $_passwordField = null;

    /**
     * Access field
     * @var string
     */
    protected $_accessField = null;

    /**
     * Constructor
     *
     * Instantiate the DbTable object
     *
     * @param string $tableName
     * @param string $usernameField
     * @param string $passwordField
     * @param string $accessField
     * @return void
     */
    public function __construct($tableName, $usernameField = 'username', $passwordField = 'password', $accessField = null)
    {
        $this->_tableName = $tableName;
        $this->_usernameField = $usernameField;
        $this->_passwordField = $passwordField;
        $this->_accessField = $accessField;
    }

    /**
     * Method to authenticate the user
     *
     * @param  string $username
     * @param  string $password
     * @return array
     */
    public function authenticate($username, $password)
    {
        $result = 0;
        $access = null;

        $table = $this->_tableName;
        $usernameField = $this->_usernameField;
        $passwordField = $this->_passwordField;
        $accessField = $this->_accessField;

        $user = $table::findBy($this->_usernameField, $username);

        if (!isset($user->$usernameField)) {
            $result = Auth::USER_NOT_FOUND;
        } else if ($user->$passwordField != $password) {
            $result = Auth::PASSWORD_INCORRECT;
        } else if ((null !== $accessField) && (strtolower($user->$accessField) == 'blocked')) {
            $result = Auth::USER_IS_BLOCKED;
        } else {
            if ((null !== $accessField) && (isset($user->$accessField))) {
                $access = $user->$accessField;
            }
            $result = Auth::USER_IS_VALID;
        }

        return array('result' => $result, 'access' => $access);
    }

}
