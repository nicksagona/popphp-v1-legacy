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
namespace Pop\Db;

/**
 * This is the Sql adapter class for the Db component.
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.0
 */
class Sql
{

    /**
     * Constant for backtick id quote type
     * @var int
     */
    const BACKTICK = 1;

    /**
     * Constant for single quote id quote type
     * @var int
     */
    const SINGLE_QUOTE = 2;

    /**
     * Constant for double quote id quote type
     * @var int
     */
    const DOUBLE_QUOTE = 3;

    /**
     * Constant for bracket quote id quote type
     * @var int
     */
    const BRACKET = 4;

    /**
     * Constant for MYSQL database type
     * @var int
     */
    const MYSQL = 5;

    /**
     * Constant for SQLSRV database type
     * @var int
     */
    const SQLSRV = 6;

    /**
     * Constant for Oracle database type
     * @var int
     */
    const ORACLE = 7;

    /**
     * Constant for PGSQL database type
     * @var int
     */
    const PGSQL = 8;

    /**
     * Constant for SQLITE database type
     * @var int
     */
    const SQLITE = 9;

    /**
     * Database type
     * @var int
     */
    protected $dbType = null;

    /**
     * Current selected table
     * @var string
     */
    protected $table = null;

    /**
     * SQL type
     * @var string
     */
    protected $type = null;

    /**
     * SQL distinct flag
     * @var boolean
     */
    protected $distinct = false;

    /**
     * SQL select columns
     * @var array
     */
    protected $selectColumns = array();

    /**
     * SQL insert columns
     * @var array
     */
    protected $insertColumns = array();

    /**
     * SQL update columns
     * @var array
     */
    protected $updateColumns = array();

    /**
     * SQL join parameters
     * @var array
     */
    protected $join = array();

    /**
     * SQL where parameters
     * @var array
     */
    protected $where = array();

    /**
     * SQL order parameter
     * @var string
     */
    protected $order = null;

    /**
     * SQL limit parameter
     * @var int
     */
    protected $limit = null;

    /**
     * SQL clause
     * @var string
     */
    protected $sql = null;

    /**
     * Column identifier quote type
     * @var int
     */
    protected $idQuoteType = 0;

    /**
     * Constructor
     *
     * Instantiate the SQL object.
     *
     * @param  string  $table
     * @return \Pop\Db\Sql
     */
    public function __construct($table = null)
    {
        if (null !== $table) {
            $this->setTable($table);
        }
    }

    /**
     * Set the database type
     *
     * @param  string $db
     * @return \Pop\Db\Sql
     */
    public function setDbType($db = null)
    {
        $dbType = (int)$db;
        $this->dbType = (($dbType > 4) && ($dbType < 10)) ? $dbType : null;

        return $this;
    }

    /**
     * Set current table to operate on.
     *
     * @param  string $table
     * @return \Pop\Db\Sql
     */
    public function setTable($table)
    {
        $this->table = $table;
        $this->sql = null;
        $this->type = null;
        $this->distinct = false;
        $this->selectColumns = array();
        $this->insertColumns = array();
        $this->updateColumns = array();
        $this->join = array();
        $this->where = array();
        $this->order = null;
        $this->limit = null;

        return $this;
    }

    /**
     * Set the id quote type.
     *
     * @param  int $type
     * @return \Pop\Db\Sql
     */
    public function setIdQuoteType($type = 0)
    {
        switch ($type) {
            case self::BACKTICK:
                $this->idQuoteType = self::BACKTICK;
                $this->dbType = self::MYSQL;
                break;

            case self::SINGLE_QUOTE:
                $this->idQuoteType = self::SINGLE_QUOTE;
                break;

            case self::DOUBLE_QUOTE:
                $this->idQuoteType = self::DOUBLE_QUOTE;
                break;

            case self::BRACKET:
                $this->idQuoteType = self::BRACKET;
                $this->dbType = self::SQLSRV;
                break;

            default:
                $this->idQuoteType = 0;

        }

        return $this;
    }

    /**
     * Get the current database type.
     *
     * @return int
     */
    public function getDbType()
    {
        return $this->dbType;
    }

