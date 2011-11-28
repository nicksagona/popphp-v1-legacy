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
 * @package    Pop_Cache
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Cache;

use Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Cache
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Cache implements CacheInterface
{

    /**
     * Lifetime value
     * @var int
     */
    protected $_lifetime = 0;

    /**
     * Cache adapter
     * @var mixed
     */
    protected $_adapter = null;

    /**
     * Constructor
     *
     * Instantiate the cache object
     *
     * @param  string $type
     * @param  string $store
     * @param  int    $lifetime
     * @throws Exception
     * @return void
     */
    public function __construct($type, $store = null, $lifetime = 0)
    {
        if (($type != 'File') && ($type != 'Sqlite') && ($type != 'Memcached')) {
            throw new Exception(Locale::factory()->__('Error: The cache type must be \'File\', \'Sqlite\' or \'Memcached\'.'));
        } else if (($type != 'Memcached') && (null !== $store)) {
            throw new Exception(Locale::factory()->__('Error: You must pass either a directory or SQLite file store point.'));
        } else {
            $this->_lifetime = $lifetime;
            $class = 'Pop_Cache_' . $type;
            $this->_adapter = ($class == 'Pop_Cache_Memcached') ? new $class() : new $class($store);
        }
    }

    /**
     * Static method to instantiate the cache object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $type
     * @param  string $store
     * @param  int    $lifetime
     * @return Pop_Cache
     */
    public static function factory($type, $store = null, $lifetime = 0)
    {
        return new self($type, $store, $lifetime);
    }

    /**
     * Method to set the cache lifetime.
     *
     * @param  int $time
     * @return Pop_Cache
     */
    public function setLifetime($time = 0)
    {
        $this->_lifetime = (int)$time;
        return $this;
    }

    /**
     * Method to get the cache lifetime.
     *
     * @return int
     */
    public function getLifetime()
    {
        return $this->_lifetime;
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
        if ($this->_adapter instanceof Memcached) {
            $this->_adapter->save($id, $value, $this->_lifetime);
        } else {
            $this->_adapter->save($id, $value, $time);
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
        $time = (null !== $time) ? $this->_lifetime : $time;
        return $this->_adapter->load($id, $time);
    }

    /**
     * Method to delete a value in cache.
     *
     * @param  string $id
     * @return void
     */
    public function remove($id)
    {
        $this->_adapter->remove($id);
    }

    /**
     * Method to clear all stored values from cache.
     *
     * @return void
     */
    public function clear()
    {
        $this->_adapter->clear();
    }

}
