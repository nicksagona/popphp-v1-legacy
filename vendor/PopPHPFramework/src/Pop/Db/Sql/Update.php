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
 * Update SQL class
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.3
 */
class Update extends AbstractSql
{

    /**
     * WHERE predicate object
     * @var \Pop\Db\Sql\Predicate
     */
    protected $where = null;

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
     * Render the UPDATE statement
     *
     * @return string
     */
    public function render()
    {
        // Start building the UPDATE statement
        $sql = 'UPDATE ' . $this->sql->quoteId($this->sql->getTable()) . ' SET ';
        $set = array();

        foreach ($this->columns as $column => $value) {
            $val = (null === $value) ? 'NULL' : $this->sql->quote($value);
            $set[] = $this->sql->quoteId($column) .' = ' . $val;
        }

        $sql .= implode(', ', $set);

        // Build any WHERE clauses
        if (null !== $this->where) {
            $sql .= ' WHERE ' . $this->where;
        }

        // Build any ORDER BY clause
        if (null !== $this->orderBy) {
            $sql .= ' ORDER BY ' . $this->orderBy;
        }

        // Build any LIMIT clause
        if (null !== $this->limit) {
            $sql .= ' LIMIT ' . (int)$this->limit;
        }

        return $sql;
    }

}
