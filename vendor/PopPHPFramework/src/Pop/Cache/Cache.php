<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Cache
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Cache;

/**
 * Cache class
 *
 * @category   Pop
 * @package    Pop_Cache
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Cache
{

    /**
     * Lifetime value
     * @var int
     */
    protected $lifetime = 0;

    /**
     * Cache adapter
     * @var mixed
     */
    protected $adapter = null;

    /**
     * Constructor
     *
     * Instantiate the cache object
     *
     * @param  Adapter\AdapterInterface $adapter
     * @param  int                      $lifetime
     * @return \Pop\Cache\Cache
     */
    public function __construct(Adapter\AdapterInterface $adapter, $lifetime = 0)
    {
        $this->lifetime = $lifetime;
        $this->adapter = $adapter;
    }

    /**
     * Static method to instantiate the cache object and return itself
     * to facilitate chaining methods together.
     *
     * @param  Adapter\AdapterInterface $adapter
     * @param  int                      $lifetime
     * @return \Pop\Cache\Cache
     */
    public static function factory(Adapter\AdapterInterface $adapter, $lifetime = 0)
    {
        return new self($adapter, $lifetime);
    }

    /**
     * Method to get the adapter
     *
     * @return mixed
     */
    public function adapter()
    {
        return $this->adapter;
    }

    /**
     * Method to set the cache lifetime.
     *
     * @param  int $time
     * @return \Pop\Cache\Cache
     */
    public function setLifetime($time = 0)
    {
        $this->lifetime = (int)$time;
        return $this;
    }

    /**
     * Method to get the cache lifetime.
     *
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * Method to save a value to cache.
     *
     * @param  string $id
     * @param  mixed  $value
     * @param  string $time
     * @return void
     */
    public function save($id, $value, $time = null)
    {
        if ($this->adapter instanceof Adapter\Memcached) {
            $this->adapter->save($id, $value, $this->lifetime);
        } else {
            $this->adapter->save($id, $value, $time);
        }
    }

    /**
     * Method to load a value from cache.
     *
     * @param  string $id
     * @param  int    $time
     * @return mixed
     */
    public function load($id, $time = null)
    {
        $time = (null !== $time) ? $this->lifetime : $time;
        return $this->adapter->load($id, $time);
    }

    /**
     * Method to delete a value in cache.
     *
     * @param  string $id
     * @return void
     */
    public function remove($id)
    {
        $this->adapter->remove($id);
    }

    /**
     * Method to clear all stored values from cache.
     *
     * @return void
     */
    public function clear()
    {
        $this->adapter->clear();
    }

}
