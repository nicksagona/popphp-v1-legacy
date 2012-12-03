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
 * This is the Prepared class for the Record component.
 *
 * @category   Pop
 * @package    Pop_Record
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.3
 */
class Prepared extends AbstractRecord
{

    /**
     * Prepared statement placeholder
     * @var boolean
     */
    protected $placeholder = null;

    /**
     * Constructor
     *
     * Instantiate the record escaped object.
     *
     * @param  Db $db
     * @param  array    $options
     * @return void
     */
    public function __construct(Db $db, $options)
    {
        $this->db = $db;

        $type = $this->db->getAdapterType();

        if (stripos($type, 'sqlite') !== false) {
            $this->placeholder = ':';
            $this->idQuote = (null === $options['idQuote']) ? Sql::DOUBLE_QUOTE : $options['idQuote'];
            $this->db->sql()->setDbType(Sql::SQLITE);
        } else if (stripos($type, 'pgsql') !== false) {
            $this->placeholder = '$';
            $this->idQuote = (null === $options['idQuote']) ? Sql::DOUBLE_QUOTE : $options['idQuote'];
            $this->db->sql()->setDbType(Sql::PGSQL);
        } else if (stripos($type, 'sqlsrv') !== false) {
            $this->placeholder = '?';
            $this->idQuote = (null === $options['idQuote']) ? Sql::BRACKET : $options['idQuote'];
            $this->db->sql()->setDbType(Sql::SQLSRV);
        } else if (stripos($type, 'oracle') !== false) {
            $this->placeholder = ':';
            $this->idQuote = (null === $options['idQuote']) ? Sql::DOUBLE_QUOTE : $options['idQuote'];
            $this->db->sql()->setDbType(Sql::ORACLE);
        } else {
            $this->placeholder = '?';
            $this->idQuote = (null === $options['idQuote']) ? Sql::BACKTICK : $options['idQuote'];
            $this->db->sql()->setDbType(Sql::MYSQL);
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
        $this->db->sql()->setTable($this->tableName)
                      ->setIdQuoteType($this->idQuote)
                      ->select();
                      //->where($this->primaryId, '=', $this->getPlaceholder($this->primaryId));

        if (is_array($this->primaryId)) {
            if (!is_array($id) || (count($id) != count($this->primaryId))) {
                throw new Exception('The array of ID values does not match the number of IDs.');
            }
            foreach ($id as $key => $value) {
                $this->db->sql()->where($this->primaryId[$key], '=', $this->getPlaceholder($this->primaryId[$key], ($key + 1)));
            }
        } else {
            $this->db->sql()->where($this->primaryId, '=', $this->getPlaceholder($this->primaryId));
        }

        if (null !== $limit) {
            $this->db->sql()->limit($this->db->adapter()->escape($limit));
        }

        $this->db->adapter()->prepare($this->db->sql()->getSql());

        if (is_array($this->primaryId)) {
            $params = array();
            foreach ($id as $key => $value) {
                $params[$this->primaryId[$key]] = $value;
            }
        } else {
            $params = array($this->primaryId => $id);
        }

        $this->db->adapter()->bindParams($params);
        $this->db->adapter()->execute();

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
        $this->db->sql()->setTable($this->tableName)
                      ->setIdQuoteType($this->idQuote)
                      ->select()
                      ->where($column, '=', $this->getPlaceholder($column));

        if (null !== $limit) {
            $this->db->sql()->limit($this->db->adapter()->escape($limit));
        }

        $this->db->adapter()->prepare($this->db->sql()->getSql());
        $this->db->adapter()->bindParams(array($column => $value));
        $this->db->adapter()->execute();

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
        $this->db->sql()->setTable($this->tableName)
                      ->setIdQuoteType($this->idQuote)
                      ->select();

        // If a specific column and value are passde.
        if ((null !== $column) && (null !== $value)) {
            $this->finder = array($column, $value);
            $this->db->sql()->where($column, '=', $this->getPlaceholder($column));
        } else {
            $this->finder = array();
        }

        // Set the SQL query to a specific order, if given.
        if (null !== $order) {
            $ord = $this->getOrder($order);
            if (is_array($ord['by'])) {
                $by = array();
                foreach ($ord['by'] as $b) {
                    $by[] = $this->db->adapter()->escape($b);
                }
            } else {
                $by = $this->db->adapter()->escape($ord['by']);
            }
            $this->db->sql()->order($by, $this->db->adapter()->escape($ord['order']));
        }

        // Set any limit to the SQL query.
        if (null !== $limit) {
            $this->db->sql()->limit($this->db->adapter()->escape($limit));
        }

        $this->db->adapter()->prepare($this->db->sql()->getSql());
        if ((null !== $column) && (null !== $value)) {
            $this->db->adapter()->bindParams(array($column => $value));
        }
        $this->db->adapter()->execute();

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

        if (null === $this->primaryId) {
            if ($type == Record::UPDATE) {
                $this->db->sql()->setTable($this->tableName)
                              ->setIdQuoteType($this->idQuote);

                if (count($this->finder) > 0) {
                    $columns = array();
                    $params = $this->columns;
                    $i = 1;
                    foreach ($this->columns as $key => $value) {
                        if ($key != $this->finder[0]) {
                            $columns[$key] = $this->getPlaceholder($key, $i);
                            $i++;
                        }
                    }
                    if (isset($params[$this->finder[0]])) {
                        $val = $params[$this->finder[0]];
                        unset($params[$this->finder[0]]);
                    }
                    $params[$this->finder[0]] = $val;
                    $this->db->sql()->update((array)$columns)
                                  ->where($this->finder[0], '=', $this->getPlaceholder($this->finder[0], $i));
                    $this->db->adapter()->prepare($this->db->sql()->getSql());
                    $this->db->adapter()->bindParams($params);
                } else {
                    $columns = array();
                    $i = 1;
                    foreach ($this->columns as $key => $value) {
                        $columns[$key] = $this->getPlaceholder($key, $i);
                        $i++;
                    }
                    $this->db->sql()->update((array)$columns);
                    $this->db->adapter()->prepare($this->db->sql()->getSql());
                    $this->db->adapter()->bindParams($this->columns);
                }
                $this->db->adapter()->execute();
            } else {
                $this->db->sql()->setTable($this->tableName)
                              ->setIdQuoteType($this->idQuote);

                $columns = array();
                $i = 1;
                foreach ($this->columns as $key => $value) {
                    $columns[$key] = $this->getPlaceholder($key, $i);
                    $i++;
                }
                $this->db->sql()->insert((array)$columns);
                $this->db->adapter()->prepare($this->db->sql()->getSql());
                $this->db->adapter()->bindParams($this->columns);
                $this->db->adapter()->execute();
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
                $this->db->sql()->setTable($this->tableName)
                              ->setIdQuoteType($this->idQuote);

                $columns = array();
                $params = $this->columns;

                $i = 1;
                foreach ($this->columns as $key => $value) {
                    if (is_array($this->primaryId)) {
                        if (!in_array($key, $this->primaryId)) {
                            $columns[$key] = $this->getPlaceholder($key, $i);
                            $i++;
                        }
                    } else {
                        if ($key != $this->primaryId) {
                            $columns[$key] = $this->getPlaceholder($key, $i);
                            $i++;
                        }
                    }
                }

                $this->db->sql()->update((array)$columns);

                if (is_array($this->primaryId)) {
                    foreach ($this->primaryId as $key => $value) {
                        if (isset($params[$value])) {
                            $id = $params[$value];
                            unset($params[$value]);
                        } else {
                            $id = $params[$value];
                        }
                        $params[$value] = $id;
                        $this->db->sql()->where($value, '=', $this->getPlaceholder($value, ($i + $key + 1)));
                    }
                } else {
                    if (isset($params[$this->primaryId])) {
                        $id = $params[$this->primaryId];
                        unset($params[$this->primaryId]);
                    } else {
                        $id = $params[$this->primaryId];
                    }
                    $params[$this->primaryId] = $id;
                    $this->db->sql()->where($this->primaryId, '=', $this->getPlaceholder($this->primaryId, $i));
                }

                $this->db->adapter()->prepare($this->db->sql()->getSql());
                $this->db->adapter()->bindParams($params);
                $this->db->adapter()->execute();
            } else {
                $this->db->sql()->setTable($this->tableName)
                              ->setIdQuoteType($this->idQuote);

                $columns = array();
                $i = 1;

                foreach ($this->columns as $key => $value) {
                    $columns[$key] = $this->getPlaceholder($key, $i);
                    $i++;
                }

                $this->db->sql()->insert((array)$columns);
                $this->db->adapter()->prepare($this->db->sql()->getSql());
                $this->db->adapter()->bindParams($this->columns);
                $this->db->adapter()->execute();

                if ($this->auto) {
                    $this->columns[$this->primaryId] = $this->db->adapter()->lastId();
                    $this->rows[0][$this->primaryId] = $this->db->adapter()->lastId();
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

            $this->db->sql()->setTable($this->tableName)
                          ->setIdQuoteType($this->idQuote)
                          ->delete()
                          ->where($this->db->adapter()->escape($column), '=', $this->getPlaceholder($column));

            $this->db->adapter()->prepare($this->db->sql()->getSql());
            $this->db->adapter()->bindParams(array($column => $value));
            $this->db->adapter()->execute();

            $this->columns = array();
            $this->rows = array();
        } else {
            $this->db->sql()->setTable($this->tableName)
                          ->setIdQuoteType($this->idQuote)
                          ->delete();

            // Specific column override.
            if ((null !== $column) && (null !== $value)) {
                $this->db->sql()->where($this->db->adapter()->escape($column), '=', $this->getPlaceholder($column));
            // Else, continue with the primaryId column(s)
            } else if (is_array($this->primaryId)) {
                foreach ($this->primaryId as $key => $value) {
                    $this->db->sql()->where($this->db->adapter()->escape($value), '=', $this->getPlaceholder($value, ($key + 1)));
                }
            } else {
                $this->db->sql()->where($this->db->adapter()->escape($this->primaryId), '=', $this->getPlaceholder($this->primaryId));
            }

            $this->db->adapter()->prepare($this->db->sql()->getSql());

            //Specific column override.
            if ((null !== $column) && (null !== $value)) {
                $params = array($column => $value);
            // Else, continue with the primaryId column(s)
            } else if (is_array($this->primaryId)) {
                $params = array();
                foreach ($this->primaryId as $value) {
                    $params[$value] = $this->columns[$value];
                }
            } else {
                $params = array($this->primaryId => $this->columns[$this->primaryId]);
            }

            $this->db->adapter()->bindParams($params);
            $this->db->adapter()->execute();

            $this->columns = array();
            $this->rows = array();
        }
    }

    /**
     * Execute a custom prepared SQL query.
     *
     * @param  string $sql
     * @param  array  $params
     * @return void
     */
    public function execute($sql, $params = null)
    {
        $this->db->adapter()->prepare($sql);

        if ((null !== $params) && is_array($params)) {
            $this->db->adapter()->bindParams($params);
        }

        $this->db->adapter()->execute();

        // Set the return results.
        if (stripos($sql, 'select') !== false) {
            $this->setResults();
        } else if (stripos($sql, 'delete') !== false) {
            $this->columns = array();
            $this->rows = array();
        }
    }

    /**
     * Execute a custom SQL query.
     *
     * @param  string $sql
     * @return void
     */
    public function query($sql)
    {
        $this->db->adapter()->query($sql);

        // Set the return results.
        if (stripos($sql, 'select') !== false) {
            // If there is more than one result returned, create an array of results.
            if ($this->db->adapter()->numRows() > 1) {
                while (($row = $this->db->adapter()->fetch()) != false) {
                    $this->rows[] = new \ArrayObject($row, \ArrayObject::ARRAY_AS_PROPS);
                }
            // Else, set the _columns array to the single returned result.
            } else {
                while (($row = $this->db->adapter()->fetch()) != false) {
                    $this->rows[0] = new \ArrayObject($row, \ArrayObject::ARRAY_AS_PROPS);
                }
            }
        } else if (stripos($sql, 'delete') !== false) {
            $this->columns = array();
            $this->rows = array();
        }
    }

    /**
     * Get the placeholder for a prepared statement
     *
     * @param  string $column
     * @param  int    $i
     * @return string
     */
    protected function getPlaceholder($column, $i = 1)
    {
        $placeholder =  $this->placeholder;

        if ($this->placeholder == ':') {
            $placeholder .= $column;
        } else if ($this->placeholder == '$') {
            $placeholder .= $i;
        }

        return $placeholder;
    }

    /**
     * Set the query results.
     *
     * @return void
     */
    protected function setResults()
    {
        $this->rows = array();

        $rows = $this->db->adapter()->fetchResult();
        foreach ($rows as $row) {
            $this->rows[] = new \ArrayObject($row, \ArrayObject::ARRAY_AS_PROPS);
        }

        if (isset($this->rows[0])) {
            $this->columns = $this->rows[0];
        }
    }

}
