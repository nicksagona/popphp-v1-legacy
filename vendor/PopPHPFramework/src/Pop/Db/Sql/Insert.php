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
 * Insert SQL class
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.3.0
 */
class Insert extends AbstractSql
{

    /**
     * Render the INSERT statement
     *
     * @return string
     */
    public function render()
    {
        // Start building the INSERT statement
        $sql = 'INSERT INTO ' . $this->sql->quoteId($this->sql->getTable()) . ' ';
        $columns = array();
        $values = array();

        foreach ($this->columns as $column => $value) {
            $columns[] = $this->sql->quoteId($column);
            $values[] = (null === $value) ? 'NULL' : $this->sql->quote($value);
        }

        $sql .= '(' . implode(', ', $columns) . ') VALUES ';
        $sql .= '(' . implode(', ', $values) . ')';

        return $sql;
    }

}
