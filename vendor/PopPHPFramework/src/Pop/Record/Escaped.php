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
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @category   Pop
 * @package    Pop_Record
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */

/**
 * @namespace
 */
namespace Pop\Record;
use Pop\Db\Db,
    Pop\Db\Sql,
    Pop\Locale\Locale,
    Pop\Record\AbstractRecord;

class Escaped extends AbstractRecord
{

    /**
     * Constructor
     *
     * Instantiate the record escaped object.
     *
     * @param  Pop_Db $db
     * @param  array    $options
     * @return void
     */
    public function __construct(Db $db, $options)
    {
        $this->_lang = new Locale();
        $this->db = $db;

        $type = $this->db->getAdapterType();

        if (($type == 'Sqlite') || ($type == 'Pdo_Sqlite')) {
            $this->_idQuote = (null === $this->_idQuote) ? Sql::DOUBLE_QUOTE : $this->_idQuote;
        } else if ($type == 'Pgsql') {
            $this->_idQuote = (null === $this->_idQuote) ? Sql::DOUBLE_QUOTE : $this->_idQuote;
        } else {
            $this->_idQuote = (null === $this->_idQuote) ? Sql::BACKTICK : $this->_idQuote;
        }

        $this->_tableName = $options['tableName'];
        $this->_primaryId = $options['primaryId'];
        $this->_auto = $options['auto'];
    }

