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
 * @package    Pop_Record
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Record;

use Pop\Db\Db,
    Pop\Db\Sql;

/**
 * This is the Escaped class for the Record component.
 *
 * @category   Pop
 * @package    Pop_Record
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Escaped extends AbstractRecord
{

    /**
     * Constructor
     *
     * Instantiate the record escaped object.
     *
     * @param  Db $db
     * @param  array     $options
     * @return void
     */
    public function __construct(Db $db, $options)
    {
        $this->db = $db;

        $type = $this->db->getAdapterType();

        if (($type == 'Sqlite') || ($type == 'Pdo_Sqlite')) {
            $this->idQuote = (null === $this->idQuote) ? Sql::DOUBLE_QUOTE : $this->idQuote;
        } else if ($type == 'Pgsql') {
            $this->idQuote = (null === $this->idQuote) ? Sql::DOUBLE_QUOTE : $this->idQuote;
        } else {
            $this->idQuote = (null === $this->idQuote) ? Sql::BACKTICK : $this->idQuote;
        }

        $this->tableName = $options['tableName'];
        $this->primaryId = $options['primaryId'];
        $this->auto = $options['auto'];
    }

    /**
     * Find a database row by the primary ID passed through the method argument.
     *
     * @param  mixed $id
     * @param  int   $limit
     * @throws Exception
     * @return void
     */
    public function findById($id, $limit = null)
    {
        if (null === $this->primaryId) {
            throw new Exception('This primary ID of this table either is not set or does not exist.');
        }

        // Build the SQL.
        $this->db->sql->setTable($this->tableName)
                      ->setIdQuoteType($this->idQuote)
                      ->select();

        if (is_array($this->primaryId)) {
            if (!is_array($id) || (count($id) != count($this->primaryId))) {
                throw new Exception('The array of ID values does not match the number of IDs.');
            }
            foreach ($id as $key => $value) {
                $this->db->sql->where($this->primaryId[$key], '=', $this->db->adapter->escape($value));
            }
        } else {
            $this->db->sql->where($this->primaryId, '=', $this->db->adapter->escape($id));
        }

        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->getSql());

        // Set the return results.
        $this->setResults();
    }

    /**
     * Find a database row by the column passed through the method argument.
     *
     * @param  string $column
     * @param  int|string $value
     * @param  int|string $limit
     * @return void
     */
    public function findBy($column, $value, $limit = null)
    {
        $this->finder = array($column, $value);

        // Build the SQL.
        $this->db->sql->setTable($this->tableName)
                      ->setIdQuoteType($this->idQuote)
                      ->select()
                      ->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));

        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->getSql());

        // Set the return results.
        $this->setResults();
    }

    /**
     * Find all of the database rows by the column passed through the method argument.
     *
     * @param  string     $order
     * @param  string     $column
     * @param  int|string $value
     * @param  int|string $limit
     * @return void
     */
    public function findAll($order = null, $column = null, $value = null, $limit = null)
    {
        // Build the SQL.
        $this->db->sql->setTable($this->tableName)
                      ->setIdQuoteType($this->idQuote)
                      ->select();

        // If a specific column and value are passde.
        if ((null !== $column) && (null !== $value)) {
            $this->finder = array($column, $value);
            $this->db->sql->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));
        } else {
            $this->finder = array();
        }

        // Set the SQL query to a specific order, if given.
        if (null !== $order) {
            $ord = $this->getOrder($order);
            $this->db->sql->order($this->db->adapter->escape($ord['by']), $this->db->adapter->escape($ord['order']));
        }

        // Set any limit to the SQL query.
        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->getSql());

        // Set the return results.
        $this->setResults();
    }

    /**
     * Find singular and distinct entries in the database based on the search criteria.
     *
     * @param  string|array $distinctColumns
     * @param  string $order
     * @param  string $column
     * @param  int|string $value
     * @param  int|string $limit
     * @return void
     */
    public function distinct($distinctColumns, $order = null, $column = null, $value = null, $limit = null)
    {
        if (!is_array($distinctColumns)) {
            $distinctColumns = array($distinctColumns);
        }

        // Build the SQL.
        $this->db->sql->setTable($this->tableName)
                      ->setIdQuoteType($this->idQuote)
                      ->select($distinctColumns)->distinct();

        // If a specific column and value are passed.
        if ((null !== $column) && (null !== $value)) {
            $this->finder = array($column, $value);
            $this->db->sql->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));
        } else {
            $this->finder = array();
        }

        // Set the SQL query to a specific order, if given.
        if (null !== $order) {
            $ord = $this->getOrder($order);
            $this->db->sql->order($this->db->adapter->escape($ord['by']), $this->db->adapter->escape($ord['order']));
        }

        // Set any limit to the SQL query.
        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->getSql());

        // Set the return results.
        $this->setResults();
    }

    /**
     * Search the database for rows based on the search criteria.
     *
     * @param  array $searchColumns
     * @param  string $order
     * @param  int|string $limit
     * @return void
     */
    public function search($searchColumns, $order = null, $limit = null)
    {
        if (isset($searchColumns[0]) && !is_array($searchColumns[0])) {
            $searchColumns = array($searchColumns);
        }

        // Build the SQL.
        $this->db->sql->setTable($this->tableName)
                      ->setIdQuoteType($this->idQuote)
                      ->select();

        foreach ($searchColumns as $search) {
            if (isset($search[3])) {
                $this->db->sql->where($search[0], $search[1], $this->db->adapter->escape($search[2]), $search[3]);
            } else {
                $this->db->sql->where($search[0], $search[1], $this->db->adapter->escape($search[2]));
            }
        }

        // Set the SQL query to a specific order, if given.
        if (null !== $order) {
            $ord = $this->getOrder($order);
            $this->db->sql->order($this->db->adapter->escape($ord['by']), $this->db->adapter->escape($ord['order']));
        }

        // Set any limit to the SQL query.
        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->getSql());

        // Set the return results.
        $this->setResults();
    }

    /**
     * Join data from two tables that share a related column.
     *
     * @param  string $tableToJoin
     * @param  string $commonColumn
     * @param  string $order
     * @param  string $column
     * @param  int|string $value
     * @param  int|string $limit
     * @return void
     */
    public function join($tableToJoin, $commonColumn, $order = null, $column = null, $value = null, $limit = null)
    {
        // Build the SQL.
        $this->db->sql->setTable($this->tableName)
                      ->setIdQuoteType($this->idQuote)
                      ->select()
                      ->join($tableToJoin, $commonColumn, 'LEFT JOIN');

        // If a specific column and value are passed.
        if ((null !== $column) && (null !== $value)) {
            $this->finder = array($column, $value);
            $this->db->sql->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));
        } else {
            $this->finder = array();
        }

        // Set the SQL query to a specific order, if given.
        if (null !== $order) {
            $ord = $this->getOrder($order);
            $this->db->sql->order($this->tableName . '.' . $this->db->adapter->escape($ord['by']), $this->db->adapter->escape($ord['order']));
        }

        // Set any limit to the SQL query.
        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->getSql());

        // Set the return results.
        $this->setResults();
    }

    /**
     * Save the database record.
     *
     * @param  array $columnsPassed
     * @param  int   $type
     * @return void
     */
    public function save($columnsPassed, $type = Record::INSERT)
    {
        $this->columns = $columnsPassed;

        foreach ($this->columns as $key => $value) {
            $this->columns[$key] = $this->db->adapter->escape($value);
        }

        if (null === $this->primaryId) {
            if ($type == Record::UPDATE) {
                $this->db->sql->setTable($this->tableName)
                              ->setIdQuoteType($this->idQuote)
                              ->update((array)$this->columns);

                if (count($this->finder) > 0) {
                    $this->db->sql->where($this->finder[0], '=', $this->db->adapter->escape($this->finder[1]));
                }

                $this->db->adapter->query($this->db->sql->getSql());
            } else {
                $this->db->sql->setTable($this->tableName)
                              ->setIdQuoteType($this->idQuote)
                              ->insert((array)$this->columns);

                $this->db->adapter->query($this->db->sql->getSql());
            }
        } else {
            if ($this->auto == false) {
                $action = ($type == Record::INSERT) ? 'insert' : 'update';
            } else {
                if (is_array($this->primaryId)) {
                    $isset = true;
                    foreach ($this->primaryId as $value) {
                        if (!isset($this->columns[$value])) {
                            $isset = false;
                        }
                    }
                    $action = ($isset) ? 'update' : 'insert';
                } else {
                    $action = (isset($this->columns[$this->primaryId])) ? 'update' : 'insert';
                }
            }

            if ($action == 'update') {
                $this->db->sql->setTable($this->tableName)
                              ->setIdQuoteType($this->idQuote)
                              ->update((array)$this->columns);

                if (is_array($this->primaryId)) {
                    foreach ($this->primaryId as $value) {
                        $this->db->sql->where($this->db->adapter->escape($value), '=', $this->db->adapter->escape($this->columns[$value]));
                    }
                } else {
                    $this->db->sql->where($this->db->adapter->escape($this->primaryId), '=', $this->db->adapter->escape($this->columns[$this->primaryId]));
                }

                $this->db->adapter->query($this->db->sql->getSql());
            } else {
                $this->db->sql->setTable($this->tableName)
                              ->setIdQuoteType($this->idQuote)
                              ->insert((array)$this->columns);

                $this->db->adapter->query($this->db->sql->getSql());

                if ($this->auto) {
                    $this->columns[$this->primaryId] = $this->db->adapter->lastId();
                    $this->rows[0][$this->primaryId] = $this->db->adapter->lastId();
                }
            }
        }

        if (count($this->columns) > 0) {
            $this->rows[0] = $this->columns;
        }
    }

    /**
     * Delete the database record.
     *
     * @param  array  $columnsPassed
     * @param  string $column
     * @param  string $value
     * @throws Exception
     * @return void
     */
    public function delete($columnsPassed, $column = null, $value = null)
    {
        $this->columns = $columnsPassed;

        if (null === $this->primaryId) {
            if ((null === $column) && (null === $value) && (count($this->finder) == 0)) {
                throw new Exception('The column and value parameters were not defined to describe the row(s) to delete.');
            } else if ((null === $column) && (null === $value)) {
                $column = $this->finder[0];
                $value = $this->finder[1];
            }

            $this->db->sql->setTable($this->tableName)
                          ->setIdQuoteType($this->idQuote)
                          ->delete()
                          ->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));

            $this->db->adapter->query($this->db->sql->getSql());

            $this->columns = array();
            $this->rows = array();
        } else {
            $this->db->sql->setTable($this->tableName)
                          ->setIdQuoteType($this->idQuote)
                          ->delete();

            // Specific column override.
            if ((null !== $column) && (null !== $value)) {
                $this->db->sql->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));
            // Else, continue with the primaryId column(s)
            } else if (is_array($this->primaryId)) {
                foreach ($this->primaryId as $value) {
                    $this->db->sql->where($this->db->adapter->escape($value), '=', $this->db->adapter->escape($this->columns[$value]));
                }
            } else {
                $this->db->sql->where($this->db->adapter->escape($this->primaryId), '=', $this->db->adapter->escape($this->columns[$this->primaryId]));
            }

            $this->db->adapter->query($this->db->sql->getSql());

            $this->columns = array();
            $this->rows = array();
        }
    }

    /**
     * Execute a custom SQL query.
     *
     * @param  string $sql
     * @param  array  $params
     * @return void
     */
    public function execute($sql, $params = null)
    {
        $this->query($sql);
    }

    /**
     * Execute a custom SQL query.
     *
     * @param  string $sql
     * @return void
     */
    public function query($sql)
    {
        $this->db->adapter->query($sql);

        // Set the return results.
        if (stripos($sql, 'select') !== false) {
            $this->setResults();
        } else if (stripos($sql, 'delete') !== false) {
            $this->columns = array();
            $this->rows = array();
        }
    }

    /**
     * Set the query results.
     *
     * @return void
     */
    protected function setResults()
    {
        $this->rows = array();

        while (($row = $this->db->adapter->fetch()) != false) {
            $this->rows[] = new \ArrayObject($row, \ArrayObject::ARRAY_AS_PROPS);
        }

        if (isset($this->rows[0])) {
            $this->columns = $this->rows[0];
        }
    }

}
