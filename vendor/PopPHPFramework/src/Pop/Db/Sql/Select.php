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
     * Distinct keyword
     * @var boolean
     */
    protected $distinct = false;

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
     * @return string
     */
    public function render()
    {
        $sql = 'SELECT ' . (($this->distinct) ? 'DISTINCT ' : null);

        if (count($this->columns) > 0) {
            $cols = array();
            foreach ($this->columns as $col) {
                $cols[] = $this->sql->quoteId($col);
            }
            $sql .= implode(', ', $cols) . ' ';
        } else {
            $sql .= '* ';
        }

        $sql .= 'FROM ' . $this->sql->quoteId($this->sql->getTable());

        if (null !== $this->where) {
            $sql .= ' WHERE ' . $this->where;
        }
        if (null !== $this->orderBy) {
            $sql .= ' ORDER BY ' . $this->orderBy;
        }
        if (null !== $this->limit) {
            $sql .= ' LIMIT ' . $this->limit;
        }
        if (null !== $this->offset) {
            $sql .= ' OFFSET ' . $this->offset;
        }

        return $sql;
    }

}
