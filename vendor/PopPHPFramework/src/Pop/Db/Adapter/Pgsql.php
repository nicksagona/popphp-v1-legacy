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

use Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Pgsql extends AbstractAdapter
{

    /**
     * Prepared statement
     * @var resource
     */
    protected $_statement = null;

    /**
     * Prepared statement parameters
     * @var array
     */
    protected $_parameters = null;

    /**
     * Prepared SQL string
     * @var string
     */
    protected $_sql = null;

    /**
     * Constructor
     *
     * Instantiate the PostgreSQL database connection object.
     *
     * @param  array $options
     * @throws Exception
     * @return void
     */
    public function __construct(array $options)
    {
        $this->_lang = new Locale();

        if (!isset($options['database']) || !isset($options['host']) || !isset($options['username']) || !isset($options['password'])) {
            throw new Exception($this->_lang->__('Error: The proper database credentials were not passed.'));
        } else {
            $this->connection = pg_connect("host=" . $options['host'] . " dbname=" . $options['database'] . " user=" . $options['username'] . " password=" . $options['password']);

            // Select the DB to use, or display the SQL error.
            if (!$this->connection) {
                throw new Exception('Error: There was an error connecting to the database.');
            }
        }
    }

    /**
     * Throw an exception upon a database error.
     *
     * @throws Exception
     * @return void
     */
    public function showError()
    {
        throw new Exception(pg_last_error($this->connection) . '.');
    }

    /**
     * Prepare a SQL query.
     *
     * @param  string $sql
     * @return Pop_Db_Adapter_Pgsql
     */
    public function prepare($sql)
    {
        $this->_sql = $sql;
        $this->_statement = pg_prepare($this->connection, 'pop_db_adapter_pgsql_statement', $this->_sql);
        return $this;
    }

    /**
     * Bind parameters to for a prepared SQL query.
     *
     * @param  string|array  $params
     * @return Pop_Db_Adapter_Pgsql
     */
    public function bindParams($params)
    {
        if (!is_array($params)) {
            $params = array($params);
        }

        $this->_parameters = $params;

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
     * @param  string $sql
     * @throws Exception
     * @return void
     */
    public function execute()
    {
        if (null === $this->_statement) {
            throw new Exception($this->_lang->__('Error: The database statement resource is not currently set.'));
        } else {
            if ((null !== $this->_parameters) && is_array($this->_parameters))  {
                $this->result = pg_execute($this->connection, 'pop_db_adapter_pgsql_statement', $this->_parameters);
            } else {
                $this->query($this->_sql);
            }
        }
    }

    /**
     * Execute the SQL query and create a result resource, or display the SQL error.
     *
     * @param  string $sql
     * @return void
     */
    public function query($sql)
    {
        if (!($this->result = pg_query($this->connection, $sql))) {
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
            throw new Exception($this->_lang->__('Error: The database result resource is not currently set.'));
        } else {
            return pg_fetch_array($this->result, null, PGSQL_ASSOC);
        }
    }

    /**
     * Return the escaped string value.
     *
     * @param  string $value
     * @return string
     */
    public function escape($value)
    {
        return pg_escape_string($value);
    }

    /**
     * Return the auto-increment ID of the last query.
     *
     * @return int
     */
    public function lastId()
    {
        $insert_query = pg_query("SELECT lastval();");
        $insert_row = pg_fetch_row($insert_query);

        return $insert_row[0];
    }

    /**
     * Return the number of rows in the result.
     *
     * @throws Exception
     * @return int
     */
    public function numRows()
    {
        if (!isset($this->result)) {
            throw new Exception($this->_lang->__('Error: The database result resource is not currently set.'));
        } else {
            return pg_num_rows($this->result);
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
            throw new Exception($this->_lang->__('Error: The database result resource is not currently set.'));
        } else {
            return pg_num_fields($this->result);
        }
    }

    /**
     * Return the database version.
     *
     * @return string
     */
    public function version()
    {
        $ver = pg_version($this->connection);
        return 'PostgreSQL ' . $ver['server'];
    }

    /**
     * Get an array of the tables of the database.
     *
     * @return array
     */
    protected function _loadTables()
    {
        $tables = array();

        $this->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        while (($row = $this->fetch()) != false) {
            foreach($row as $value) {
                $tables[] = $value;
            }
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
        pg_close($this->connection);
    }

}