    /**
     * Find a database row by the primary ID passed through the method argument.
     *
     * @param  int|string $id
     * @param  int|string $limit
     * @throws Exception
     * @return void
     */
    public function findById($id, $limit = null)
    {
        if (null === $this->_primaryId) {
            throw new Exception($this->_lang->__('This primary ID of this table either is not set or does not exist.'));
        } else {
            // Build the SQL.
            $this->db->sql->setTable($this->_tableName)
                          ->setIdQuoteType($this->_idQuote)
                          ->select()
                          ->where($this->_primaryId, '=', $this->db->adapter->escape($id));

            if (null !== $limit) {
                $this->db->sql->limit($this->db->adapter->escape((int)$limit));
            }

            $this->db->adapter->query($this->db->sql->buildSql(true));

            // Set the return results.
            $this->_setResults();
        }
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
        $this->_finder = array($column, $value);

        // Build the SQL.
        $this->db->sql->setTable($this->_tableName)
                      ->setIdQuoteType($this->_idQuote)
                      ->select()
                      ->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));

        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->buildSql(true));

        // Set the return results.
        $this->_setResults();
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
        $this->db->sql->setTable($this->_tableName)
                      ->setIdQuoteType($this->_idQuote)
                      ->select();

        // If a specific column and value are passde.
        if ((null !== $column) && (null !== $value)) {
            $this->_finder = array($column, $value);
            $this->db->sql->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));
        } else {
            $this->_finder = array();
        }

        // Set the SQL query to a specific order, if given.
        if (null !== $order) {
            $ord = $this->_getOrder($order);
            $this->db->sql->order($this->db->adapter->escape($ord['by']), $this->db->adapter->escape($ord['order']));
        }

        // Set any limit to the SQL query.
        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->buildSql(true));

        // Set the return results.
        $this->_setResults();
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
        $this->db->sql->setTable($this->_tableName)
                      ->setIdQuoteType($this->_idQuote)
                      ->select($distinctColumns)->distinct();

        // If a specific column and value are passed.
        if ((null !== $column) && (null !== $value)) {
            $this->_finder = array($column, $value);
            $this->db->sql->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));
        } else {
            $this->_finder = array();
        }

        // Set the SQL query to a specific order, if given.
        if (null !== $order) {
            $ord = $this->_getOrder($order);
            $this->db->sql->order($this->db->adapter->escape($ord['by']), $this->db->adapter->escape($ord['order']));
        }

        // Set any limit to the SQL query.
        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->buildSql(true));

        // Set the return results.
        $this->_setResults();
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
        $this->db->sql->setTable($this->_tableName)
                      ->setIdQuoteType($this->_idQuote)
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
            $ord = $this->_getOrder($order);
            $this->db->sql->order($this->db->adapter->escape($ord['by']), $this->db->adapter->escape($ord['order']));
        }

        // Set any limit to the SQL query.
        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->buildSql(true));

        // Set the return results.
        $this->_setResults();
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
        $this->db->sql->setTable($this->_tableName)
                      ->setIdQuoteType($this->_idQuote)
                      ->select()
                      ->join($tableToJoin, $commonColumn, 'LEFT JOIN');

        // If a specific column and value are passed.
        if ((null !== $column) && (null !== $value)) {
            $this->_finder = array($column, $value);
            $this->db->sql->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));
        } else {
            $this->_finder = array();
        }

        // Set the SQL query to a specific order, if given.
        if (null !== $order) {
            $ord = $this->_getOrder($order);
            $this->db->sql->order($this->_tableName . '.' . $this->db->adapter->escape($ord['by']), $this->db->adapter->escape($ord['order']));
        }

        // Set any limit to the SQL query.
        if (null !== $limit) {
            $this->db->sql->limit($this->db->adapter->escape((int)$limit));
        }

        $this->db->adapter->query($this->db->sql->buildSql(true));

        // Set the return results.
        $this->_setResults();
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
        $this->_columns = $columnsPassed;

        foreach ($this->_columns as $key => $value) {
            $this->_columns[$key] = $this->db->adapter->escape($value);
        }

        if (null === $this->_primaryId) {
            if ($type == Record::UPDATE) {
                $this->db->sql->setTable($this->_tableName)
                              ->setIdQuoteType($this->_idQuote)
                              ->update($this->_columns);

                if (count($this->_finder) > 0) {
                    $this->db->sql->where($this->_finder[0], '=', $this->db->adapter->escape($this->_finder[1]));
                }

                $this->db->adapter->query($this->db->sql->buildSql(true));
            } else {
                $this->db->sql->setTable($this->_tableName)
                              ->setIdQuoteType($this->_idQuote)
                              ->insert($this->_columns);

                $this->db->adapter->query($this->db->sql->buildSql(true));
            }
        } else {
            if ($this->_auto == false) {
                $action = ($type == Record::INSERT) ? 'insert' : 'update';
            } else {
                $action = (isset($this->_columns[$this->_primaryId])) ? 'update' : 'insert';
            }

            if ($action == 'update') {
                $this->db->sql->setTable($this->_tableName)
                              ->setIdQuoteType($this->_idQuote)
                              ->update($this->_columns)
                              ->where($this->_primaryId, '=', $this->db->adapter->escape($this->_columns[$this->_primaryId]));

                $this->db->adapter->query($this->db->sql->buildSql(true));
            } else {
                $this->db->sql->setTable($this->_tableName)
                              ->setIdQuoteType($this->_idQuote)
                              ->insert($this->_columns);

                $this->db->adapter->query($this->db->sql->buildSql(true));

                if ($this->_auto) {
                    $this->_columns[$this->_primaryId] = $this->db->adapter->lastId();
                    $this->_rows[0][$this->_primaryId] = $this->db->adapter->lastId();
                }
            }
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
        $this->_columns = $columnsPassed;

        if (null === $this->_primaryId) {
            if ((null === $column) && (null === $value)) {
                throw new Exception($this->_lang->__('The column and value parameters were not defined to describe the row(s) to delete.'));
            } else {
                $this->db->sql->setTable($this->_tableName)
                              ->setIdQuoteType($this->_idQuote)
                              ->delete()
                              ->where($this->db->adapter->escape($column), '=', $this->db->adapter->escape($value));

                $this->db->adapter->query($this->db->sql->buildSql(true));

                $this->_columns = array();
                $this->_rows = array();
            }
        } else {
            $this->db->sql->setTable($this->_tableName)
                          ->setIdQuoteType($this->_idQuote)
                          ->delete()
                          ->where($this->db->adapter->escape($this->_primaryId), '=', $this->db->adapter->escape($this->_columns[$this->_primaryId]));

            $this->db->adapter->query($this->db->sql->buildSql(true));

            $this->_columns = array();
            $this->_rows = array();
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
            $this->_setResults();
        } else if (stripos($sql, 'delete') !== false) {
            $this->_columns = array();
            $this->_rows = array();
        }
    }

    /**
     * Set the query results.
     *
     * @return void
     */
    protected function _setResults()
    {
        $this->_rows = array();

        while (($row = $this->db->adapter->fetch()) != false) {
            $this->_rows[] = new \ArrayObject($row, \ArrayObject::ARRAY_AS_PROPS);
        }
    }

}