    /**
     * Get the id quote type as a string
     *
     * @param  boolean $end
     * @return string
     */
    public function getIdQuote($end = false)
    {
        $quote = null;

        switch ($this->idQuoteType) {
            case self::BACKTICK:
                $quote = '`';
                break;

            case self::SINGLE_QUOTE:
                $quote = "'";
                break;

            case self::DOUBLE_QUOTE:
                $quote = '"';
                break;

            case self::BRACKET:
                $quote = ($end) ? ']' : '[';
                break;

            default:
                $quote = '';

        }

        return $quote;
    }

    /**
     * Get the current SQL string.
     *
     * @return string
     */
    public function getSql()
    {
        $this->buildSql();
        return $this->sql;
    }

    /**
     * Set the query verb to SELECT.
     *
     * @param  string|array $columns
     * @return \Pop\Db\Sql
     */
    public function select($columns = '*')
    {
        $this->type = 'SELECT';
        $this->selectColumns = (!is_array($columns)) ? array($columns) : $columns;

        return $this;
    }

    /**
     * Set the distinct flag
     *
     * @param  boolean $distinct
     * @return \Pop\Db\Sql
     */
    public function distinct($distinct = true)
    {
        $this->distinct = $distinct;
        return $this;
    }

    /**
     * Set the query verb to INSERT and define the column set.
     *
     * @param  array $columns
     * @throws Exception
     * @return \Pop\Db\Sql
     */
    public function insert(array $columns)
    {
        if (count($columns) == 0) {
            throw new Exception('Error: The columns parameter must be an array that contains at least one key/value pair.');
        }

        $this->type = 'INSERT';
        $this->insertColumns = $this->quote($columns);

        return $this;
    }

    /**
     * Set the query verb to UPDATE and define the column set.
     *
     * @param  array $columns
     * @throws Exception
     * @return \Pop\Db\Sql
     */
    public function update(array $columns)
    {
        if (count($columns) == 0) {
            throw new Exception('Error: The columns parameter must be an array that contains at least one key/value pair.');
        }

        $this->type = 'UPDATE';
        $this->updateColumns = $this->quote($columns);

        return $this;
    }

    /**
     * Set the query verb to DELETE.
     *
     * @return \Pop\Db\Sql
     */
    public function delete()
    {
        $this->type = 'DELETE';
        return $this;
    }

    /**
     * Set the query JOIN parameters.
     *
     * @param  string $tableToJoin
     * @param  string $commonColumn
     * @param  string $typeOfJoin
     * @return \Pop\Db\Sql
     */
    public function join($tableToJoin, $commonColumn, $typeOfJoin = 'JOIN')
    {
        $allowedJoins = array(
            'JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'FULL JOIN',
            'OUTER JOIN', 'LEFT OUTER JOIN', 'RIGHT OUTER JOIN', 'FULL OUTER JOIN',
            'INNER JOIN', 'LEFT INNER JOIN', 'RIGHT INNER JOIN', 'FULL INNER JOIN'
        );

        $join = (in_array(strtoupper($typeOfJoin), $allowedJoins)) ? strtoupper($typeOfJoin) : 'JOIN';

        if (is_array($commonColumn)) {
            $col1 = $this->quoteId($commonColumn[0]);
            $col2 = $this->quoteId($commonColumn[1]);
            $cols = array($col1, $col2);
        } else {
            $cols = $this->quoteId($commonColumn);
        }

        $this->join = array(
            'tableToJoin' => $this->quoteId($tableToJoin),
            'commonColumn' => $cols,
            'typeOfJoin'  => $join
        );

        return $this;
    }

    /**
     * Set the query WHERE parameters.
     *
     * @param  string $column
     * @param  string $comparison
     * @param  string $value
     * @param  string $conjunction
     * @return \Pop\Db\Sql
     */
    public function where($column, $comparison, $value, $conjunction = 'AND')
    {
        $allowedComps = array('=', '!=', '<', '>', '<=', '>=', 'LIKE', 'NOT LIKE', 'BETWEEN', 'NOT BETWEEN');

        $comp = (in_array(strtoupper($comparison), $allowedComps)) ? strtoupper($comparison) : '=';
        $conj = (strtoupper($conjunction) == 'OR') ? 'OR' : 'AND';

        $quote = (($value == '?') || (substr($value, 0, 1) == ':') || (preg_match('/^\$\d*\d$/', $value) != 0)) ? null : "'";

        $this->where[] = array(
            'column'      => $this->quoteId($column),
            'comparison'  => $comp,
            'value'       => $quote . str_replace(' AND ', $quote . ' AND ' . $quote, $value) . $quote,
            'conjunction' => $conj
        );

        return $this;
    }

