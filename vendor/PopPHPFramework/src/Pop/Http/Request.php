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
 * @package    Pop_Http
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Http;

/**
 * @category   Pop
 * @package    Pop_Http
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Request
{

    /**
     * Request URI
     * @var string
     */
    protected $_requestUri = null;

    /**
     * Path segments
     * @var array
     */
    protected $_path = array();
    /**
     * Base path
     * @var string
     */
    protected $_basePath = null;

    /**
     * Document root
     * @var string
     */
    protected $_docRoot = null;

    /**
     * Full path
     * @var string
     */
    protected $_fullPath = null;

    /**
     * Request filename
     * @var string
     */
    protected $_filename = null;

    /**
     * Is the request a real file
     * @var boolean
     */
    protected $_isFile = false;

    /**
     * Is the request secure
     * @var boolean
     */
    protected $_isSecure = false;

    /**
     * $_GET vars
     * @var array
     */
    protected $_get = array();

    /**
     * $_POST vars
     * @var array
     */
    protected $_post = array();

    /**
     * $_COOKIE vars
     * @var array
     */
    protected $_cookie = array();

    /**
     * $_SERVER vars
     * @var array
     */
    protected $_server = array();

    /**
     * $_ENV vars
     * @var array
     */
    protected $_env = array();

    /**
     * Constructor
     *
     * Instantiate the request object.
     *
     * @param  string $uri
     * @param  string $basePath
     * @return void
     */
    public function __construct($uri = null, $basePath = null)
    {
        $this->setRequestUri($uri, $basePath);

        $this->_get = (isset($_GET)) ? $_GET : array();
        $this->_post = (isset($_POST)) ? $_POST : array();
        $this->_cookie = (isset($_COOKIE)) ? $_COOKIE : array();
        $this->_server = (isset($_SERVER)) ? $_SERVER : array();
        $this->_env = (isset($_ENV)) ? $_ENV : array();
    }

    /**
     * Return if the file is an actual file
     *
     * @return boolean
     */
    public function isFile()
    {
        return $this->_isFile;
    }

    /**
     * Return whether or not the method is POST
     *
     * @return boolean
     */
    public function isPost()
    {
        return ($this->_server['REQUEST_METHOD'] == 'POST');
    }

    /**
     * Return whether or not the method is GET
     *
     * @return boolean
     */
    public function isGet()
    {
        return ($this->_server['REQUEST_METHOD'] == 'GET');
    }

    /**
     * Return whether or not the method is PUT
     *
     * @return boolean
     */
    public function isPut()
    {
        return ($this->_server['REQUEST_METHOD'] == 'PUT');
    }

    /**
     * Return whether or not the method is DELETE
     *
     * @return boolean
     */
    public function isDelete()
    {
        return ($this->_server['REQUEST_METHOD'] == 'DELETE');
    }

    /**
     * Return whether or not the request is secure
     *
     * @return boolean
     */
    public function isSecure()
    {
        return $this->_isSecure;
    }

    /**
     * Get the full request URI
     *
     * @return string
     */
    public function getRequestUri()
    {
        return $this->_requestUri;
    }

    /**
     * Get a path segment, divided by the forward slash,
     * where $num refers to the array key index, i.e.,
     *    0     1     2
     * /hello/world/page
     *
     * No $num returns the whole path segment as an array,
     * and if the $num is not set, then it returns null.
     *
     * @param  int $num
     * @return string|array
     */
    public function getPath($num = null)
    {
        $path = null;

        if (null !== $num) {
            if (isset($this->_path[(int)$num])) {
                $path = $this->_path[(int)$num];
            }
        } else {
            $path = $this->_path;
        }

        return $path;
    }

    /**
     * Get the base path
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->_basePath;
    }

    /**
     * Get the doc root
     *
     * @return string
     */
    public function getDocRoot()
    {
        return $this->_docRoot;
    }

    /**
     * Get the full path
     *
     * @return string
     */
    public function getFullPath()
    {
        return $this->_fullPath;
    }

    /**
     * Get the method
     *
     * @return string
     */
    public function getMethod($key = null)
    {
        return $this->_server['REQUEST_METHOD'];
    }

    /**
     * Get the filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->_filename;
    }

    /**
     * Get secheme
     *
     * @return string
     */
    public function getScheme()
    {
        return ($this->_isSecure) ? 'https' : 'http';
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost()
    {
        $host = $this->_server['HTTP_HOST'];
        $name = $this->_server['SERVER_NAME'];
        $port = $this->_server['SERVER_PORT'];

        $hostname = null;
        if (!empty($host)) {
            $hostname = (($port == 80) || ($port == 443)) ? $host : $host . ':' . $port;
        } else if (!empty($name)) {
            $hostname = (($port == 80) || ($port == 443)) ? $name : $name . ':' . $port;
        }

        return $hostname;
    }

    /**
     * Get client's IP
     *
     * @param  boolean $proxy
     * @return string
     */
    public function getIp($proxy = true)
    {
        if ($proxy && isset($this->_server['HTTP_CLIENT_IP'])) {
            $ip = $this->_server['HTTP_CLIENT_IP'];
        } else if ($proxy && isset($this->_server['HTTP_X_FORWARDED_FOR'])) {
            $ip = $this->_server['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $this->_server['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * Get a value from $_GET, or the whole array
     *
     * @param  string $key
     * @return string|array
     */
    public function getQuery($key = null)
    {
        if (null === $key) {
            return $this->_get;
        } else {
            return (isset($this->_get[$key])) ? $this->_get[$key] : null;
        }
    }

    /**
     * Get a value from $_POST, or the whole array
     *
     * @param  string $key
     * @return string|array
     */
    public function getPost($key = null)
    {
        if (null === $key) {
            return $this->_post;
        } else {
            return (isset($this->_post[$key])) ? $this->_post[$key] : null;
        }
    }

    /**
     * Get a value from $_COOKIE, or the whole array
     *
     * @param  string $key
     * @return string|array
     */
    public function getCookie($key = null)
    {
        if (null === $key) {
            return $this->_cookie;
        } else {
            return (isset($this->_cookie[$key])) ? $this->_cookie[$key] : null;
        }
    }

    /**
     * Get a value from $_SERVER, or the whole array
     *
     * @param  string $key
     * @return string|array
     */
    public function getServer($key = null)
    {
        if (null === $key) {
            return $this->_server;
        } else {
            return (isset($this->_server[$key])) ? $this->_server[$key] : null;
        }
    }

    /**
     * Get a value from $_ENV, or the whole array
     *
     * @param  string $key
     * @return string|array
     */
    public function getEnv($key = null)
    {
        if (null === $key) {
            return $this->_server;
        } else {
            return (isset($this->_env[$key])) ? $this->_env[$key] : null;
        }
    }

    /**
     * Set the request URI
     *
     * @param  string $uri
     * @param  string $basePath
     * @return Pop\Http\Request
     */
    public function setRequestUri($uri = null, $basePath = null)
    {
        if (null === $uri) {
            $uri = $_SERVER['REQUEST_URI'];
        }

        if (null !== $basePath) {
            $uri = substr($uri, (strpos($uri, $basePath) + strlen($basePath)));
        }

        if ($uri == '') {
            $uri = '/';
        }

        // Some slash clean up
        $this->_docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
        $dir = str_replace('\\', '/', dirname($this->_docRoot . $_SERVER['PHP_SELF']));

        $this->_requestUri = ($dir != $this->_docRoot) ? str_replace(str_replace($this->_docRoot, '', $dir), '', $uri) : $uri;
        $this->_basePath = (null === $basePath) ? str_replace($this->_docRoot, '', $dir) : $basePath;
        $this->_fullPath = $this->_docRoot . $this->_basePath;
        $this->_isSecure = ($_SERVER['SERVER_PORT'] == '443') ? true : false;

        if (strpos($this->_requestUri, '?') !== false) {
            $this->_requestUri = substr($this->_requestUri, 0, strpos($this->_requestUri, '?'));
        }

        if (file_exists($this->_fullPath . $this->_requestUri)) {
            $this->_isFile = true;
            $this->_filename = str_replace('/', '', $this->_requestUri);
        } else {
            $this->_isFile = false;
            $this->_filename = null;
        }

        if (($this->_requestUri != '/') && (strpos($this->_requestUri, '/') !== false)) {
            $uri = (substr($this->_requestUri, 0, 1) == '/') ? substr($this->_requestUri, 1) : $this->_requestUri;
            $this->_path = explode('/', $uri);
        }

        return $this;
    }

    /**
     * Set the base path
     *
     * @param  string $path
     * @return Pop\Http\Request
     */
    public function setBasePath($path = null)
    {
        $this->_basePath = $path;
        return $this;
    }

    /**
     * Set a value for $_GET
     *
     * @param  string $key
     * @param  string $value
     * @return Pop\Http\Request
     */
    public function setQuery($key, $value)
    {
        $this->_get[$key] = $value;
        $_GET[$key] = $value;
        return $this;
    }

    /**
     * Set a value for $_POST
     *
     * @param  string $key
     * @param  string $value
     * @return Pop\Http\Request
     */
    public function setPost($key, $value)
    {
        $this->_post[$key] = $value;
        $_POST[$key] = $value;
        return $this;
    }

}
