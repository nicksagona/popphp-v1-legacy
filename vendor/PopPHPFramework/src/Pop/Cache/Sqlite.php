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

use Pop\Db\Db,
    Pop\Db\Sql,
    Pop\Dir\Dir,
    Pop\File\File,
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Cache
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Sqlite implements CacheInterface
{

    /**
     * Cache db file
     * @var string
     */
    protected $_db = null;

    /**
     * Cache db table
     * @var string
     */
    protected $_table = null;

    /**
     * Cache db adapter
     * @var Pop_Db
     */
    protected $_sqlite = null;

    /**
     * Constructor
     *
     * Instantiate the cache db object
     *
     * @param  string $db
     * @param  string $table
     * @throws Exception
     * @return void
     */
    public function __construct($db, $table = 'pop_cache')
    {
        $this->_db = $db;
        $this->_table = $table;
        $dir = dirname($this->_db);

        // If the database file doesn't exist, create it.
        if (!file_exists($this->_db)) {
            if (is_writable($dir)) {
                touch($db);
            } else {
                throw new Exception(Locale::factory()->__('Error: That cache db file and/or directory is not writable.'));
            }
        }

        // Make it writable.
        chmod($this->_db, 0777);

        // Check the permissions, access the database and check for the cache table.
        if (!is_writable($dir) || !is_writable($this->_db)) {
            throw new Exception(Locale::factory()->__('Error: That cache db file and/or directory is not writable.'));
        } else {
            $this->_sqlite = Db::factory('Sqlite', array('database' => $this->_db));

            // If the cache table doesn't exist, create it.
            if (!in_array($this->_table, $this->_sqlite->adapter->getTables())) {
                $this->_sqlite->adapter->query('CREATE TABLE IF NOT EXISTS "' . $this->_table . '" ("id" VARCHAR PRIMARY KEY NOT NULL UNIQUE, "value" BLOB, "time" INTEGER)');
            }

            $this->_sqlite->sql->setTable($this->_table);
            $this->_sqlite->sql->setIdQuoteType(Sql::DOUBLE_QUOTE);
        }
    }

    /**
     * Method to get the current cache db file.
     *
     * @return string
     */
    public function getDb()
    {
        return $this->_db;
    }

    /**
     * Method to get the current cache db table.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->_table;
    }

    /**
     * Method to Set the cache db table.
     *
     * @return Pop\Cache\Sqlite
     */
    public function setTable($table = 'pop_cache')
    {
        return $this->_table = $table;
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

        // Determine if the value already exists.
        $this->_sqlite->sql->setTable($this->_table)
                           ->select()
                           ->where('id', '=', $this->_sqlite->adapter->escape(sha1($id)));

        $this->_sqlite->adapter->query($this->_sqlite->sql->getSql());

        $rows = array();
        while (($row = $this->_sqlite->adapter->fetch()) != false) {
            $rows[] = $row;
        }

        // If the value exists, update it.
        if (count($rows) > 0) {
            $this->_sqlite->sql->setTable($this->_table)
                               ->update(
                                        array(
                                            'value' => $this->_sqlite->adapter->escape(serialize($value)),
                                            'time'  => $time
                                        )
                                        )
                               ->where('id', '=', $this->_sqlite->adapter->escape(sha1($id)));
        // Else, save the new value.
        } else {
            $this->_sqlite->sql->setTable($this->_table)
                               ->insert(
                                        array(
                                            'id'    => $this->_sqlite->adapter->escape(sha1($id)),
                                            'value' => $this->_sqlite->adapter->escape(serialize($value)),
                                            'time'  => $time
                                        )
                                        );
        }

        $this->_sqlite->adapter->query($this->_sqlite->sql->getSql());
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
        $value = false;

        // Retrieve the value.
        $this->_sqlite->sql->setTable($this->_table)
                           ->select()
                           ->where('id', '=', $this->_sqlite->adapter->escape(sha1($id)));

        $this->_sqlite->adapter->query($this->_sqlite->sql->getSql());

        $rows = array();
        while (($row = $this->_sqlite->adapter->fetch()) != false) {
            $rows[] = $row;
        }

        // If the value is found, check expiration and return.
        if (count($rows) > 0) {
            $data = $rows[0]['value'];
            $dbTime = $rows[0]['time'];
            if (($time == 0) || ((time() - $dbTime) <= $time)) {
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
        $this->_sqlite->sql->setTable($this->_table)
                           ->delete()
                           ->where('id', '=', $this->_sqlite->adapter->escape(sha1($id)));

        $this->_sqlite->adapter->query($this->_sqlite->sql->getSql());
    }

    /**
     * Method to clear all stored values from cache.
     *
     * @return void
     */
    public function clear()
    {
        $this->_sqlite->adapter->query('DELETE FROM "' . $this->_table . '"');
    }

}
