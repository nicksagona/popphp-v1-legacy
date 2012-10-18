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
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Db\Adapter;

/**
 * This is the abstract adapter class for the Db component.
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.1
 */
abstract class AbstractAdapter
{

    /**
     * Database results
     * @var resource
     */
    public $result;

    /**
     * Default database connection
     * @var resource
     */
    public $connection;

    /**
     * Database tables
     * @var array
     */
    protected $tables = array();

    /**
     * Language object
     * @var Pop\Locale\Locale
     */
    protected $lang = null;

    /**
     * Constructor
     *
     * Instantiate the database adapter object.
     *
     * @param  array $options
     * @throws Exception
     * @return void
     */
    abstract public function __construct(array $options);

    /**
     * Throw an exception upon a database error.
     *
     * @throws Exception
     * @return void
     */
    abstract public function showError();

    /**
     * Execute the SQL query and create a result resource, or display the SQL error.
     *
     * @param  string $sql
     * @return void
     */
    abstract public function query($sql);

    /**
     * Return the results array from the results resource.
     *
     * @throws Exception
     * @return array
     */
    abstract public function fetch();

    /**
     * Return the escaped string value.
     *
     * @param  string $value
     * @return string
     */
    abstract public function escape($value);

    /**
     * Return the auto-increment ID of the last query.
     *
     * @return int
     */
    abstract public function lastId();

    /**
     * Return the number of rows in the result.
     *
     * @throws Exception
     * @return int
     */
    abstract public function numRows();

    /**
     * Return the number of fields in the result.
     *
     * @throws Exception
     * @return int
     */
    abstract public function numFields();

    /**
     * Get an array of the tables of the database.
     *
     * @return array
     */
    public function getTables()
    {
        if (count($this->tables) == 0) {
            $this->tables = $this->loadTables();
        }

        return $this->tables;
    }

    /**
     * Return the database version.
     *
     * @return string
     */
    abstract public function version();

    /**
     * Load the tables of the database into an array.
     *
     * @return array
     */
    abstract protected function loadTables();

}
