<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Mvc;

/**
 * Mvc model class
 *
 * @category   Pop
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.3
 */
class Model
{

    /**
     * Model data as model objects
     * @var array
     */
    protected $data = array();

    /**
     * Data values as an array
     * @var array
     */
    protected $array = array();

    /**
     * Constructor
     *
     * Instantiate the model object.
     *
     * @param  mixed $data
     * @param  string $name
     * @return \Pop\Mvc\Model
     */
    public function __construct($data = null, $name = null)
    {
        if (null !== $data) {
            $this->setModelData($data, $name);
        }
    }

    /**
     * Create a Pop\Mvc\Model object
     *
     * @param  mixed $data
     * @param  string $name
     * @return \Pop\Mvc\Model
     */
    public static function factory($data = null, $name = null)
    {
        return new self($data, $name);
    }

    /**
     * Method to get the model data as an array
     *
     * @return array
     */
    public function asArray()
    {
        $this->array = array();
        $this->getModelData();
        return $this->array;
    }

    /**
     * Method to get the model data as an array
     *
     * @return array
     */
    public function asArrayObject()
    {
        $this->array = new \ArrayObject(array(), \ArrayObject::ARRAY_AS_PROPS);
        $this->getDataObject();
        return $this->array;
    }

    /**
     * Get method to return the data array
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get method to return the value of _data[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function get($name)
    {
        return (isset($this->data[$name])) ? $this->data[$name] : null;
    }

    /**
     * Get method to return the value of _data[$key].
     *
     * @param  int $key
     * @return mixed
     */
    public function key($key)
    {
        return (isset($this->data[(int)$key])) ? $this->data[(int)$key] : null;
    }

    /**
     * Get method to return the value of _data[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @return mixed
     */
    public function set($name, $value)
    {
        $this->data[$name] = (is_array($value) ? new Model($value) : $value);
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
     * @return mixed
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
        return isset($this->data[$name]);
    }

    /**
     * Unset _data[$name].
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        unset($this->data[$name]);
    }

    /**
     * Set the model data
     *
     * @param  mixed  $data
     * @param  string $name
     * @throws Exception
     * @return void
     */
    protected function setModelData($data, $name = null)
    {
        if (!is_array($data)) {
            if (null === $name) {
                throw new Exception('If you pass a scalar value, then you must pass a name for it.');
            }
            $this->data[$name] = $data;
        } else {
            foreach ($data as $key => $value) {
                $this->data[$key] = (is_array($value) ? new Model($value) : $value);
            }
        }
    }

    /**
     * Method to get the data values as array
     *
     * @return void
     */
    protected function getModelData()
    {
        foreach ($this->data as $key => $value) {
            $this->array[$key] = ($value instanceof Model) ? $value->asArray() : $value;
        }
    }

    /**
     * Method to get the data values as ArrayObject
     *
     * @return void
     */
    protected function getDataObject()
    {
        foreach ($this->data as $key => $value) {
            $this->array[$key] = ($value instanceof Model) ? $value->asArrayObject() : $value;
        }
    }

}
