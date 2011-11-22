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
 * @package    Pop_Cookie
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Cookie
 *
 * @category   Pop
 * @package    Pop_Cookie
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Cookie
{

    /**
     * Instance of the cookie object
     * @var Pop_Cookie
     */
    static private $_instance;

    /**
     * Cookie IP
     * @var string
     */
    private $_ip = null;

    /**
     * Constructor
     *
     * Private method to instantiate the cookie object.
     *
     * @return void
     */
    private function __construct()
    {
        // Set the cookie owner's IP address.
        $this->_ip = $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Determine whether or not an instance of the cookie object exists
     * already, and instantiate the object if it doesn't exist.
     *
     * @return Pop_Cookie
     */
    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new Pop_Cookie();
        }

        return self::$_instance;
    }

    /**
     * Set a property in the cookie object that is linked to the $_COOKIE global variable.
     *
     * @param  string $name
     * @param  mixed $value
     * @param  int $exp
     * @return void
     */
    public function set($name, $value, $exp = 0)
    {
        setcookie($name, $value, $exp);
    }

    /**
     * Return the current the IP address.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->_ip;
    }

    /**
     * Get method to return the value of the $_COOKIE global variable.
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (isset($_COOKIE[$name])) ? $_COOKIE[$name] : null;
    }

    /**
     * Return the isset value of the $_COOKIE global variable.
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * Unset the value in the $_COOKIE global variable.
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        setcookie($name, $_COOKIE[$name], (time() - 3600));
    }

}
