<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Db\Sql;

/**
 * Select SQL class
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Select extends AbstractSql
{
    /**
     * Allowed JOIN keywords
     * @var boolean
     */
    protected static $allowedJoins = array(
        'JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'FULL JOIN',
        'OUTER JOIN', 'LEFT OUTER JOIN', 'RIGHT OUTER JOIN', 'FULL OUTER JOIN',
        'INNER JOIN', 'LEFT INNER JOIN', 'RIGHT INNER JOIN', 'FULL INNER JOIN'
    );

    /**
     * Distinct keyword
     * @var boolean
     */
    protected $distinct = false;

    /**
     * JOIN clauses
     * @var array
     */
    protected $joins = array();

    /**
     * WHERE predicate object
     * @var \Pop\Db\Sql\Predicate
     */
    protected $where = null;

    /**
     * GROUP BY value
     * @var string
     */
    protected $groupBy = null;

    /**
     * HAVING predicate object
     * @var \Pop\Db\Sql\Predicate
     */
    protected $having = null;

    /**
     * Set the JOIN clause
     *
     * @param string $tableToJoin
     * @param string $commonColumn
     * @param string $typeOfJoin
     * @return \Pop\Db\Sql\Select
     */
    public function join($tableToJoin, $commonColumn, $typeOfJoin = 'JOIN')
    {
        $join = (in_array(strtoupper($typeOfJoin), self::$allowedJoins)) ? strtoupper($typeOfJoin) : 'JOIN';

        if (is_array($commonColumn)) {
            $col1 = $this->sql->quoteId($commonColumn[0]);
            $col2 = $this->sql->quoteId($commonColumn[1]);
            $cols = array($col1, $col2);
        } else {
            $cols = $this->sql->quoteId($commonColumn);
        }

        $this->joins[] = array(
            'tableToJoin' => $this->sql->quoteId($tableToJoin),
            'commonColumn' => $cols,
            'typeOfJoin'  => $join
        );

        return $this;
    }

    /**
     * Set the DISTINCT keyword
     *
     * @return \Pop\Db\Sql\Select
     */
    public function distinct()
    {
        $this->distinct = true;
        return $this;
    }

    /**
     * Set the WHERE clause
     *
     * @return \Pop\Db\Sql\Predicate
     */
    public function where()
    {
        if (null === $this->where) {
            $this->where = new Predicate($this->sql);
        }

        return $this->where;
    }

    /**
     * Set the GROUP BY value
     *
     * @param mixed $by
     * @return \Pop\Db\Sql\Select
     */
    public function groupBy($by)
    {
        $byColumns = null;

        if (is_array($by)) {
            $quotedAry = array();
            foreach ($by as $value) {
                $quotedAry[] = $this->sql->quoteId(trim($value));
            }
            $byColumns = implode(', ', $quotedAry);
        } else if (strpos($by, ',') !== false) {
            $ary = explode(',' , $by);
            $quotedAry = array();
            foreach ($ary as $value) {
                $quotedAry[] = $this->sql->quoteId(trim($value));
            }
            $byColumns = implode(', ', $quotedAry);
        } else {
            $byColumns = $this->sql->quoteId(trim($by));
        }

        $this->groupBy = $byColumns;
        return $this;
    }

    /**
     * Set the HAVING clause
     *
     * @return \Pop\Db\Sql\Predicate
     */
    public function having()
    {
        if (null === $this->having) {
            $this->having = new Predicate($this->sql);
        }

        return $this->having;
    }

    /**
     * Render the SELECT statement
     *
     * @throws Exception
     * @return string
     */
    public function render()
    {
        // Start building the SELECT statement
        $sql = 'SELECT ' . (($this->distinct) ? 'DISTINCT ' : null);

        if (count($this->columns) > 0) {
            $cols = array();
            foreach ($this->columns as $as => $col) {
                if (!is_numeric($as)) {
                    $cols[] = $this->sql->quoteId($col) . ' AS ' . $this->sql->quoteId($as);
                } else {
                    $cols[] = $this->sql->quoteId($col);
                }
            }
            $sql .= implode(', ', $cols) . ' ';
        } else {
            $sql .= '* ';
        }

        $sql .= 'FROM ';

        // Account for LIMIT clause if the database is ORACLE
        if (($this->sql->getDbType() == \Pop\Db\Sql::ORACLE) && ((null !== $this->limit) || (null !== $this->offset))) {
            if (null === $this->orderBy) {
                throw new Exception('Error: You must set an order by clause to execute a limit clause on the Oracle database.');
            }

            $limit = null;
            $offset = null;

            // Calculate the limit and/or offset
            if (null !== $this->offset) {
                $offset = (int)$this->offset + 1;
                $limit = (null !== $this->limit) ? (int)$this->limit + (int)$this->offset : 0;
            } else if (strpos($this->limit, ',') !== false) {
                $limAry  = explode(',', $this->limit);
                $offset = (int)trim($limAry[0]) + 1;
                $limit = (int)trim($limAry[1]) + (int)trim($limAry[0]);
            } else {
                $limit = (int)$this->limit;
            }

            $sql .= '(SELECT t.*, ROW_NUMBER() OVER (ORDER BY ' . $this->orderBy . ') ' .
                $this->sql->quoteId('RowNumber') . ' FROM ' .
                $this->sql->quoteId($this->sql->getTable()) . ' t)';

            if (null !== $offset) {
                if ($limit > 0) {
                    $this->where()->between('RowNumber', $offset, $limit);
                } else {
                    $this->where()->greaterThanOrEqualTo('RowNumber', $offset);
                }
            } else {
                $this->where()->lessThanOrEqualTo('RowNumber', $limit);
            }
        // Account for LIMIT clause if the database is SQLSRV
        } else if (($this->sql->getDbType() == \Pop\Db\Sql::SQLSRV) && ((null !== $this->limit) || (null !== $this->offset))) {
            if (null === $this->orderBy) {
                throw new Exception('Error: You must set an order by clause to execute a limit clause on the SQL server database.');
            }

            $limit = null;
            $offset = null;

            // Calculate the limit and/or offset
            if (null !== $this->offset) {
                $offset = (int)$this->offset + 1;
                $limit = (null !== $this->limit) ? (int)$this->limit + (int)$this->offset : 0;
            } else if (strpos($this->limit, ',') !== false) {
                $limAry  = explode(',', $this->limit);
                $offset = (int)trim($limAry[0]) + 1;
                $limit = (int)trim($limAry[1]) + (int)trim($limAry[0]);
            } else {
                $limit = (int)$this->limit;
            }

            if (null !== $offset) {
                $sql .= '(SELECT *, ROW_NUMBER() OVER (ORDER BY ' . $this->orderBy . ') AS RowNumber FROM ' .
                    $this->sql->quoteId($this->sql->getTable()) . ') AS OrderedTable';
                if ($limit > 0) {
                    $this->where()->between('OrderedTable.RowNumber', $offset, $limit);
                } else {
                    $this->where()->greaterThanOrEqualTo('OrderedTable.RowNumber', $offset);
                }
            } else {
                $sql = str_replace('SELECT', 'SELECT TOP ' . $limit, $sql);
                $sql .= $this->sql->quoteId($this->sql->getTable());
            }
        // If there is a nested SELECT statement.
        } else if ($this->sql->getTable() instanceof \Pop\Db\Sql) {
            $subSelect = $this->sql->getTable();
            $subSelectAlias = ($subSelect->hasAlias()) ? $subSelect->getAlias() : $subSelect->getTable();
            $sql .= '(' . $subSelect . ') AS ' . $this->sql->quoteId($subSelectAlias);
        // Else, select from the table
        } else {
            $sql .=  $this->sql->quoteId($this->sql->getTable());
        }

        // Build any JOIN clauses
        if (count($this->joins) > 0) {
            foreach ($this->joins as $join) {
                if (is_array($join['commonColumn'])) {
                    $col1 = $join['commonColumn'][0];
                    $col2 = $join['commonColumn'][1];
                } else {
                    $col1 = $join['commonColumn'];
                    $col2 = $join['commonColumn'];
                }
                $sql .= ' ' . $join['typeOfJoin'] . ' ' .
                    $join['tableToJoin'] . ' ON ' .
                    $this->sql->quoteId($this->sql->getTable()) . '.' . $col1 . ' = ' . $join['tableToJoin'] . '.' . $col2;
            }
        }

        // Build any WHERE clauses
        if (null !== $this->where) {
            $sql .= ' WHERE ' . $this->where;
        }

        // Build any GROUP BY clause
        if (null !== $this->groupBy) {
            $sql .= ' GROUP BY ' . $this->groupBy;
        }

        // Build any HAVING clause
        if (null !== $this->groupBy) {
            $sql .= ' HAVING ' . $this->having;
        }

        // Build any ORDER BY clause
        if (null !== $this->orderBy) {
            $sql .= ' ORDER BY ' . $this->orderBy;
        }

        // Build any LIMIT clause for all other database types.
        if (($this->sql->getDbType() != \Pop\Db\Sql::SQLSRV) && ($this->sql->getDbType() != \Pop\Db\Sql::ORACLE)) {
            if (null !== $this->limit) {
                $sql .= ' LIMIT ' . $this->limit;
            }
        }

        // Build any OFFSET clause for all other database types.
        if (($this->sql->getDbType() != \Pop\Db\Sql::SQLSRV) && ($this->sql->getDbType() != \Pop\Db\Sql::ORACLE)) {
            if (null !== $this->offset) {
                $sql .= ' OFFSET ' . $this->offset;
            }
        }

        return $sql;
    }

}
