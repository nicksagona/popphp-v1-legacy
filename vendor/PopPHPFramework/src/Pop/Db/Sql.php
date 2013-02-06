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
namespace Pop\Db;

/**
 * SQL class
 *
 * @category   Pop
 * @package    Pop_Db
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Sql
{

    /**
     * Constant for MYSQL database type
     * @var int
     */
    const MYSQL = 1;

    /**
     * Constant for Oracle database type
     * @var int
     */
    const ORACLE = 2;

    /**
     * Constant for PGSQL database type
     * @var int
     */
    const PGSQL = 3;

    /**
     * Constant for SQLITE database type
     * @var int
     */
    const SQLITE = 4;

    /**
     * Constant for SQLSRV database type
     * @var int
     */
    const SQLSRV = 5;

    /**
     * Constant for backtick quote id type
     * @var int
     */
    const BACKTICK = 6;

    /**
     * Constant for bracket quote id type
     * @var int
     */
    const BRACKET = 7;

    /**
     * Constant for double quote id type
     * @var int
     */
    const DOUBLE_QUOTE = 8;

    /**
     * Constant for double quote id type
     * @var int
     */
    const NO_QUOTE = 0;

    /**
     * Database object
     * @var \Pop\Db\Db
     */
    protected $db = null;

    /**
     * Database type
     * @var int
     */
    protected $dbType = null;

    /**
     * ID quote type
     * @var int
     */
    protected $quoteIdType = 0;

    /**
     * Current selected table
     * @var string
     */
    protected $table = null;

    /**
     * SQL statement
     * @var string
     */
    protected $sql = null;

    /**
     * Constructor
     *
     * Instantiate the SQL object.
     *
     * @param  \Pop\Db\Db $db
     * @param  string     $table
     * @return \Pop\Db\Sql
     */
    public function __construct(Db $db, $table = null)
    {
        $this->setDb($db);
        $this->setTable($table);
    }

    /**
     * Static method to instantiate the SQL object and return itself
     * to facilitate chaining methods together.
     *
     * @param  \Pop\Db\Db $db
     * @param  string     $table
     * @return \Pop\Db\Sql
     */
    public static function factory(Db $db, $table = null)
    {
        return new self($db, $table);
    }

    /**
     * Set the database object
     *
     * @param  \Pop\Db\Db $db
     * @return \Pop\Db\Sql
     */
    public function setDb(Db $db)
    {
        $this->db = $db;

        $adapter = strtolower($this->db->getAdapterType());

        if (strpos($adapter, 'mysql') !== false) {
            $this->dbType = self::MYSQL;
            $this->quoteIdType = self::BACKTICK;
        } else if (strpos($adapter, 'oracle') !== false) {
            $this->dbType = self::ORACLE;
            $this->quoteIdType = self::DOUBLE_QUOTE;
        } else if (strpos($adapter, 'pgsql') !== false) {
            $this->dbType = self::PGSQL;
            $this->quoteIdType = self::DOUBLE_QUOTE;
        } else if (strpos($adapter, 'sqlite') !== false) {
            $this->dbType = self::SQLITE;
            $this->quoteIdType = self::DOUBLE_QUOTE;
        } else if (strpos($adapter, 'sqlsrv') !== false) {
            $this->dbType = self::SQLSRV;
            $this->quoteIdType = self::BRACKET;
        }

        return $this;
    }

    /**
     * Set the quote ID type
     *
     * @param  int $type
     * @return \Pop\Db\Sql
     */
    public function setQuoteId($type = \Pop\Db\Sql::NO_QUOTE)
    {
        $this->quoteIdType = (int)$type;
        return $this;
    }

    /**
     * Set current table to operate on.
     *
     * @param  string $table
     * @return \Pop\Db\Sql
     */
    public function setTable($table = null)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Determine if the Sql object has a table set
     *
     * @return boolean
     */
    public function hasTable()
    {
        return ($this->table != null);
    }

    /**
     * Get the current database object.
     *
     * @return \Pop\Db\Db
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Get the current database type.
     *
     * @return int
     */
    public function getDbType()
    {
        return $this->dbType;
    }

    /**
     * Get the quote ID type
     *
     * @return int
     */
    public function getQuoteId()
    {
        return $this->quoteIdType;
    }

    /**
     * Get the current table.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get the current SQL statement string.
     *
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * Get the current SQL statement string.
     *
     * @param  string $id
     * @return string
     */
    public function quoteId($id)
    {
        $quotedId = null;
        $startQuote = null;
        $endQuote = null;

        switch ($this->quoteIdType) {
            case self::BACKTICK:
                $startQuote = '`';
                $endQuote = '`';
                break;
            case self::BRACKET:
                $startQuote = '[';
                $endQuote = ']';
                break;
            case self::DOUBLE_QUOTE:
                $startQuote = '"';
                $endQuote = '"';
                break;
        }

        if (strpos($id, '.') !== false) {
            $idAry = explode('.', $id);
            foreach ($idAry as $key => $value) {
                $idAry[$key] = $startQuote . $value . $endQuote;
            }
            $quotedId = implode('.', $idAry);
        } else {
            $quotedId = $startQuote . $id . $endQuote;
        }

        return $quotedId;
    }

    /**
     * Create a select statement
     *
     * @return void
     */
    public function select()
    {

    }

    /**
     * Create a insert statement
     *
     * @return void
     */
    public function insert()
    {

    }

    /**
     * Create a update statement
     *
     * @return void
     */
    public function update()
    {

    }

    /**
     * Create a delete statement
     *
     * @return void
     */
    public function delete()
    {

    }

    /**
     * Method to return the SQL as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->sql;
    }

}
