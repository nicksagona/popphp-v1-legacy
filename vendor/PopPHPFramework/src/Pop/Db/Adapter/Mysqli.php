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
class Mysqli extends AbstractAdapter
{

    /**
     * Prepared statement
     * @var MySQLi_STMT
     */
    protected $_statement = null;

    /**
     * Constructor
     *
     * Instantiate the MySQLi database connection object.
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
            $this->connection = new \mysqli($options['host'], $options['username'], $options['password'], $options['database']);

            if ($this->connection->connect_error != '') {
                throw new Exception($this->_lang->__('Error: Could not connect to database. Connection Error #%1: %2.', array($this->connection->connect_errno, $this->connection->connect_error)));
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
        throw new Exception($this->_lang->__('Error:') . ' ' . $this->connection->errno . ' => ' . $this->connection->error . '.');
    }

    /**
     * Prepare a SQL query.
     *
     * @param  string $sql
     * @return Pop_Db_Adapter_Mysqli
     */
    public function prepare($sql)
    {
        $this->_statement = $this->connection->stmt_init();
        $this->_statement->prepare($sql);

        return $this;
    }

    /**
     * Bind parameters to a prepared SQL query.
     *
     * @param  array  $params
     * @return Pop_Db_Adapter_Mysqli
     */
    public function bindParams($params)
    {
        $bindParams = array('');

        foreach ($params as $key => $value) {
            ${$key} = $value;

            if (is_int($value)) {
                $bindParams[0] .= 'i';
            } else if (is_double($value)) {
                $bindParams[0] .= 'd';
            } else if (is_string($value)) {
                $bindParams[0] .= 's';
            } else {
                $bindParams[0] .= 'b';
            }

            $bindParams[] = &${$key};
        }

        call_user_func_array(array($this->_statement, 'bind_param'), $bindParams);

        return $this;
    }

    /**
     * Bind result values to variables and fetch and return the values.
     *
     * @return array
     */
    public function fetchResult()
    {
        $params = array();
        $bindParams = array();

        $metaData = $this->_statement->result_metadata();

        foreach ($metaData->fetch_fields() as $col) {
            ${$col->name} = null;
            $bindParams[] = &${$col->name};
            $params[] = $col->name;
        }

        call_user_func_array(array($this->_statement, 'bind_result'), $bindParams);

        $rows = array();

        while (($row = $this->_statement->fetch()) != false) {
            $ary = array();
            foreach ($bindParams as $key => $value) {
                $ary[$params[$key]] = $value;
            }
            $rows[] = $ary;
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
            $this->_statement->execute();
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
        if (null !== $this->_statement) {
            return $this->_statement->fetch();
        } else {
            if (!isset($this->result)) {
                throw new Exception($this->_lang->__('Error: The database result resource is not currently set.'));
            } else {
                return $this->result->fetch_array(MYSQLI_ASSOC);
            }
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
        return $this->connection->real_escape_string($value);
    }

    /**
     * Return the auto-increment ID of the last query.
     *
     * @return int
     */
    public function lastId()
    {
        return $this->connection->insert_id;
    }

    /**
     * Return the number of rows in the result.
     *
     * @throws Exception
     * @return int
     */
    public function numRows()
    {
        if (isset($this->_statement)) {
            $this->_statement->store_result();
            return $this->_statement->num_rows;
        } else if (isset($this->result)) {
            return $this->result->num_rows;
        } else {
            throw new Exception($this->_lang->__('Error: The database result resource is not currently set.'));
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
        if (isset($this->_statement)) {
            $this->_statement->store_result();
            return $this->_statement->field_count;
        } else if (isset($this->result)) {
            return $this->connection->field_count;
        } else {
            throw new Exception($this->_lang->__('Error: The database result resource is not currently set.'));
        }
    }

    /**
     * Return the database version.
     *
     * @return string
     */
    public function version()
    {
        return 'MySQL ' . $this->connection->server_info;
    }

    /**
     * Get an array of the tables of the database.
     *
     * @return array
     */
    protected function _loadTables()
    {
        $tables = array();

        $this->query('SHOW TABLES');
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
        $this->connection->close();
    }

}
