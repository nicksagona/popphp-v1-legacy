<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Web
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Web;

/**
 * Cookie class
 *
 * @category   Pop
 * @package    Pop_Web
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Cookie
{

    /**
     * Instance of the cookie object
     * @var \Pop\Web\Cookie
     */
    static private $instance;

    /**
     * Cookie IP
     * @var string
     */
    private $ip = null;

    /**
     * Constructor
     *
     * Private method to instantiate the cookie object.
     *
     * @return \Pop\Web\Cookie
     */
    private function __construct()
    {
        // Set the cookie owner's IP address.
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Determine whether or not an instance of the cookie object exists
     * already, and instantiate the object if it doesn't exist.
     *
     * @return \Pop\Web\Cookie
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Cookie();
        }

        return self::$instance;
    }

    /**
     * Set a property in the cookie object that is linked to the $_COOKIE global variable.
     *
     * @param  string  $name
     * @param  mixed   $value
     * @param  int     $expire
     * @param  string  $path
     * @param  string  $domain
     * @param  boolean $secure
     * @param  boolean $httponly
     * @return void
     */
    public function set($name, $value, $expire = 0, $path = '/', $domain = null, $secure = false, $httponly = false)
    {
        if (null !== $domain) {
            $domain = $_SERVER['HTTP_HOST'];
        }
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Return the current the IP address.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
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
