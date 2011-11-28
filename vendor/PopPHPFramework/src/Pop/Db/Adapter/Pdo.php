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
class Pdo extends AbstractAdapter
{

    /**
     * PDO DSN
     * @var string
     */
    protected $_dsn = null;

    /**
     * PDO DB Type
     * @var string
     */
    protected $_dbtype = null;

    /**
     * Prepared statement
     * @var PDOStatement
     */
    protected $_statement = null;

    /**
     * Statement placeholder
     * @var string
     */
    protected $_placeholder = null;

    /**
     * Constructor
     *
     * Instantiate the PDO database connection object.
     *
     * @param  array $options
     * @throws Exception
     * @return void
     */
    public function __construct(array $options)
    {
        $this->_lang = new Locale();

        if (!isset($options['type']) || !isset($options['database'])) {
            throw new Exception($this->_lang->__('Error: The proper database credentials were not passed.'));
        } else {
            try {
                $this->_dbtype = $options['type'];
                if ($this->_dbtype == 'sqlite') {
                    $this->_dsn = $this->_dbtype . ':' . $options['database'];
                    $this->connection = new PDO($this->_dsn);
                } else {
                    if (!isset($options['host']) || !isset($options['username']) || !isset($options['password'])) {
                        throw new Exception($this->_lang->__('Error: The proper database credentials were not passed.'));
                    } else {
                        $this->_dsn = $this->_dbtype . ':host=' . $options['host'] . ';dbname=' . $options['database'];
                        $this->connection = new PDO($this->_dsn, $options['username'], $options['password']);
                    }
                }
            } catch (\PDOException $e) {
                throw new Exception($this->_lang->__('Error: Could not connect to database. %1', $e->getMessage()));
            }
        }
    }

    /**
     * Get PDO DSN
     *
     * @return string
     */
    public function getDsn()
    {
        return $this->_dsn;
    }

    /**
     * Get PDO DB Type
     *
     * @return string
     */
    public function getDbtype()
    {
        return $this->_dbtype;
    }

    /**
     * Throw an exception upon a database error.
     *
     * @param  string $code
     * @param  array  $info
     * @throws Exception
     * @return void
     */
    public function showError($code = null, $info = null)
    {
        $errorMessage = null;

        if ((null === $code) && (null === $info)) {
            $errorCode = $this->connection->errorCode();
            $errorInfo = $this->connection->errorInfo();
        } else {
            $errorCode = $code;
            $errorInfo = $info;
        }

        if (is_array($errorInfo)) {
            $errorMessage = null;
            if (isset($errorInfo[1])) {
                $errorMessage .= $errorInfo[1];
            }
            if (isset($errorInfo[2])) {
                $errorMessage .= ' : ' . $errorInfo[2];
            }
        } else {
            $errorMessage = $errorInfo;
        }

        throw new Exception($this->_lang->__('Error:') . ' ' . $errorCode . ' => ' . $errorMessage  . '.');
    }

    /**
     * Prepare a SQL query.
     *
     * @param  string $sql
     * @param  array  $attribs
     * @return Pop_Db_Adapter_Pdo
     */
    public function prepare($sql, $attribs = null)
    {
        if (strpos($sql, '?') !== false) {
            $this->_placeholder = '?';
        } else if (strpos($sql, ':') !== false) {
            $this->_placeholder = ':';
        }

        if ((null !== $attribs) && is_array($attribs)) {
            $this->_statement = $this->connection->prepare($sql, $attribs);
        } else {
            $this->_statement = $this->connection->prepare($sql);
        }

        return $this;
    }

    /**
     * Bind parameters to for a prepared SQL query.
     *
     * @param  array  $params
     * @return Pop_Db_Adapter_Pdo
     */
    public function bindParams($params)
    {
        if ($this->_placeholder == '?') {
            $i = 1;
            foreach ($params as $key => $value) {
                ${$key} = $value;
                $this->_statement->bindParam($i, ${$key});
                $i++;
            }
        } else if ($this->_placeholder == ':') {
            foreach ($params as $key => $value) {
                ${$key} = $value;
                $this->_statement->bindParam(':' . $key, ${$key});
            }
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
        return $this->_statement->fetchAll(PDO::FETCH_ASSOC);
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
            $this->result = $this->_statement->execute();
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
        $sth = $this->connection->prepare($sql);

        if (!($sth->execute())) {
            $this->showError($sth->errorCode(), $sth->errorInfo());
        } else {
            $this->result = $sth;
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
            return $this->result->fetch(PDO::FETCH_ASSOC);
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
        return $this->connection->quote($value);
    }

    /**
     * Return the auto-increment ID of the last query.
     *
     * @return int
     */
    public function lastId()
    {
        return $this->connection->lastInsertId();
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
            return $this->result->rowCount();
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
            return $this->result->columnCount();
        }
    }

    /**
     * Return the database version.
     *
     * @return string
     */
    public function version()
    {
        return 'PDO ' . substr($this->_dsn, 0, strpos($this->_dsn, ':'));
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
        $this->connection = null;
    }

}
