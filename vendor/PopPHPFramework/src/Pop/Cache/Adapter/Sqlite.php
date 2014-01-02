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
 * SQLite cache adapter class
 *
 * @category   Pop
 * @package    Pop_Cache
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Sqlite implements AdapterInterface
{

    /**
     * Cache db file
     * @var string
     */
    protected $db = null;

    /**
     * Cache db table
     * @var string
     */
    protected $table = null;

    /**
     * Cache SQL object
     * @var \Pop\Db\Sql
     */
    protected $sqlite = null;

    /**
     * Constructor
     *
     * Instantiate the cache db object
     *
     * @param  string $db
     * @param  string $table
     * @throws Exception
     * @return \Pop\Cache\Adapter\Sqlite
     */
    public function __construct($db, $table = 'pop_cache')
    {
        $this->db = $db;
        $this->table = $table;
        $dir = dirname($this->db);

        // If the database file doesn't exist, create it.
        if (!file_exists($this->db)) {
            if (is_writable($dir)) {
                touch($db);
            } else {
                throw new Exception('Error: That cache db file and/or directory is not writable.');
            }
        }

        // Make it writable.
        chmod($this->db, 0777);

        // Check the permissions, access the database and check for the cache table.
        if (!is_writable($dir) || !is_writable($this->db)) {
            throw new Exception('Error: That cache db file and/or directory is not writable.');
        }

        $this->sqlite = new \Pop\Db\Sql(\Pop\Db\Db::factory('Sqlite', array('database' => $this->db)), $table);

        // If the cache table doesn't exist, create it.
        if (!in_array($this->table, $this->sqlite->adapter()->getTables())) {
            $this->sqlite->adapter()->query(
                'CREATE TABLE IF NOT EXISTS "' .
                    $this->table . '" ("id" VARCHAR PRIMARY KEY NOT NULL UNIQUE, "value" BLOB, "time" INTEGER)');
        }
    }

    /**
     * Method to get the current cache db file.
     *
     * @return string
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Method to get the current cache db table.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Method to Set the cache db table.
     *
     * @param  string $table
     * @return \Pop\Cache\Adapter\Sqlite
     */
    public function setTable($table = 'pop_cache')
    {
        return $this->table = $table;
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
        $this->sqlite->select()->where()->equalTo('id', $this->sqlite->adapter()->escape(sha1($id)));
        $this->sqlite->adapter()->query($this->sqlite->render(true));

        $rows = array();
        while (($row = $this->sqlite->adapter()->fetch()) != false) {
            $rows[] = $row;
        }

        // If the value exists, update it.
        if (count($rows) > 0) {
            $this->sqlite->update(array(
                'value' => $this->sqlite->adapter()->escape(serialize($value)),
                'time'  => $time
            ))->where()->equalTo('id', $this->sqlite->adapter()->escape(sha1($id)));
        // Else, save the new value.
        } else {
            $this->sqlite->insert(array(
                'id'    => $this->sqlite->adapter()->escape(sha1($id)),
                'value' => $this->sqlite->adapter()->escape(serialize($value)),
                'time'  => $time
            ));
        }

        $this->sqlite->adapter()->query($this->sqlite->render(true));
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
        $this->sqlite->select()->where()->equalTo('id', $this->sqlite->adapter()->escape(sha1($id)));
        $this->sqlite->adapter()->query($this->sqlite->render(true));

        $rows = array();
        while (($row = $this->sqlite->adapter()->fetch()) != false) {
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
        $this->sqlite->delete()->where()->equalTo('id', $this->sqlite->adapter()->escape(sha1($id)));
        $this->sqlite->adapter()->query($this->sqlite->render(true));
    }

    /**
     * Method to clear all stored values from cache.
     *
     * @return void
     */
    public function clear()
    {
        $this->sqlite->adapter()->query('DELETE FROM "' . $this->table . '"');
    }

    /**
     * Method to delete the entire database file
     *
     * @return void
     */
    public function delete()
    {
        if (file_exists($this->db)) {
            unset($this->sqlite);
            unlink($this->db);
        }
    }

}
