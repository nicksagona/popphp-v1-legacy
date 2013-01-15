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
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Db\Adapter;

/**
 * This is the Pdo adapter class for the Db component.
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.2.0
 */
class Pdo extends AbstractAdapter
{

    /**
     * Database
     * @var string
     */
    protected $database = null;

    /**
     * PDO DSN
     * @var string
     */
    protected $dsn = null;

    /**
     * PDO DB Type
     * @var string
     */
    protected $dbtype = null;

    /**
     * Prepared statement
     * @var \PDOStatement
     */
    protected $statement = null;

    /**
     * Statement placeholder
     * @var string
     */
    protected $placeholder = null;

    /**
     * Constructor
     *
     * Instantiate the PDO database connection object.
     *
     * @param  array $options
     * @throws Exception
     * @return \Pop\Db\Adapter\Pdo
     */
    public function __construct(array $options)
    {
        if (!isset($options['type']) || !isset($options['database'])) {
            throw new Exception('Error: The proper database credentials were not passed.');
        }

        try {
            $this->database = $options['database'];
            $this->dbtype = strtolower($options['type']);
            if ($this->dbtype == 'sqlite') {
                $this->dsn = $this->dbtype . ':' . $options['database'];
                $this->connection = new \PDO($this->dsn);
            } else {
                if (!isset($options['host']) || !isset($options['username']) || !isset($options['password'])) {
                    throw new Exception('Error: The proper database credentials were not passed.');
                }

                if ($this->dbtype == 'sqlsrv') {
                    $this->dsn = $this->dbtype . ':Server=' . $options['host'] . ';Database=' . $options['database'];
                } else {
                    $this->dsn = $this->dbtype . ':host=' . $options['host'] . ';dbname=' . $options['database'];
                }

                $this->connection = new \PDO($this->dsn, $options['username'], $options['password']);
            }
        } catch (\PDOException $e) {
            throw new Exception('Error: Could not connect to database. ' . $e->getMessage());
        }
    }

    /**
     * Get PDO DSN
     *
     * @return string
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * Get PDO DB Type
     *
     * @return string
     */
    public function getDbtype()
    {
        return $this->dbtype;
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

        throw new Exception('Error: ' . $errorCode . ' => ' . $errorMessage  . '.');
    }

    /**
     * Prepare a SQL query.
     *
     * @param  string $sql
     * @param  array  $attribs
     * @return \Pop\Db\Adapter\Pdo
     */
    public function prepare($sql, $attribs = null)
    {
        if (strpos($sql, '?') !== false) {
            $this->placeholder = '?';
        } else if (strpos($sql, ':') !== false) {
            $this->placeholder = ':';
        }

        if ((null !== $attribs) && is_array($attribs)) {
            $this->statement = $this->connection->prepare($sql, $attribs);
        } else {
            $this->statement = $this->connection->prepare($sql);
        }

        return $this;
    }

    /**
     * Bind parameters to for a prepared SQL query.
     *
     * @param  array  $params
     * @return \Pop\Db\Adapter\Pdo
     */
    public function bindParams($params)
    {
        if ($this->placeholder == '?') {
            $i = 1;
            foreach ($params as $key => $value) {
                ${$key} = $value;
                $this->statement->bindParam($i, ${$key});
                $i++;
            }
        } else if ($this->placeholder == ':') {
            foreach ($params as $key => $value) {
                ${$key} = $value;
                $this->statement->bindParam(':' . $key, ${$key});
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
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
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
            throw new Exception('Error: The database result resource is not currently set.');
        }

        return $this->result->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Return the escaped string value.
     *
     * @param  string $value
     * @return string
     */
    public function escape($value)
    {
        return substr($this->connection->quote($value), 1, -1);
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
            throw new Exception('Error: The database result resource is not currently set.');
        }

        return $this->result->rowCount();
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

        return $this->result->columnCount();
    }

    /**
     * Return the database version.
     *
     * @return string
     */
    public function version()
    {
        return 'PDO ' . substr($this->dsn, 0, strpos($this->dsn, ':')) . ' ' . $this->connection->getAttribute(\PDO::ATTR_SERVER_VERSION);
    }

    /**
     * Get an array of the tables of the database.
     *
     * @return array
     */
    protected function loadTables()
    {
        $tables = array();

        if (stripos($this->dsn, 'sqlite') !== false) {
            $sql = "SELECT name FROM sqlite_master WHERE type IN ('table', 'view') AND name NOT LIKE 'sqlite_%' UNION ALL SELECT name FROM sqlite_temp_master WHERE type IN ('table', 'view') ORDER BY 1";

            $this->query($sql);
            while (($row = $this->fetch()) != false) {
                $tables[] = $row['name'];
            }
        } else {
            if (stripos($this->dsn, 'pgsql') !== false) {
                $sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'";
            } else if (stripos($this->dsn, 'sqlsrv') !== false) {
                $sql = "SELECT name FROM " . $this->database . "..sysobjects WHERE xtype = 'U'";
            } else {
                $sql = 'SHOW TABLES';
            }
            $this->query($sql);
            while (($row = $this->fetch()) != false) {
                foreach($row as $value) {
                    $tables[] = $value;
                }
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
