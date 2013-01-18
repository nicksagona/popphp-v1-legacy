<?php
/**
 * Pop PHP Framework Unit Tests (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Test
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace PopTest\Db;

use Pop\Loader\Autoloader,
    Pop\Db\Sql;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class SqlTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Db\Sql', new Sql('users'));
    }

    public function testSql()
    {
        $s = new Sql('users');
        $s->setIdQuoteType(Sql::BACKTICK)
          ->select()
          ->where('id', '=', 1);
        $this->assertEquals("SELECT * FROM `users` WHERE (`id` = '1')", $s->getSql());
        $this->assertEquals("SELECT * FROM `users` WHERE (`id` = '1')", (string)$s);
    }

    public function testSqlDotId()
    {
        $s = new Sql('users');
        $s->setIdQuoteType(Sql::BACKTICK)
          ->select()
          ->where('users.id', '=', 1);
        $this->assertEquals("SELECT * FROM `users` WHERE (`users`.`id` = '1')", $s->getSql());
    }

    public function testSetAndGetIdQuote()
    {
        $s = new Sql('users');
        $s->setIdQuoteType(Sql::SINGLE_QUOTE);
        $this->assertEquals("'", $s->getIdQuote());
        $s->setIdQuoteType(Sql::BRACKET);
        $this->assertEquals("[", $s->getIdQuote());
        $this->assertEquals("]", $s->getIdQuote(true));
        $s->setIdQuoteType();
        $this->assertEquals('', $s->getIdQuote());
    }

    public function testSetAndGetDbType()
    {
        $s = new Sql('users');
        $s->setDbType(Sql::SQLSRV);
        $this->assertEquals(6, $s->getDbType());
    }

    public function testDistinct()
    {
        $s = new Sql('users');
        $s->setIdQuoteType(Sql::BACKTICK)
          ->select('email')
          ->distinct(true)
          ->where('id', '=', 1)
          ->where('email', '=', 'test@test.com');
        $this->assertEquals("SELECT DISTINCT `email` FROM `users` WHERE (`id` = '1') AND (`email` = 'test@test.com')", $s->getSql());
    }

    public function testInsertException()
    {
        $s = new Sql('users');
        $this->setExpectedException('Pop\Db\Exception');
        $s->insert(array());
    }

    public function testUpdateException()
    {
        $s = new Sql('users');
        $this->setExpectedException('Pop\Db\Exception');
        $s->update(array());
    }

    public function testUpdate()
    {
        $s = new Sql('users');
        $s->update(array('name' => 'Test1', 'email' => 'test1@test.com'))
          ->where('id', '=', 1);
        $this->assertEquals("UPDATE users SET name = 'Test1', email = 'test1@test.com' WHERE (id = '1')", $s->getSql());
    }

    public function testJoin()
    {
        $s = new Sql('users');
        $s->select()
          ->join('admins', 'email')
          ->order(array('email', 'name'))
          ->limit(3);
        $this->assertEquals("SELECT * FROM users JOIN admins ON users.email = admins.email ORDER BY email, name ASC LIMIT 3", $s->getSql());
    }

    public function testJoinColumns()
    {
        $s = new Sql('users');
        $s->select()
          ->join('admins', array('email', 'name'), 'LEFT JOIN')
          ->order('email')
          ->limit(3);
        $this->assertEquals("SELECT * FROM users LEFT JOIN admins ON users.email = admins.name ORDER BY email ASC LIMIT 3", $s->getSql());
    }

    public function testMsSql()
    {
        $s = new Sql('users');
        $s->setDbType(Sql::SQLSRV)
          ->setIdQuoteType(Sql::BRACKET)
          ->select('email')
          ->limit(5);
        $this->assertEquals("SELECT TOP 5 [email] FROM [users]", $s->getSql());

        $s = new Sql('users');
        $s->setDbType(Sql::SQLSRV)
          ->setIdQuoteType(Sql::BRACKET)
          ->select('email')
          ->order('id')
          ->limit('5, 10');
        $this->assertEquals("SELECT [email] FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY [id] ASC) AS RowNumber FROM [users]) AS OrderedTable WHERE ([OrderedTable].[RowNumber] BETWEEN '5' AND '10') ORDER BY [id] ASC", $s->getSql());
    }

    public function testMsSqlException()
    {
        $s = new Sql('users');
        $s->setDbType(Sql::SQLSRV)
          ->setIdQuoteType(Sql::BRACKET)
          ->select('email')
          ->limit('5, 10');
        $this->setExpectedException('Pop\Db\Exception');
        $sql = $s->getSql();
    }

    public function testOracleSql()
    {
        $s = new Sql('users');
        $s->setDbType(Sql::ORACLE)
          ->select('email')
          ->order('id')
          ->limit(5);
        $this->assertEquals("SELECT email FROM (SELECT t.*, ROW_NUMBER() OVER (ORDER BY id ASC) RowNumber FROM users t) WHERE (RowNumber <= '5') ORDER BY id ASC", $s->getSql());

        $s = new Sql('users');
        $s->setDbType(Sql::ORACLE)
          ->select('email')
          ->order('id')
          ->limit('5, 10');
        $this->assertEquals("SELECT email FROM (SELECT t.*, ROW_NUMBER() OVER (ORDER BY id ASC) RowNumber FROM users t) WHERE (RowNumber BETWEEN '5' AND '10') ORDER BY id ASC", $s->getSql());
    }

    public function testOracleException()
    {
        $s = new Sql('users');
        $s->setDbType(Sql::ORACLE)
          ->select('email')
          ->limit('5, 10');
        $this->setExpectedException('Pop\Db\Exception');
        $sql = $s->getSql();
    }

    public function testBuildTableException()
    {
        $s = new Sql();
        $this->setExpectedException('Pop\Db\Exception');
        $s->getSql();
    }

    public function testBuildTypeException()
    {
        $s = new Sql('users');
        $this->setExpectedException('Pop\Db\Exception');
        $s->getSql();
    }

}