    /**
     * Set the query ORDER clause.
     *
     * @param  string|array $by
     * @param  string       $order
     * @return \Pop\Db\Sql
     */
    public function order($by, $order = 'ASC')
    {
        $allowedOrder = array('ASC', 'DESC', 'RAND()');
        $ord = (in_array(strtoupper($order), $allowedOrder)) ? strtoupper($order) : 'ASC';

        if (is_array($by)) {
            $byAry = array();
            foreach ($by as $value) {
                $byAry[] = $this->quoteId($value);
            }
            $this->order = implode(', ', $byAry);
        } else {
            $this->order = $this->quoteId($by);
        }

        $this->order .= ' ' . $ord;

        return $this;
    }

    /**
     * Set the query LIMIT value.
     *
     * @param  mixed $limit
     * @return \Pop\Db\Sql
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Built the SQL query.
     *
     * @throws Exception
     * @return void
     */
    protected function buildSql()
    {
        if (null === $this->table) {
            throw new Exception('Error: The table must be set.');
        } else if (null === $this->type) {
            throw new Exception('Error: A SQL type must be set.');
        }

        switch ($this->type) {
            // Build a SELECT query.
            case 'SELECT':
                $this->buildSelectSql();
                break;

            // Build an INSERT query.
            case 'INSERT':
                $this->sql = $this->type . ' INTO ' . $this->quoteId($this->table) . ' ' . $this->formatInsertValues();
                break;

            // Build an UPDATE query.
            case 'UPDATE':
                $this->sql = $this->type . ' ' . $this->quoteId($this->table) . ' SET ' . $this->formatUpdateValues();

                // If there is a where clause.
                if (count($this->where) > 0) {
                    $this->sql .= ' WHERE ' . $this->formatWhereConditions();
                }

                break;

            // Build a DELETE query.
            case 'DELETE':
                $this->sql = $this->type . ' FROM ' . $this->quoteId($this->table);

                // If there is a where clause.
                if (count($this->where) > 0) {
                    $this->sql .= ' WHERE ' . $this->formatWhereConditions();
                }

                break;
        }
    }

    /**
     * Method to build the select query
     *
     * @throws Exception
     * @return string
     */
    protected function buildSelectSql()
    {
        $selectColumns = ($this->distinct) ? 'DISTINCT ' : null;
        if ((count($this->selectColumns) == 1) && ($this->selectColumns[0] == '*')) {
            $selectColumns .= '*';
        } else {
            $selAry = array();
            foreach ($this->selectColumns as $value) {
                $selAry[] = $this->quoteId($value);
            }
            $selectColumns .= implode(', ', $selAry);
        }

        $this->sql = $this->type . ' ' . $selectColumns . ' FROM ';

        // Account for LIMIT clause if the database is ORACLE
        if (($this->dbType == self::ORACLE) && (null !== $this->limit)) {
            if (null === $this->order) {
                throw new Exception('Error: You must set and order field to execute a limit clause on the Oracle databse.');
            }

            $this->sql .= '(SELECT t.*, ROW_NUMBER() OVER (ORDER BY ' . $this->order . ') RowNumber FROM ' . $this->quoteId($this->table) . ' t)';
            if (strpos($this->limit, ',') !== false) {
                $lim = explode(',', $this->limit);
                $this->where('RowNumber', 'BETWEEN', trim($lim[0]) . ' AND ' . trim($lim[1]));
            } else {
                $this->where('RowNumber', '<=', $this->limit);
            }
        // Account for LIMIT clause if the database is SQLSRV
        } else if (($this->dbType == self::SQLSRV) && (null !== $this->limit)) {
            if (strpos($this->limit, ',') !== false) {
                if (null === $this->order) {
                    throw new Exception('Error: You must set and order field to execute a limit clause on the SQLSRV databse.');
                }
                $lim = explode(',', $this->limit);
                $this->sql .= '(SELECT *, ROW_NUMBER() OVER (ORDER BY ' . $this->order . ') AS RowNumber FROM ' . $this->quoteId($this->table) . ') AS OrderedTable';
                $this->where('OrderedTable.RowNumber', 'BETWEEN', trim($lim[0]) . ' AND ' . trim($lim[1]));
            } else {
                $this->sql = str_replace('SELECT', 'SELECT TOP ' . $this->limit, $this->sql);
                $this->sql .= $this->quoteId($this->table);
            }
        } else {
            $this->sql .= $this->quoteId($this->table);
        }

        // If there is a join clause.
        if (count($this->join) > 0) {
            if (is_array($this->join['commonColumn'])) {
                $col1 = $this->join['commonColumn'][0];
                $col2 = $this->join['commonColumn'][1];
            } else {
                $col1 = $this->join['commonColumn'];
                $col2 = $this->join['commonColumn'];
            }
            $this->sql .= ' ' . $this->join['typeOfJoin'] . ' ' . $this->join['tableToJoin'] . ' ON ' . $this->quoteId($this->table) . '.' . $col1 . ' = ' . $this->join['tableToJoin'] . '.' . $col2;
        }

        // If there is a where clause.
        if (count($this->where) > 0) {
            $this->sql .= ' WHERE ' . $this->formatWhereConditions();
        }

        // If there is an order clause.
        if (null !== $this->order) {
            $this->sql .= ' ORDER BY ' . $this->order;
        }

        // If there is a limit clause for all other database types.
        if (($this->dbType != self::SQLSRV) && ($this->dbType != self::ORACLE)) {
            if (null !== $this->limit) {
                $this->sql .= ' LIMIT ' . $this->limit;
            }
        }
    }

