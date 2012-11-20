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
 * This is the Sqlite adapter class for the Db component.
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
 */
class Sqlite extends AbstractAdapter
{

    /**
     * Last result
     * @var resource
     */
    public $last_result;

    /**
     * Last SQL query
     * @var string
     */
    public $last_sql = null;

    /**
     * Prepared statement
     * @var SQLite3Stmt
     */
    protected $statement = null;

    /**
     * Constructor
     *
     * Instantiate the SQLite database connection object.
     *
     * @param  array $options
     * @throws Exception
     * @return void
     */
    public function __construct(array $options)
    {
        // Select the DB to use, or display the SQL error.
        if (!isset($options['database'])) {
            throw new Exception('Error: The database file was not passed.');
        } else if (!file_exists($options['database'])) {
            throw new Exception('Error: The database file does not exists.');
        }

        $this->connection = new \SQLite3($options['database']);
    }

    /**
     * Throw an exception upon a database error.
     *
     * @throws Exception
     * @return void
     */
    public function showError()
    {
        throw new Exception('Error: ' . $this->connection->lastErrorCode() . ' => ' . $this->connection->lastErrorMsg() . '.');
    }

    /**
     * Prepare a SQL query.
     *
     * @param  string $sql
     * @return Pop\Db\Adapter\Sqlite
     */
    public function prepare($sql)
    {
        $this->statement = $this->connection->prepare($sql);
        return $this;
    }

    /**
     * Bind parameters to for a prepared SQL query.
     *
     * @param  array  $params
     * @return Pop\Db\Adapter\Sqlite
     */
    public function bindParams($params)
    {
        foreach ($params as $key => $value) {
            ${$key} = $value;
            $this->statement->bindParam(':' . $key, ${$key});
        }

        return $this;
    }

    /**
     * Fetch and return the values.
     *
     * @return array
     */
    public function fetchResult()
    {
        $rows = array();

        while (($row = $this->fetch()) != false) {
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     * Execute the prepared SQL query.
     *
     * @throws Exception
     * @return void
     */
    public function execute()
    {
        if (null === $this->statement) {
            throw new Exception('Error: The database statement resource is not currently set.');
        }

        $this->result = $this->statement->execute();
    }

    /**
     * Execute the SQL query and create a result resource, or display the SQL error.
     *
     * @param  string $sql
     * @return void
     */
    public function query($sql)
    {
        if (stripos($sql, 'select') !== false) {
            $this->last_sql = $sql;
        } else {
            $this->last_sql = null;
        }

        if (!($this->result = $this->connection->query($sql))) {
            $this->showError();
        }
    }

    /**
     * Return the results array from the results resource.
     *
     * @throws Exception
     * @return array
     */
    public function fetch()
    {
        if (!isset($this->result)) {
            throw new Exception('Error: The database result resource is not currently set.');
        }

        return $this->result->fetchArray(SQLITE3_ASSOC);
    }

    /**
     * Return the escaped string value.
     *
     * @param  string $value
     * @return string
     */
    public function escape($value)
    {
        return $this->connection->escapeString($value);
    }

    /**
     * Return the auto-increment ID of the last query.
     *
     * @return int
     */
    public function lastId()
    {
        return $this->connection->lastInsertRowID();
    }

    /**
     * Return the number of rows in the result.
     *
     * @return int
     */
    public function numRows()
    {
        if (null === $this->last_sql) {
            return $this->connection->changes();
        } else {
            if (!($this->last_result = $this->connection->query($this->last_sql))) {
                $this->showError();
            } else {
                $num = 0;
                while (($row = $this->last_result->fetcharray(SQLITE3_ASSOC)) != false) {
                    $num++;
                }
                return $num;
            }
        }
    }

    /**
     * Return the number of fields in the result.
     *
     * @throws Exception
     * @return int
     */
    public function numFields()
    {
        if (!isset($this->result)) {
            throw new Exception('Error: The database result resource is not currently set.');
        }

        return $this->result->numColumns();
    }

    /**
     * Return the database version.
     *
     * @return string
     */
    public function version()
    {
        $ver = $this->connection->version();
        return 'SQLite ' . $ver['versionString'];
    }

    /**
     * Get an array of the tables of the database.
     *
     * @return array
     */
    protected function loadTables()
    {
        $tables = array();

        $sql = "SELECT name FROM sqlite_master WHERE type IN ('table', 'view') AND name NOT LIKE 'sqlite_%' UNION ALL SELECT name FROM sqlite_temp_master WHERE type IN ('table', 'view') ORDER BY 1";

        $this->query($sql);
        while (($row = $this->fetch()) != false) {
            $tables[] = $row['name'];
        }

        return $tables;
    }

    /**
     * Close the DB connection.
     *
     * @return void
     */
    public function __destruct()
    {
        $this->connection->close();
    }

}
