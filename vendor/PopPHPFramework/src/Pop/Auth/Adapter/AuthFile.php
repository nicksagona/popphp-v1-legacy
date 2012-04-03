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

use Pop\Auth\Auth,
    Pop\File\File;

/**
 * This is the AuthFile adapter class for the Auth component.
 *
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0
 */
class AuthFile extends File implements AdapterInterface
{

    /**
     * Field delimiter
     * @var string
     */
    protected $delimiter = null;

    /**
     * Users
     * @var array
     */
    protected $users = array();

    /**
     * Constructor
     *
     * Instantiate the AccessFile object
     *
     * @param string $filename
     * @param string $delimiter
     * @throws Exception
     * @return void
     */
    public function __construct($filename, $delimiter = '|')
    {
        if (!file_exists($filename)) {
            throw new Exception('The access file does not exist.');
        }
        parent::__construct($filename, array());
        $this->delimiter = $delimiter;
        $this->parse();
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
        $user = array('username' => $username);

        if (!array_key_exists($username, $this->users)) {
            $result = Auth::USER_NOT_FOUND;
        } else if ($this->users[$username]['password'] != $password) {
            $result = Auth::PASSWORD_INCORRECT;
        } else if ((strtolower($this->users[$username]['access']) == 'blocked') || ($this->users[$username]['access'] == 0)) {
            $result = Auth::USER_IS_BLOCKED;
        } else {
            $access = $this->users[$username]['access'];
            $result = Auth::USER_IS_VALID;
            $user = array_merge($user, $this->users[$username]);
        }

        return array('result' => $result, 'access' => $access, 'user' => $user);
    }

    /**
     * Method to parse the source file.
     *
     * @return void
     */
    protected function parse()
    {
        $entries = explode("\n", trim($this->read()));

        foreach ($entries as $entry) {
            $ent = trim($entry);
            $entAry = explode($this->delimiter , $ent);
            if (isset($entAry[0]) && isset($entAry[1])) {
                $this->users[$entAry[0]] = array(
                    'password' => $entAry[1],
                    'access'   => (isset($entAry[2]) ? $entAry[2] : null)
                );
            }
        }
    }
}
