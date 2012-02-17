<?php
/**
 * Pop PHP Framework Unit Tests
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
        $this->assertInstanceOf('Pop\\Db\\Sql', new Sql('users'));
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
        $this->setExpectedException('Pop\\Db\\Exception');
        $s->insert(array());
    }

    public function testUpdateException()
    {
        $s = new Sql('users');
        $this->setExpectedException('Pop\\Db\\Exception');
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

    public function testBuildTableException()
    {
        $s = new Sql();
        $this->setExpectedException('Pop\\Db\\Exception');
        $s->getSql();
    }

    public function testBuildTypeException()
    {
        $s = new Sql('users');
        $this->setExpectedException('Pop\\Db\\Exception');
        $s->getSql();
    }

}

