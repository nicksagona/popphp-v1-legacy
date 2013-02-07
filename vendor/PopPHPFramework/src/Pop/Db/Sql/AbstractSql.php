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
 * Abstract SQL class
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
abstract class AbstractSql
{

    /**
     * SQL object
     * @var \Pop\Db\Sql
     */
    protected $sql = null;

    /**
     * SQL values
     * @var array
     */
    protected $values = array();

    /**
     * Predicate collection
     * @var \Pop\Db\Sql\Predicate
     */
    protected $predicate = null;

    /**
     * Order value
     * @var string
     */
    protected $order = null;

    /**
     * Limit value
     * @var int|string
     */
    protected $limit = null;

    /**
     * Constructor
     *
     * Instantiate the SQL object.
     *
     * @param  \Pop\Db\Db $db
     * @param  string     $table
     * @return \Pop\Db\Sql
     */
    public function __construct($sql, array $values = null)
    {
        $this->sql = $sql;
        if (null !== $values) {
            $this->values = $values;
        }
    }

    /**
     * Set the database object
     *
     * @return \Pop\Db\Sql\Predicate
     */
    public function where()
    {
        if (null === $this->predicate) {
            $this->predicate = new Predicate();
        }

        return $this->predicate;
    }
    /**
     * Set the LIMIT value.
     *
     * @param  mixed $limit
     * @return \Pop\Db\Sql\AbstractSql
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Set the ORDER value.
     *
     * @param  string $by
     * @param  string $order
     * @return \Pop\Db\Sql\AbstractSql
     */
    public function order($by, $order = 'ASC')
    {
        $byColumns = null;

        if (strpos($by, ',') !== false) {
            $ary = explode(',' , $by);
            $quotedAry = array();
            foreach ($ary as $value) {
                $quotedAry[] = $this->sql->quoteId(trim($value));
            }
            $byColumns = implode(', ', $quotedAry);
        } else {
            $byColumns = trim($by);
        }

        $this->order = $byColumns;
        $order = strtoupper($order);

        if (strpos($order, 'RAND') !== false) {
            $this->order .= ($this->sql->getDbType() == \Pop\Db\Sql::SQLITE) ? ' RANDOM()' : ' RAND()';
        } else if (($order == 'ASC') || ($order == 'DESC')) {
            $this->order .= ' ' . $order;
        }

        return $this;
    }
}
