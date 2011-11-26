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
 * @package    Pop_Model
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Model
 *
 * @category   Pop
 * @package    Pop_Model
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Model
{

    /**
     * Model data
     * @var ArrayObject
     */
    protected $_data = null;

    /**
     * Constructor
     *
     * Instantiate the model object.
     *
     * @param array $data
     * @return void
     */
    public function __construct(array $data = null)
    {
        $this->setData($data);
    }

    /**
     * Get the model data
     *
     * @return ArrayObject
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Load a value into the model data array
     *
     * @param string $name
     * @param mixed  $value
     * @return Pop_Model
     */
    public function loadData($name, $value)
    {
        $convertedValue = $value;

        if (is_array($value)) {
            if (isset($value[0]) && is_array($value[0])){
                foreach ($value as $k => $v) {
                    $value[$k] = new ArrayObject($value[$k], ArrayObject::ARRAY_AS_PROPS);
                }
            }
            $convertedValue = new ArrayObject($value, ArrayObject::ARRAY_AS_PROPS);
        }

        if (null === $this->_data) {
            $this->_data = new ArrayObject(array(), ArrayObject::ARRAY_AS_PROPS);
        }

        $this->_data->$name = $convertedValue;

        return $this;
    }

    /**
     * Set the model data
     *
     * @param  array $data
     * @return Pop_Model
     */
    public function setData(array $data = null)
    {
        if (null !== $data) {
            $this->_data = $data;
            $this->_convertData();
        }
        return $this;
    }

    /**
     * Convert all the model data to ArrayObjects
     *
     * @return void
     */
    protected function _convertData()
    {
        foreach ($this->_data as $key => $value) {
            if (is_array($value)) {
                if (isset($value[0]) && is_array($value[0])){
                    foreach ($value as $k => $v) {
                        $value[$k] = new ArrayObject($value[$k], ArrayObject::ARRAY_AS_PROPS);
                    }
                }
                $this->_data[$key] = new ArrayObject($value, ArrayObject::ARRAY_AS_PROPS);
            }
        }

        $this->_data = new ArrayObject($this->_data, ArrayObject::ARRAY_AS_PROPS);
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
        $this->_data->$name = $value;
    }

    /**
     * Get method to return the value of _data[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (isset($this->_data->$name)) ? $this->_data->$name : null;
    }

    /**
     * Return the isset value of _data[$name].
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->_data->$name);
    }

    /**
     * Unset _data[$name].
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        $this->_data->$name = null;
        unset($this->_data->$name);
    }

}
