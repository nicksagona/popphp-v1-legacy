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
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Mvc;

/**
 * @category   Pop
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Model
{

    /**
     * Model data as model objects
     * @var array
     */
    protected $_data = array();

    /**
     * Data values as an array
     * @var array
     */
    protected $_array = array();

    /**
     * Constructor
     *
     * Instantiate the model object.
     *
     * @param  mixed $data
     * @param  string $name
     * @return void
     */
    public function __construct($data = null, $name = null)
    {
        if (null !== $data) {
            $this->_setData($data, $name);
        }
    }

    /**
     * Method to get the model data as an array
     *
     * @return array
     */
    public function asArray()
    {
        $this->_array = array();
        $this->_getData();
        return $this->_array;
    }

    /**
     * Method to get the model data as an array
     *
     * @return array
     */
    public function asArrayObject()
    {
        $this->_array = new \ArrayObject(array(), \ArrayObject::ARRAY_AS_PROPS);
        $this->_getDataObject();
        return $this->_array;
    }

    /**
     * Get method to return the data array
     *
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Get method to return the value of _data[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function get($name)
    {
        return (isset($this->_data[$name])) ? $this->_data[$name] : null;
    }

    /**
     * Get method to return the value of _data[$key].
     *
     * @param  int $key
     * @return mixed
     */
    public function key($key)
    {
        return (isset($this->_data[(int)$key])) ? $this->_data[(int)$key] : null;
    }

    /**
     * Get method to return the value of _data[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function set($name, $value)
    {
        $this->_data[$name] = (is_array($value) ? new Model($value) : $value);
    }

    /**
     * Get method to return the value of _data[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Set method to set the property to the value of _data[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * Return the isset value of _data[$name].
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->_data[$name]);
    }

    /**
     * Unset _data[$name].
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        unset($this->_data[$name]);
    }

    /**
     * Set the model data
     *
     * @param  mixed $data
     * @throws Exception
     * @return void
     */
    protected function _setData($data, $name = null)
    {
        if (!is_array($data)) {
            if (null === $name) {
                throw new Exception('If you pass a scalar value, then you must pass a name for it.');
            }
            $this->_data[$name] = $data;
        } else {
            foreach ($data as $key => $value) {
                $this->_data[$key] = (is_array($value) ? new Model($value) : $value);
            }
        }
    }

    /**
     * Method to get the data values as array
     *
     * @return void
     */
    protected function _getData()
    {
        foreach ($this->_data as $key => $value) {
            $this->_array[$key] = ($value instanceof Model) ? $value->asArray() : $value;
        }
    }

    /**
     * Method to get the data values as ArrayObject
     *
     * @return void
     */
    protected function _getDataObject()
    {
        foreach ($this->_data as $key => $value) {
            $this->_array[$key] = ($value instanceof Model) ? $value->asArrayObject() : $value;
        }
    }

}
