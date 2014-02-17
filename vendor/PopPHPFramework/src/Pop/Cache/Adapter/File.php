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
namespace Pop\Cache\Adapter;

/**
 * File adapter cache class
 *
 * @category   Pop
 * @package    Pop_Cache
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class File implements AdapterInterface
{

    /**
     * Cache dir
     * @var string
     */
    protected $dir = null;

    /**
     * Constructor
     *
     * Instantiate the cache file object
     *
     * @param  string $dir
     * @throws Exception
     * @return \Pop\Cache\Adapter\File
     */
    public function __construct($dir)
    {
        if (!file_exists($dir)) {
            throw new Exception('Error: That cache directory does not exist.');
        } else if (!is_writable($dir)) {
            throw new Exception('Error: That cache directory is not writable.');
        }

        $this->dir = realpath($dir);
    }

    /**
     * Method to get the current cache dir.
     *
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * Method to save a value to cache.
     *
     * @param  string $id
     * @param  mixed  $value
     * @param  string $time
     * @return void
     */
    public function save($id, $value, $time)
    {
        $file = $this->dir . DIRECTORY_SEPARATOR . sha1($id);
        file_put_contents($file, time() + (int)$time . '|' . serialize($value));
    }

    /**
     * Method to load a value from cache.
     *
     * @param  string $id
     * @param  string $time
     * @return mixed
     */
    public function load($id, $time)
    {
        $fileId = $this->dir . DIRECTORY_SEPARATOR . sha1($id);
        $value = false;

        if (file_exists($fileId)) {
            $fileData = file_get_contents($fileId);
            $fileTime = substr($fileData, 0, strpos($fileData, '|'));
            $data = substr($fileData, (strpos($fileData, '|') + 1));
            if ((time() - $fileTime) <= $time) {
                $value = unserialize($data);
            }
        }

        return $value;
    }

    /**
     * Method to delete a value in cache.
     *
     * @param  string $id
     * @return void
     */
    public function remove($id)
    {
        $fileId = $this->dir . DIRECTORY_SEPARATOR . sha1($id);
        if (file_exists($fileId)) {
            unlink($fileId);
        }
    }

    /**
     * Method to clear all stored values from cache.
     *
     * @return void
     */
    public function clear()
    {
        $dir = new \Pop\File\Dir($this->dir);
        $dir->emptyDir();
    }

}
