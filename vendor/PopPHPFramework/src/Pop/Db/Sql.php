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
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Db_Sql
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Db_Sql
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
     * Current selected table
     * @var string
     */
    protected $_table = null;

    /**
     * SQL type
     * @var string
     */
    protected $_type = null;

    /**
     * SQL distinct flag
     * @var boolean
     */
    protected $_distinct = false;

    /**
     * SQL select columns
     * @var array
     */
    protected $_selectColumns = array();

    /**
     * SQL insert columns
     * @var array
     */
    protected $_insertColumns = array();

    /**
     * SQL update columns
     * @var array
     */
    protected $_updateColumns = array();

    /**
     * SQL join parameters
     * @var array
     */
    protected $_join = array();

    /**
     * SQL where parameters
     * @var array
     */
    protected $_where = array();

    /**
     * SQL order parameter
     * @var string
     */
    protected $_order = null;

    /**
     * SQL limit parameter
     * @var int
     */
    protected $_limit = null;

    /**
     * SQL clause
     * @var string
     */
    protected $_sql = null;

    /**
     * Column identifier quote type
     * @var int
     */
    protected $_idQuoteType = 0;

    /**
     * Language object
     * @var Pop_Locale
     */
    protected $_lang = null;

    /**
     * Constructor
     *
     * Instantiate the SQL object.
     *
     * @param  string  $table
     * @return void
     */
    public function __construct($table = null)
    {
        $this->_lang = new Pop_Locale();

        if (null !== $table) {
            $this->setTable($table);
        }
    }

    /**
     * Set current table to operate on.
     *
     * @param  string $table
     * @return Pop_Db_Sql
     */
    public function setTable($table)
    {
        $this->_table = $table;
        $this->_sql = null;
        $this->_type = null;
        $this->_distinct = false;
        $this->_selectColumns = array();
        $this->_insertColumns = array();
        $this->_updateColumns = array();
        $this->_join = array();
        $this->_where = array();
        $this->_order = null;
        $this->_limit = null;

        return $this;
    }

    /**
     * Set the id quote type.
     *
     * @param  int $type
     * @return Pop_Db_Sql
     */
    public function setIdQuoteType($type = 0)
    {
        switch ($type) {
            case self::BACKTICK:
                $this->_idQuoteType = self::BACKTICK;
                break;

            case self::SINGLE_QUOTE:
                $this->_idQuoteType = self::SINGLE_QUOTE;
                break;

            case self::DOUBLE_QUOTE:
                $this->_idQuoteType = self::DOUBLE_QUOTE;
                break;

            case self::BRACKET:
                $this->_idQuoteType = self::BRACKET;
                break;

            default:
                $this->_idQuoteType = 0;

        }

        return $this;
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

        switch ($this->_idQuoteType) {
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
        return $this->_sql;
    }

    /**
     * Set the query verb to SELECT.
     *
     * @param  string|array $columns
     * @return Pop_Db_Sql
     */
    public function select($columns = '*')
    {
        $this->_type = 'SELECT';
        $this->_selectColumns = (!is_array($columns)) ? array($columns) : $columns;

        return $this;
    }

    /**
     * Set the distinct flag
     *
     * @param  boolean $distinct
     * @return Pop_Db_Sql
     */
    public function distinct($distinct = true)
    {
        $this->_distinct = $distinct;
        return $this;
    }

    /**
     * Set the query verb to INSERT and define the column set.
     *
     * @param  array $columns
     * @throws Exception
     * @return Pop_Db_Sql
     */
    public function insert($columns)
    {
        if (!is_array($columns)) {
            throw new Exception($this->_lang->__('Error: The columns parameter must be an array.'));
        } else if (count($columns) == 0) {
            throw new Exception($this->_lang->__('Error: The columns parameter must be an array that contains at least one key/value pair.'));
        } else {
            $this->_type = 'INSERT';
            $this->_insertColumns = $this->_quote($columns);
            return $this;
        }
    }

    /**
     * Set the query verb to UPDATE and define the column set.
     *
     * @param  array $columns
     * @throws Exception
     * @return Pop_Db_Sql
     */
    public function update($columns)
    {
        if (!is_array($columns)) {
            throw new Exception($this->_lang->__('Error: The columns parameter must be an array.'));
        } else if (count($columns) == 0) {
            throw new Exception($this->_lang->__('Error: The columns parameter must be an array that contains at least one key/value pair.'));
        } else {
            $this->_type = 'UPDATE';
            $this->_updateColumns = $this->_quote($columns);
            return $this;
        }
    }

    /**
     * Set the query verb to DELETE.
     *
     * @return Pop_Db_Sql
     */
    public function delete()
    {
        $this->_type = 'DELETE';
        return $this;
    }

    /**
     * Set the query JOIN parameters.
     *
     * @param  string $tableToJoin
     * @param  string $commonColumn
     * @param  string $typeOfJoin
     * @return Pop_Db_Sql
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
            $col1 = $this->_quoteId($commonColumn[0]);
            $col2 = $this->_quoteId($commonColumn[1]);
            $cols = array($col1, $col2);
        } else {
            $cols = $this->_quoteId($commonColumn);
        }

        $this->_join = array(
                           'tableToJoin' => $this->_quoteId($tableToJoin),
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
     * @return Pop_Db_Sql
     */
    public function where($column, $comparison, $value, $conjunction = 'AND')
    {
        $allowedComps = array('=', '!=', '<', '>', '<=', '>=', 'LIKE', 'NOT LIKE');

        $comp = (in_array(strtoupper($comparison), $allowedComps)) ? strtoupper($comparison) : '=';
        $conj = (strtoupper($conjunction) == 'OR') ? 'OR' : 'AND';

        $quote = (($value == '?') || (substr($value, 0, 1) == ':') || (preg_match('/^\$\d*\d$/', $value) != 0)) ? null : "'";

        $this->_where[] = array(
                              'column'      => $this->_quoteId($column),
                              'comparison'  => $comp,
                              'value'       => $quote . $value . $quote,
                              'conjunction' => $conj
                          );

        return $this;
    }

    /**
     * Set the query ORDER clause.
     *
     * @param  string|array $by
     * @param  string       $order
     * @return Pop_Db_Sql
     */
    public function order($by, $order = 'ASC')
    {
        $allowedOrder = array('ASC', 'DESC', 'RAND()');
        $ord = (in_array(strtoupper($order), $allowedOrder)) ? strtoupper($order) : 'ASC';

        if (is_array($by)) {
            $byAry = array();
            foreach ($by as $value) {
                $byAry[] = $this->_quoteId($value);
            }
            $this->_order = implode(', ', $byAry);
        } else {
            $this->_order = $this->_quoteId($by);
        }

        $this->_order .= ' ' . $ord;

        return $this;
    }

    /**
     * Set the query LIMIT value.
     *
     * @param  int $limit
     * @return Pop_Db_Sql
     */
    public function limit($limit)
    {
        $this->_limit = (int)$limit;
        return $this;
    }

    /**
     * Built the SQL query.
     *
     * @param  boolean $ret
     * @throws Exception
     * @return Pop_Db_Sql|string
     */
    public function buildSql($ret = false)
    {
        if (null === $this->_table) {
            throw new Exception($this->_lang->__('Error: The table must be set.'));
        } else if (null === $this->_type) {
            throw new Exception($this->_lang->__('Error: A SQL type must be set.'));
        } else {
            switch ($this->_type) {
                // Build a SELECT query.
                case 'SELECT':
                    $selectColumns = ($this->_distinct) ? 'DISTINCT ' : null;
                    if ((count($this->_selectColumns) == 1) && ($this->_selectColumns[0] == '*')) {
                        $selectColumns .= '*';
                    } else {
                        $selAry = array();
                        foreach ($this->_selectColumns as $value) {
                            $selAry[] = $this->_quoteId($value);
                        }
                        $selectColumns .= implode(', ', $selAry);
                    }

                    $this->_sql = $this->_type . ' ' . $selectColumns . ' FROM ' . $this->_quoteId($this->_table);

                    // If there is a join clause.
                    if (count($this->_join) > 0) {
                        if (is_array($this->_join['commonColumn'])) {
                            $col1 = $this->_join['commonColumn'][0];
                            $col2 = $this->_join['commonColumn'][1];
                        } else {
                            $col1 = $this->_join['commonColumn'];
                            $col2 = $this->_join['commonColumn'];
                        }
                        $this->_sql .= ' ' . $this->_join['typeOfJoin'] . ' ' . $this->_join['tableToJoin'] . ' ON ' . $this->_quoteId($this->_table) . '.' . $col1 . ' = ' . $this->_join['tableToJoin'] . '.' . $col2;
                    }

                    // If there is a where clause.
                    if (count($this->_where) > 0) {
                        $this->_sql .= ' WHERE ' . $this->_formatWhereConditions();
                    }

                    // If there is an order clause.
                    if (null !== $this->_order) {
                        $this->_sql .= ' ORDER BY ' . $this->_order;
                    }

                    // If there is a limit clause.
                    if (null !== $this->_limit) {
                        $this->_sql .= ' LIMIT ' . $this->_limit;
                    }

                    break;

                // Build an INSERT query.
                case 'INSERT':
                    $this->_sql = $this->_type . ' INTO ' . $this->_quoteId($this->_table) . ' ' . $this->_formatInsertValues();
                    break;

                // Build an UPDATE query.
                case 'UPDATE':
                    $this->_sql = $this->_type . ' ' . $this->_quoteId($this->_table) . ' SET ' . $this->_formatUpdateValues();

                    // If there is a where clause.
                    if (count($this->_where) > 0) {
                        $this->_sql .= ' WHERE ' . $this->_formatWhereConditions();
                    }

                    break;

                // Build a DELETE query.
                case 'DELETE':
                    $this->_sql = $this->_type . ' FROM ' . $this->_quoteId($this->_table);

                    // If there is a where clause.
                    if (count($this->_where) > 0) {
                        $this->_sql .= ' WHERE ' . $this->_formatWhereConditions();
                    }

                    break;
            }
        }

        return ($ret) ? $this->_sql : $this;
    }

    /**
     * Method to add quotes to the column values
     *
     * @param  array $columns
     * @return array
     */
    protected function _quote($columns)
    {
        $ary = array();

        foreach ($columns as $key => $value) {
            $k = $this->_quoteId($key);
            $quote = (($value == '?') || (substr($value, 0, 1) == ':') || (preg_match('/^\$\d*\d$/', $value) != 0)) ? null : "'";
            $v = $quote . $value . $quote;
            $ary[$k] = $v;
        }

        return $ary;
    }

    /**
     * Method to add id quotes to a column id
     *
     * @param  string $columns
     * @return string
     */
    protected function _quoteId($id)
    {
        $quotedId = null;

        if (strpos($id, '.') !== false) {
            $idAry = explode('.', $id);
            $quotedId = $this->getIdQuote() . $idAry[0] . $this->getIdQuote(true) . '.' . $this->getIdQuote() . $idAry[1] . $this->getIdQuote(true);
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
    protected function _formatInsertValues()
    {
        $sqlColumns = array();
        $sqlValues = array();

        foreach ($this->_insertColumns as $key => $value) {
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
    protected function _formatUpdateValues()
    {
        $sqlColumns = array();

        foreach ($this->_updateColumns as $key => $value) {
            $sqlColumns[] = $key . ' = ' . $value;
        }

        return implode(', ', $sqlColumns);
    }

    /**
     * Method to format where conditions
     *
     * @return string
     */
    protected function _formatWhereConditions()
    {
        $whereSql = null;

        for ($i = 0; $i < count($this->_where); $i++) {
            $whereSql .= '(' . $this->_where[$i]['column'] . ' ' . $this->_where[$i]['comparison'] . ' ' . $this->_where[$i]['value'] . ')';
            if ($i < (count($this->_where) - 1)) {
                $whereSql .= ' ' . $this->_where[$i]['conjunction'];
            }
        }

        return $whereSql;
    }

}
