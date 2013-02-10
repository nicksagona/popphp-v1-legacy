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
 * SQL Predicate collection class
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Predicate
{

    /**
     * SQL object
     * @var \Pop\Db\Sql
     */
    protected $sql = null;

    /**
     * Predicates array
     * @var array
     */
    protected $predicates = array();

    /**
     * Constructor
     *
     * Instantiate the predicate collection object.
     *
     * @param  \Pop\Db\Sql $sql
     * @return \Pop\Db\Sql\Predicate
     */
    public function __construct(\Pop\Db\Sql $sql)
    {
        $this->sql = $sql;
    }

    /**
     * Predicate for =
     *
     * @param  string $column
     * @param  string $value
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function equalTo($column, $value, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 = %2',
            'values' => array($column, $value),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for !=
     *
     * @param  string $column
     * @param  string $value
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function notEqualTo($column, $value, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 != %2',
            'values' => array($column, $value),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for >
     *
     * @param  string $column
     * @param  string $value
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function greaterThan($column, $value, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 > %2',
            'values' => array($column, $value),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for >=
     *
     * @param  string $column
     * @param  string $value
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function greaterThanOrEqualTo($column, $value, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 >= %2',
            'values' => array($column, $value),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for <
     *
     * @param  string $column
     * @param  string $value
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function lessThan($column, $value, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 < %2',
            'values' => array($column, $value),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for <=
     *
     * @param  string $column
     * @param  string $value
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function lessThanOrEqualTo($column, $value, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 <= %2',
            'values' => array($column, $value),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for LIKE
     *
     * @param  string $column
     * @param  string $value
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function like($column, $value, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 LIKE %2',
            'values' => array($column, $value),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for NOT LIKE
     *
     * @param  string $column
     * @param  string $value
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function notLike($column, $value, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 NOT LIKE %2',
            'values' => array($column, $value),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for BETWEEN
     *
     * @param  string $column
     * @param  string $value1
     * @param  string $value2
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function between($column, $value1, $value2, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 BETWEEN %2 AND %3',
            'values' => array($column, $value1, $value2),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for NOT BETWEEN
     *
     * @param  string $column
     * @param  string $value1
     * @param  string $value2
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function notBetween($column, $value1, $value2, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 NOT BETWEEN %2 AND %3',
            'values' => array($column, $value1, $value2),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for IN
     *
     * @param  string $column
     * @param  array  $values
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function in($column, array $values, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 IN (%2)',
            'values' => array($column, $values),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for NOT IN
     *
     * @param  string $column
     * @param  array  $values
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function notIn($column, array $values, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 NOT IN (%2)',
            'values' => array($column, $values),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for IS NULL
     *
     * @param  string $column
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function isNull($column, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 IS NULL',
            'values' => array($column),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate for IS NOT NULL
     *
     * @param  string $column
     * @param  string $combine
     * @return \Pop\Db\Sql\Predicate
     */
    public function isNotNull($column, $combine = 'AND')
    {
        $this->predicates[] = array(
            'format' => '%1 IS NOT NULL',
            'values' => array($column),
            'combine' => ($combine == 'OR') ? 'OR' : 'AND'
        );
        return $this;
    }

    /**
     * Predicate return string
     *
     * @return string
     */
    public function __toString()
    {
        $where = null;

        if (count($this->predicates) > 0) {
            foreach ($this->predicates as $key => $predicate) {
                $format = $predicate['format'];
                $curWhere = '(';
                for ($i = 0; $i < count($predicate['values']); $i++) {
                    if ($i == 0) {
                        $format = str_replace('%1', $this->sql->quoteId($predicate['values'][$i]), $format);
                    } else {
                        if (is_array($predicate['values'][$i])) {
                            $vals = $predicate['values'][$i];
                            foreach ($vals as $k => $v) {
                                $vals[$k] = $this->sql->quote($v);
                            }
                            $format = str_replace('%' . ($i + 1), implode(', ', $vals), $format);
                        } else {
                            $format = str_replace('%' . ($i + 1), $this->sql->quote($predicate['values'][$i]), $format);
                        }
                    }
                }
                $curWhere .= $format . ')';

                if ($key == 0) {
                    $where .= $curWhere;
                } else {
                    $where .= ' ' . $predicate['combine'] . ' ' . $curWhere;
                }
            }
        }

        return $where;
    }

}
