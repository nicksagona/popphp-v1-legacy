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
 * @package    Pop_Autoloader
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Autoloader
 *
 * @category   Pop
 * @package    Pop_Autoloader
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Autoloader
{

    /**
     * Array of available namespaces.
     * @var array
     */
    protected $_namespaces = array();

    /**
     * Constructor
     *
     * Instantiate the archive object
     *
     * @param  boolean $self
     * @return void
     */
    public function __construct($self = true)
    {
        if ($self) {
            $this->register('Pop', realpath(__DIR__ . '/../'));
        }
    }

    /**
     * Register a namespace and directory location with the autoloader
     *
     * @param  string $namespace
     * @param  string $directory
     * @return Pop_Autoloader
     */
    public function register($namespace, $directory)
    {
        $this->_namespaces[$namespace] = $directory;
        return $this;
    }

    /**
     * Register the autoloader instance with the SPL
     *
     * @return Pop_Autoloader
     */
    public function splAutoloadRegister()
    {
        spl_autoload_register($this);
        return $this;
    }

    /**
     * Invoke the class
     *
     * @param  string $class
     * @return void
     */
    public function __invoke($class)
    {
        $namespace = substr($class, 0, strpos($class, '_'));
        $filePath = $this->_namespaces[$namespace] . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
        require_once $filePath;
    }

}
