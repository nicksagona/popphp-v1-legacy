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
 * @package    Pop_Config
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop;

/**
 * This is the Config class for the Pop PHP Framework.
 *
 * @category   Pop
 * @package    Pop_Config
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.1
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
    public function __construct(array $config, $changes = false)
    {
        $this->allowChanges = $changes;
        $this->setConfig($config);
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
     * Get method to return the value of _config[$name].
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
     * Magic get method to return the value of _config[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Set method to set the property to the value of _config[$name].
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
     * Return the isset value of _config[$name].
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * Unset _config[$name].
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
