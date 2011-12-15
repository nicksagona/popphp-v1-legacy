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
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop;

use Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Config
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Config
{
    /**
     * Flag for whether or not changes are allowed after object instantiation
     * @var boolean
     */
    protected $_allowChanges = false;

    /**
     * Config values as Pop\Config objects
     * @var array
     */
    protected $_config = array();

    /**
     * Config values as an array
     * @var array
     */
    protected $_array = array();

    /**
     * Constructor
     *
     * Instantiate a config object
     *
     * @param  array   $config
     * @param  boolean $changes
     * @return void
     */
    public function __construct(array $config, $changes = false)
    {
        $this->_allowChanges = $changes;
        $this->_setConfig($config);
    }

    /**
     * Method to set the config values
     *
     * @return array
     */
    public function getConfigAsArray()
    {
        $this->_array = array();
        $this->_getConfig();
        return $this->_array;
    }

    /**
     * Set method to set the property to the value of _config[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @throws Exception
     * @return void
     */
    public function __set($name, $value)
    {
        if ($this->_allowChanges) {
            $this->_config[$name] = $value;
        } else {
            throw new \Exception(Locale::factory()->__('Real-time configuration changes are not allowed.'));
        }
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
        if (array_key_exists($name, $this->_config)) {
            $value =  $this->_config[$name];
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
     * Method to set the config values
     *
     * @param  array $config
     * @return void
     */
    protected function _setConfig($config)
    {
        foreach ($config as $key => $value) {
            $this->_config[$key] = (is_array($value) ? new Config($value, $this->_allowChanges) : $value);
        }
    }

    /**
     * Method to get the config values
     *
     * @return void
     */
    protected function _getConfig()
    {
        foreach ($this->_config as $key => $value) {
            $this->_array[$key] = ($value instanceof Config) ? $value->getConfigAsArray() : $value;
        }
    }

}
