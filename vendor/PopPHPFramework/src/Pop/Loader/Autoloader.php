<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Loader
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Loader;

/**
 * Autoloader class
 *
 * @category   Pop
 * @package    Pop_Loader
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Autoloader
{

    /**
     * Array of available namespaces prefixes.
     * @var array
     */
    protected $prefixes = array();

    /**
     * Class map array.
     * @var array
     */
    protected $classmap = array();

    /**
     * Flag to make the autoloader the fallback autoloader or not
     * @var boolean
     */
    protected $fallback = false;

    /**
     * Flag to suppress warnings
     * @var boolean
     */
    protected $suppress = true;

    /**
     * Constructor
     *
     * Instantiate the archive object
     *
     * @param  boolean $self
     * @return \Pop\Loader\Autoloader
     */
    public function __construct($self = true)
    {
        if ($self) {
            $this->register('Pop', __DIR__ . '/../../');
        }
    }

    /**
     * Static method to instantiate the autoloader object
     *
     * @param  boolean $self
     * @return \Pop\Loader\Autoloader
     */
    public static function factory($self = true)
    {
        return new self($self);
    }

    /**
     * Load a class map file
     *
     * @param  string $classmap
     * @throws Exception
     * @return \Pop\Loader\Autoloader
     */
    public function loadClassMap($classmap)
    {
        if (!file_exists($classmap)) {
            throw new Exception('That class map file does not exist.');
        }

        $newClassMap = include $classmap;

        if (count($this->classmap) > 0) {
            $ary = array_merge($this->classmap, $newClassMap);
        } else {
            $this->classmap = $newClassMap;
        }

        return $this;
    }

    /**
     * Register a namespace and directory location with the autoloader
     *
     * @param  string $namespace
     * @param  string $directory
     * @return \Pop\Loader\Autoloader
     */
    public function register($namespace, $directory)
    {
        $this->prefixes[$namespace] = realpath($directory);
        return $this;
    }

    /**
     * Register the autoloader instance with the SPL
     *
     * @param  boolean $suppress
     * @param  boolean $fallback
     * @return \Pop\Loader\Autoloader
     */
    public function splAutoloadRegister($suppress = true, $fallback = false)
    {
        $this->suppress = $suppress;
        $this->fallback = $fallback;

        if ($this->fallback) {
            spl_autoload_register($this, true, false);
        } else {
            spl_autoload_register($this, true, true);
        }

        return $this;
    }

    /**
     * Invoke the class
     *
     * Credit to Andreas Schipplock for helping to improve
     * this method: https://github.com/schipplock
     *
     * @param  string $class
     * @return void
     */
    public function __invoke($class)
    {
        if (array_key_exists($class, $this->classmap)) {
            require_once $this->classmap[$class];
        } else {
            $sep = (strpos($class, '\\') !== false) ? '\\' : '_';
            $classFile = str_replace($sep, DIRECTORY_SEPARATOR, $class) . '.php';

            // Check to see if the prefix is registered with the autoloader
            $prefix = null;
            foreach ($this->prefixes as $key => $value) {
                if (substr($class, 0, strlen($key)) == $key) {
                    $prefix = $key;
                }
            }

            // If the prefix was found, append the correct directory
            if (null !== $prefix) {
                $classFile = $this->prefixes[$prefix] . DIRECTORY_SEPARATOR . $classFile;
            }

            // Try to include the file, else return
            // Without error suppression
            if (!$this->suppress) {
                if (!include_once($classFile)) {
                    return;
                }
            // With error suppression
            } else {
                if (!@include_once($classFile)) {
                    return;
                }
            }
        }
    }

}