    /**
     * Method to add quotes to the column values
     *
     * @param  array $columns
     * @return array
     */
    protected function quote($columns)
    {
        $ary = array();

        foreach ($columns as $key => $value) {
            $k = $this->quoteId($key);
            $quote = (($value == '?') || (substr($value, 0, 1) == ':') || (preg_match('/^\$\d*\d$/', $value) != 0)) ? null : "'";
            $v = $quote . $value . $quote;
            $ary[$k] = $v;
        }

        return $ary;
    }

    /**
     * Method to add id quotes to a column id
     *
     * @param  string $id
     * @return string
     */
    protected function quoteId($id)
    {
        $quotedId = null;

        if (strpos($id, '.') !== false) {
            $idAry = explode('.', $id);
            foreach ($idAry as $key => $value) {
                $idAry[$key] = $this->getIdQuote() . $value . $this->getIdQuote(true);
            }
            $quotedId = implode('.', $idAry);
        } else {
            $quotedId = $this->getIdQuote() . $id . $this->getIdQuote(true);
        }

        return $quotedId;
    }

    /**
     * Method to format column value sets for insert.
     *
     * @return string
     */
    protected function formatInsertValues()
    {
        $sqlColumns = array();
        $sqlValues = array();

        foreach ($this->insertColumns as $key => $value) {
            $sqlColumns[] = $key;
            $sqlValues[] = $value;
        }

        return '(' . implode(', ', $sqlColumns) . ') VALUES (' . implode(', ', $sqlValues) . ')';
    }

    /**
     * Method to format column value sets for update.
     *
     * @return string
     */
    protected function formatUpdateValues()
    {
        $sqlColumns = array();

        foreach ($this->updateColumns as $key => $value) {
            $sqlColumns[] = $key . ' = ' . $value;
        }

        return implode(', ', $sqlColumns);
    }

    /**
     * Method to format where conditions
     *
     * @return string
     */
    protected function formatWhereConditions()
    {
        $whereSql = null;

        for ($i = 0; $i < count($this->where); $i++) {
            $whereSql .= '(' . $this->where[$i]['column'] . ' ' . $this->where[$i]['comparison'] . ' ' . $this->where[$i]['value'] . ')';
            if ($i < (count($this->where) - 1)) {
                $whereSql .= ' ' . $this->where[$i]['conjunction'] . ' ';
            }
        }

        return $whereSql;
    }

    /**
     * Method to return the SQL as a string
     *
     * @return string
     */
    public function __toString()
    {
        $this->buildSql();
        return $this->sql;
    }

}
