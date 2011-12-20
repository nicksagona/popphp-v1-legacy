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
    Pop\Locale\Locale,
    Pop\Record\Escaped,
    Pop\Record\Prepared,
    Pop\Filter\String;

/**
 * @category   Pop
 * @package    Pop_Record
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Record
{

    /**
     * Constant to set the type to INSERT on save
     * @var int
     */
    const INSERT = 0;

    /**
     * Constant to set the type to UPDATE on save
     * @var int
     */
    const UPDATE = 1;

    /**
     * Database connection(s)
     * @var array
     */
    public static $db = array('default' => null);

    /**
     * Rows of multiple return results from a database query
     * in an ArrayObject format.
     * @var array
     */
    public $rows = array();

    /**
     * Database adapter
     * @var Pop_Record_Escaped|Pop_Record_Prepared
     */
    protected $_interface = null;

    /**
     * Table prefix
     * @var string
     */
    protected $_prefix = null;

    /**
     * Table name of the database table
     * @var string
     */
    protected $_tableName = null;

    /**
     * Primary ID column name of the database table
     * @var string
     */
    protected $_primaryId = 'id';

    /**
     * Property that determines whether or not the primary ID is auto-increment or not
     * @var boolean
     */
    protected $_auto = true;

    /**
     * Column names of the database table
     * @var array
     */
    protected $_columns = array();

    /**
     * Flag on whether or not to use prepared statements
     * @var boolean
     */
    protected $_usePrepared = true;

    /**
     * Language object
     * @var Pop_Locale
     */
    protected $_lang = null;

    /**
     * Constructor
     *
     * Instantiate the database record object.
     *
     * @param  array $columns
     * @return void
     */
    public function __construct($columns = null)
    {
        $this->_lang = new Locale();

        // If the $columns argument is set, set the _columns properties.
        if (null !== $columns) {
            foreach($columns as $key => $value) {
                $this->_columns[$key] = $value;
            }
        }

        if (null === $this->_tableName) {
            $class = get_class($this);
            if (strpos($class, '_') !== false) {
                $cls = substr($class, (strrpos($class, '_') + 1));
            } else {
                $cls = substr($class, (strrpos($class, '\\') + 1));
            }
            $this->_tableName = $this->_prefix . (string)String::factory($cls)->camelCaseToUnderscore();
        } else {
            $this->_tableName = $this->_prefix . $this->_tableName;
        }

        $options = array(
                       'tableName' => $this->_tableName,
                       'primaryId' => $this->_primaryId,
                       'auto'      => $this->_auto
                   );

        $type = self::getDb()->getAdapterType();

        if (($type == 'Mysql') || (!$this->_usePrepared)) {
            $this->_interface = new Escaped(self::getDb(), $options);
        } else {
            $this->_interface = new Prepared(self::getDb(), $options);
        }
    }

    /**
     * Set DB connection
     *
     * @param  Pop_Db $name
     * @param  boolean  $isDefault
     * @return void
     */
    public static function setDb(Db $db, $isDefault = false)
    {
        $class = get_called_class();

        static::$db[$class] = $db;
        if ($isDefault) {
            static::$db['default'] = $db;
        }
    }

    /**
     * Get DB connection
     *
     * @throws Exception
     * @return Pop\Pop\Db
     */
    public static function getDb()
    {
        $class = get_called_class();

        if (isset(static::$db[$class])) {
            return static::$db[$class];
        } else if (isset(static::$db['default'])) {
            return static::$db['default'];
        } else {
            throw new Exception(Locale::factory()->__('No database adapter was found.'));
        }
    }

    /**
     * Find a database row by the primary ID passed through the method argument.
     *
     * @param  int|string $id
     * @param  int|string $limit
     * @throws Exception
     * @return Pop\Record\Record
     */
    public static function findById($id, $limit = null)
    {
        $record = new static();

        $record->_interface->findById($id, $limit);
        $record->_setResults($record->_interface->getResult());

        return $record;
    }

    /**
     * Find a database row by the column passed through the method argument.
     *
     * @param  string $column
     * @param  int|string $value
     * @param  int|string $limit
     * @return Pop\Record\Record
     */
    public static function findBy($column, $value, $limit = null)
    {
        $record = new static();

        $record->_interface->findBy($column, $value, $limit);
        $record->_setResults($record->_interface->getResult());

        return $record;
    }

    /**
     * Find all of the database rows by the column passed through the method argument.
     *
     * @param  string     $order
     * @param  string     $column
     * @param  int|string $value
     * @param  int|string $limit
     * @return Pop\Record\Record
     */
    public static function findAll($order = null, $column = null, $value = null, $limit = null)
    {
        $record = new static();

        $record->_interface->findAll($order, $column, $value, $limit);
        $record->_setResults($record->_interface->getResult());

        return $record;
    }

    /**
     * Find singular and distinct entries in the database based on the search criteria.
     *
     * @param  array $distinctColumns
     * @param  string $order
     * @param  string $column
     * @param  int|string $value
     * @param  int|string $limit
     * @return Pop\Record\Record
     */
    public static function distinct($distinctColumns, $order = null, $column = null, $value = null, $limit = null)
    {
        $record = new static();

        $record->_interface->distinct($distinctColumns, $order, $column, $value, $limit);
        $record->_setResults($record->_interface->getResult());

        return $record;
    }

    /**
     * Search the database for rows based on the search criteria.
     *
     * @param  array $searchColumns
     * @param  string $order
     * @param  int|string $limit
     * @return Pop\Record\Record
     */
    public static function search($searchColumns, $order = null, $limit = null)
    {
        $record = new static();

        $record->_interface->search($searchColumns, $order, $limit);
        $record->_setResults($record->_interface->getResult());

        return $record;
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
     * @return Pop\Record\Record
     */
    public static function join($tableToJoin, $commonColumn, $order = null, $column = null, $value = null, $limit = null)
    {
        $record = new static();

        $record->_interface->join($tableToJoin, $commonColumn, $order, $column, $value, $limit);
        $record->_setResults($record->_interface->getResult());

        return $record;
    }

    /**
     * Execute a custom prepared SQL query.
     *
     * @param  string $sql
     * @param  array  $params
     * @return Pop\Record\Record
     */
    public static function execute($sql, $params = null)
    {
        $record = new static();

        $record->_interface->execute($sql, $params);
        $record->_setResults($record->_interface->getResult());

        return $record;
    }

    /**
     * Execute a custom SQL query.
     *
     * @param  string $sql
     * @return Pop\Record\Record
     */
    public static function query($sql)
    {
        $record = new static();

        $record->_interface->query($sql);
        $record->_setResults($record->_interface->getResult());

        return $record;
    }

    /**
     * Get if the table is an autocrement table
     *
     * @return boolean
     */
    public function isAuto()
    {
        return $this->_auto;
    }

    /**
     * Get the table primary ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->_primaryId;
    }

    /**
     * Get the table prefix
     *
     * @return astring
     */
    public function getPrefix()
    {
        return $this->_prefix;
    }

    /**
     * Get the table name
     *
     * @return string
     */
    public function getTableName()
    {
        if (null !== $this->_prefix) {
            return str_replace($this->_prefix, '', $this->_tableName);
        } else {
            return $this->_tableName;
        }
    }

    /**
     * Get the full table name with prefix
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->_tableName;
    }

    /**
     * Method to return the current number of records.
     *
     * @return int
     */
    public function count()
    {
        return count($this->rows);
    }

    /**
     * Set all the table column values at once.
     *
     * @param  array $columns
     * @throws Exception
     * @return void
     */
    public function setValues($columns = null)
    {
        // If null, clear the columns.
        if (null === $columns) {
            $this->_columns = array();
            $this->rows = array();
        // Else, if an array, set the columns.
        } else if (is_array($columns)) {
            $this->_columns = $columns;
            $this->rows[0] = new \ArrayObject($columns, \ArrayObject::ARRAY_AS_PROPS);
        // Else, throw an exception.
        } else {
            throw new Exception($this->_lang->__('The parameter passed must be either an array or null.'));
        }
    }

    /**
     * Update (save) the existing database record.
     *
     * @return void
     */
    public function update()
    {
        $this->save(self::UPDATE);
    }

    /**
     * Save the database record.
     *
     * @param  int $type
     * @return void
     */
    public function save($type = Record::INSERT)
    {
        $this->_interface->save($this->_columns, $type);
        $this->_setResults($this->_interface->getResult());
    }

    /**
     * Delete the database record.
     *
     * @param  string $column
     * @param  string $value
     * @throws Exception
     * @return void
     */
    public function delete($column = null, $value = null)
    {
        $this->_interface->delete($this->_columns, $column, $value);
        $this->_setResults($this->_interface->getResult());
    }

    /**
     * Return the escaped string value.
     *
     * @param  string $value
     * @return string
     */
    public function escape($value)
    {
        return $this->_interface->db->adapter->escape($value);
    }

    /**
     * Return the auto-increment ID of the last query.
     *
     * @return int
     */
    public function lastId()
    {
        return $this->_interface->db->adapter->lastId();
    }

    /**
     * Return the number of rows in the result.
     *
     * @return int
     */
    public function numRows()
    {
        return $this->_interface->db->adapter->numRows();
    }

    /**
     * Return the number of fields in the result.
     *
     * @return int
     */
    public function numFields()
    {
        return $this->_interface->db->adapter->numFields();
    }

    /**
     * Set the query results.
     *
     * @param  array $rows
     * @return void
     */
    protected function _setResults($rows)
    {
        $this->rows = $rows;
        $this->_columns = (count($rows) == 1) ? $rows[0] : array();
    }

    /**
     * Set method to set the property to the value of _columns[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @throws Exception
     * @return void
     */
    public function __set($name, $value)
    {
        // Check to see if the column key exists.
        if (!array_key_exists($name, $this->_columns)) {
            throw new Exception($this->_lang->__("The column '%1' does not exist.", $name));
        } else {
            $this->_columns[$name] = $value;
        }
    }

    /**
     * Get method to return the value of _columns[$name].
     *
     * @param  string $name
     * @throws Exception
     * @return mixed
     */
    public function __get($name)
    {
        // Check to see if the column key exists.
        if (!array_key_exists($name, $this->_columns)) {
            throw new Exception($this->_lang->__("The column '%1' does not exist.", $name));
        } else {
            return $this->_columns[$name];
        }
    }

    /**
     * Return the isset value of _columns[$name].
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->_columns[$name]);
    }

    /**
     * Unset _columns[$name].
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        $this->_columns[$name] = null;
    }

}
