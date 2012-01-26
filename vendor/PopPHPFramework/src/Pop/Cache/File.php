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

use Pop\Dir\Dir,
    Pop\File\File as PopFile;

/**
 * @category   Pop
 * @package    Pop_Cache
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class File implements CacheInterface
{

    /**
     * Cache dir
     * @var string
     */
    protected $_dir = null;

    /**
     * Constructor
     *
     * Instantiate the cache file object
     *
     * @param  string $dir
     * @throws Exception
     * @return void
     */
    public function __construct($dir)
    {
        if (!file_exists($dir)) {
            throw new Exception('Error: That cache directory does not exist.');
        } else if (!is_writable($dir)) {
            throw new Exception('Error: That cache directory is not writable.');
        }

        $this->_dir = realpath($dir);
    }

    /**
     * Method to get the current cache dir.
     *
     * @return string
     */
    public function getDir()
    {
        return $this->_dir;
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
        $time = (null === $time) ? time() : time() + $time;

        $file = new PopFile($this->_dir . DIRECTORY_SEPARATOR . sha1($id));
        $file->write($time . '|' . serialize($value));
        $file->save();
    }

    /**
     * Method to load a value from cache.
     *
     * @param  string $id
     * @param  string $time
     * @return mixed
     */
    public function load($id, $time = null)
    {
        $fileId = $this->_dir . DIRECTORY_SEPARATOR . sha1($id);
        $value = false;

        if (file_exists($fileId)) {
            $file = new PopFile($fileId);
            $fileData = $file->read();
            $fileTime = substr($fileData, 0, strpos($fileData, '|'));
            $data = substr($fileData, (strpos($fileData, '|') + 1));
            if (($time == 0) || ((time() - $fileTime) <= $time)) {
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
        $fileId = $this->_dir . DIRECTORY_SEPARATOR . sha1($id);
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
        $dir = new Dir($this->_dir);
        $dir->emptyDir();
    }

}
