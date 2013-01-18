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
namespace Pop\Auth\Adapter;

/**
 * Table auth adapter class
 *
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Table implements AdapterInterface
{

    /**
     * DB table name / class name
     * @var string
     */
    protected $tableName = null;

    /**
     * Username field
     * @var string
     */
    protected $usernameField = null;

    /**
     * Password field
     * @var string
     */
    protected $passwordField = null;

    /**
     * Access field
     * @var string
     */
    protected $accessField = null;

    /**
     * Constructor
     *
     * Instantiate the DbTable object
     *
     * @param string $tableName
     * @param string $usernameField
     * @param string $passwordField
     * @param string $accessField
     * @return \Pop\Auth\Adapter\Table
     */
    public function __construct($tableName, $usernameField = 'username', $passwordField = 'password', $accessField = null)
    {
        $this->tableName = $tableName;
        $this->usernameField = $usernameField;
        $this->passwordField = $passwordField;
        $this->accessField = $accessField;
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
        $access = null;

        $table = $this->tableName;
        $usernameField = $this->usernameField;
        $passwordField = $this->passwordField;
        $accessField = $this->accessField;

        $user = $table::findBy(array($this->usernameField => $username));

        if (!isset($user->$usernameField)) {
            $result = \Pop\Auth\Auth::USER_NOT_FOUND;
        } else if ($user->$passwordField != $password) {
            $result = \Pop\Auth\Auth::PASSWORD_INCORRECT;
            } else if ((null !== $accessField) && ((strtolower($user->$accessField) == 'blocked') || (is_numeric($user->$accessField) && ($user->$accessField == 0)))) {
            $result = \Pop\Auth\Auth::USER_IS_BLOCKED;
        } else {
            if ((null !== $accessField) && (isset($user->$accessField))) {
                $access = $user->$accessField;
            }
            $result = \Pop\Auth\Auth::USER_IS_VALID;
        }

        return array('result' => $result, 'access' => $access, 'user' => $user);
    }

}
