<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Record
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Record\Adapter;

use Pop\Db\Sql;

/**
 * Escaped record adapter class
 *
 * @category   Pop
 * @package    Pop_Record
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Escaped extends AbstractRecord
{

    /**
     * Constructor
     *
     * Instantiate the record escaped object.
     *
     * @param  \Pop\Db\Db $db
     * @param  array      $options
     * @return \Pop\Record\Adapter\Escaped
     */
    public function __construct(\Pop\Db\Db $db, $options)
    {
        $this->db = $db;

        $type = $this->db->getAdapterType();


        if (stripos($type, 'sqlite') !== false) {
            $this->idQuote = (null === $options['idQuote']) ? Sql::DOUBLE_QUOTE : $options['idQuote'];
            $this->db->sql()->setDbType(Sql::SQLITE);
        } else if (stripos($type, 'pgsql') !== false) {
            $this->idQuote = (null === $options['idQuote']) ? Sql::DOUBLE_QUOTE : $options['idQuote'];
            $this->db->sql()->setDbType(Sql::PGSQL);
        } else if (stripos($type, 'sqlsrv') !== false) {
            $this->idQuote = (null === $options['idQuote']) ? Sql::BRACKET : $options['idQuote'];
            $this->db->sql()->setDbType(Sql::SQLSRV);
        } else if (stripos($type, 'oracle') !== false) {
            $this->idQuote = (null === $options['idQuote']) ? Sql::DOUBLE_QUOTE : $options['idQuote'];
            $this->db->sql()->setDbType(Sql::ORACLE);
        } else {
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

        if (is_array($this->primaryId)) {
            if (!is_array($id) || (count($id) != count($this->primaryId))) {
                throw new Exception('The array of ID values does not match the number of IDs.');
            }
            foreach ($id as $key => $value) {
                $this->db->sql()->where($this->primaryId[$key], '=', $this->db->adapter()->escape($value));
            }
        } else {
            $this->db->sql()->where($this->primaryId, '=', $this->db->adapter()->escape($id));
        }

        if (null !== $limit) {
            $this->db->sql()->limit($this->db->adapter()->escape($limit));
        }

        $this->db->adapter()->query($this->db->sql()->getSql());

        // Set the return results.
        $this->setResults();
    }

    /**
     * Find a database row by the column passed through the method argument.
     *
     * @param  array $columns
     * @param  string $order
     * @param  int   $limit
     * @return void
     */
    public function findBy(array $columns, $order = null, $limit = null)
    {
        $this->finder = array_merge($this->finder, $columns);

        // Build the SQL.
        $this->db->sql()->setTable($this->tableName)
                        ->setIdQuoteType($this->idQuote)
                        ->select();

        foreach ($columns as $key => $value) {
            $this->db->sql()->where($this->db->adapter()->escape($key), '=', $this->db->adapter()->escape($value));
        }

        if (null !== $limit) {
            $this->db->sql()->limit($this->db->adapter()->escape($limit));
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

        $this->db->adapter()->query($this->db->sql()->getSql());

        // Set the return results.
        $this->setResults();
    }

    /**
     * Find all of the database rows by the column passed through the method argument.
     *
     * @param  string     $order
     * @param  array      $columns
     * @param  int|string $limit
     * @return void
     */
    public function findAll($order = null, array $columns = null, $limit = null)
    {
        // Build the SQL.
        $this->db->sql()->setTable($this->tableName)
                        ->setIdQuoteType($this->idQuote)
                        ->select();

        // If a specific column and value are passde.
        if (null !== $columns) {
            $this->finder = array_merge($this->finder, $columns);
            foreach ($columns as $key => $value) {
                $this->db->sql()->where($this->db->adapter()->escape($key), '=', $this->db->adapter()->escape($value));
            }
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

        $this->db->adapter()->query($this->db->sql()->getSql());

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
    public function save($columnsPassed, $type = \Pop\Record\Record::INSERT)
    {
        $this->columns = $columnsPassed;

        foreach ($this->columns as $key => $value) {
            $this->columns[$key] = $this->db->adapter()->escape($value);
        }

        if (null === $this->primaryId) {
            if ($type == \Pop\Record\Record::UPDATE) {
                $this->db->sql()->setTable($this->tableName)
                                ->setIdQuoteType($this->idQuote)
                                ->update((array)$this->columns);

                if (count($this->finder) > 0) {
                    foreach ($this->finder as $key => $value) {
                        $this->db->sql()->where($key, '=', $this->db->adapter()->escape($value));
                    }
                }

                $this->db->adapter()->query($this->db->sql()->getSql());
            } else {
                $this->db->sql()->setTable($this->tableName)
                                ->setIdQuoteType($this->idQuote)
                                ->insert((array)$this->columns);

                $this->db->adapter()->query($this->db->sql()->getSql());
            }
        } else {
            if ($this->auto == false) {
                $action = ($type == \Pop\Record\Record::INSERT) ? 'insert' : 'update';
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
                                ->setIdQuoteType($this->idQuote)
                                ->update((array)$this->columns);

                if (is_array($this->primaryId)) {
                    foreach ($this->primaryId as $value) {
                        $this->db->sql()->where($this->db->adapter()->escape($value), '=', $this->db->adapter()->escape($this->columns[$value]));
                    }
                } else {
                    $this->db->sql()->where($this->db->adapter()->escape($this->primaryId), '=', $this->db->adapter()->escape($this->columns[$this->primaryId]));
                }

                $this->db->adapter()->query($this->db->sql()->getSql());
            } else {
                $this->db->sql()->setTable($this->tableName)
                                ->setIdQuoteType($this->idQuote)
                                ->insert((array)$this->columns);

                $this->db->adapter()->query($this->db->sql()->getSql());

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
     * @param  array $columnsPassed
     * @param  array $columns
     * @throws Exception
     * @return void
     */
    public function delete($columnsPassed, array $columns = null)
    {
        $this->columns = $columnsPassed;

        if (null === $this->primaryId) {
            if ((null === $columns) && (count($this->finder) == 0)) {
                throw new Exception('The column and value parameters were not defined to describe the row(s) to delete.');
            } else if (null === $columns) {
                $columns = $this->finder;
            }

            $this->db->sql()->setTable($this->tableName)
                            ->setIdQuoteType($this->idQuote)
                            ->delete();

            foreach ($columns as $key => $value) {
                $this->db->sql()->where($this->db->adapter()->escape($key), '=', $this->db->adapter()->escape($value));
            }

            $this->db->adapter()->query($this->db->sql()->getSql());

            $this->columns = array();
            $this->rows = array();
        } else {
            $this->db->sql()->setTable($this->tableName)
                            ->setIdQuoteType($this->idQuote)
                            ->delete();

            // Specific column override.
            if (null !== $columns) {
                foreach ($columns as $key => $value) {
                    $this->db->sql()->where($this->db->adapter()->escape($key), '=', $this->db->adapter()->escape($value));
                }
            // Else, continue with the primaryId column(s)
            } else if (is_array($this->primaryId)) {
                foreach ($this->primaryId as $value) {
                    $this->db->sql()->where($this->db->adapter()->escape($value), '=', $this->db->adapter()->escape($this->columns[$value]));
                }
            } else {
                $this->db->sql()->where($this->db->adapter()->escape($this->primaryId), '=', $this->db->adapter()->escape($this->columns[$this->primaryId]));
            }

            $this->db->adapter()->query($this->db->sql()->getSql());

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
        $this->db->adapter()->query($sql);

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

        while (($row = $this->db->adapter()->fetch()) != false) {
            $this->rows[] = new \ArrayObject($row, \ArrayObject::ARRAY_AS_PROPS);
        }

        if (isset($this->rows[0])) {
            $this->columns = $this->rows[0];
        }
    }

}
