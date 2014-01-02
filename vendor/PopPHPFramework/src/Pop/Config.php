<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Config
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop;

/**
 * Config class
 *
 * @category   Pop
 * @package    Pop_Config
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Config
{
    /**
     * Flag for whether or not changes are allowed after object instantiation
     * @var boolean
     */
    protected $allowChanges = false;

    /**
     * Config values as config objects
     * @var array
     */
    protected $config = array();

    /**
     * Config values as an array
     * @var array
     */
    protected $array = array();

    /**
     * Constructor
     *
     * Instantiate a config object
     *
     * @param  array   $config
     * @param  boolean $changes
     * @return \Pop\Config
     */
    public function __construct(array $config = array(), $changes = false)
    {
        $this->allowChanges = $changes;
        $this->setConfig($config);
    }

    /**
     * Static method to instantiate the config object and return itself
     * to facilitate chaining methods together.
     *
     * @param  array   $config
     * @param  boolean $changes
     * @return \Pop\Config
     */
    public static function factory(array $config = array(), $changes = false)
    {
        return new self($config, $changes);
    }

    /**
     * Method to merge the values of another config object into this one
     *
     * @param  mixed $config
     * @throws \Exception
     * @return \Pop\Config
     */
    public function merge($config)
    {
        $orig = $this->asArray();
        $merge = ($config instanceof \Pop\Config) ? $config->asArray() : $config;

        if (!is_array($merge)) {
            throw new \Exception('The config passed must be an array or an instance of Pop\Config.');
        }

        foreach ($orig as $key => $value) {
            $merge[$key] = (isset($merge[$key])) ? $merge[$key] : $value;
        }

        $this->setConfig($merge);
        $this->array = array();

        return $this;
    }

    /**
     * Method to get the config values as an array
     *
     * @return array
     */
    public function asArray()
    {
        $this->array = array();
        $this->getConfig();
        return $this->array;
    }

    /**
     * Method to get the config values as an ArrayObject
     *
     * @return array
     */
    public function asArrayObject()
    {
        $this->array = new \ArrayObject(array(), \ArrayObject::ARRAY_AS_PROPS);
        $this->getConfigObject();
        return $this->array;
    }

    /**
     * Method to return if changes to the config are allowed.
     *
     * @return boolean
     */
    public function changesAllowed()
    {
        return $this->allowChanges;
    }

    /**
     * Get method to return the value of config[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function get($name)
    {
        $value = null;
        if (array_key_exists($name, $this->config)) {
            $value =  $this->config[$name];
        }
        return $value;
    }

    /**
     * Magic get method to return the value of config[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Set method to set the property to the value of config[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @throws \Exception
     * @return void
     */
    public function __set($name, $value)
    {
        if ($this->allowChanges) {
            $this->config[$name] = (is_array($value) ? new Config($value, $this->allowChanges) : $value);
        } else {
            throw new \Exception('Real-time configuration changes are not allowed.');
        }
    }

    /**
     * Return the isset value of config[$name].
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * Unset config[$name].
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        unset($this->config[$name]);
    }

    /**
     * Method to set the config values
     *
     * @param  array $config
     * @return void
     */
    protected function setConfig($config)
    {
        foreach ($config as $key => $value) {
            $this->config[$key] = (is_array($value) ? new Config($value, $this->allowChanges) : $value);
        }
    }

    /**
     * Method to get the config values as array
     *
     * @return void
     */
    protected function getConfig()
    {
        foreach ($this->config as $key => $value) {
            $this->array[$key] = ($value instanceof Config) ? $value->asArray() : $value;
        }
    }

    /**
     * Method to get the config values as ArrayObject
     *
     * @return void
     */
    protected function getConfigObject()
    {
        foreach ($this->config as $key => $value) {
            $this->array[$key] = ($value instanceof Config) ? $value->asArrayObject() : $value;
        }
    }

}
