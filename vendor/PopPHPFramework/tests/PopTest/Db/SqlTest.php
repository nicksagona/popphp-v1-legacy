<?php
/**
 * Pop PHP Framework Unit Tests (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Test
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace PopTest\Db;

use Pop\Loader\Autoloader;
use Pop\Db\Db;
use Pop\Db\Sql;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class SqlTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Db\Sql', new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $this->assertInstanceOf('Pop\Db\Sql', Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
    }

    public function testSetAndGetDb()
    {
        $db = Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite'));
        $s = new Sql($db, 'users');
        $s->setDb($db);
        $this->assertInstanceOf('Pop\Db\Db', $s->getDb());
        $this->assertInstanceOf('Pop\Db\Adapter\Sqlite', $s->adapter());
    }

    public function testSql()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select()
          ->where()->equalTo('id', 1);

        ob_start();
        $s->render();
        $output = ob_get_clean();

        $this->assertEquals('SELECT * FROM "users" WHERE ("id" = 1)', $s->render(true));
        $this->assertEquals('SELECT * FROM "users" WHERE ("id" = 1)', (string)$s);
        $this->assertEquals('SELECT * FROM "users" WHERE ("id" = 1)', $s->getSql());
        $this->assertEquals('SELECT * FROM "users" WHERE ("id" = 1)', $output);
    }

    public function testSqlDotId()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select('username')
          ->where()->equalTo('users.id', 1);
        $this->assertEquals('SELECT "username" FROM "users" WHERE ("users"."id" = 1)', $s->render(true));
    }

    public function testSetAndGetQuoteId()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->setQuoteId(Sql::NO_QUOTE);
        $this->assertEquals(0, $s->getQuoteId());
    }

    public function testGetDbType()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $this->assertEquals(Sql::SQLITE, $s->getDbType());
    }

    public function testSetAndGetTable()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->setTable('user_data');
        $this->assertEquals('user_data', $s->getTable());
    }

    public function testSetAndGetAlias()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->setAlias('user_data');
        $this->assertEquals('user_data', $s->getAlias());
    }

    public function testHasTable()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $this->assertTrue($s->hasTable());
    }

    public function testHasAlias()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users', 'user_data');
        $this->assertTrue($s->hasAlias());
    }

    public function testQuoteId()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $this->assertEquals('"users"', $s->quoteId('users'));
        $this->assertEquals('"users"."id"', $s->quoteId('users.id'));
        $s->setQuoteId(Sql::BACKTICK);
        $this->assertEquals('`users`', $s->quoteId('users'));
        $this->assertEquals('`users`.`id`', $s->quoteId('users.id'));
        $s->setQuoteId(Sql::BRACKET);
        $this->assertEquals('[users]', $s->quoteId('users'));
        $this->assertEquals('[users].[id]', $s->quoteId('users.id'));
    }

    public function testQuote()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $this->assertEquals("'test@test.com'", $s->quote('test@test.com'));
    }

    public function testInsertException()
    {
        $this->setExpectedException('Pop\Db\Exception');
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->insert();
    }

    public function testUpdateException()
    {
        $this->setExpectedException('Pop\Db\Exception');
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->update();
    }

    public function testRenderException()
    {
        $this->setExpectedException('Pop\Db\Exception');
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $sql = $s->render(true);
    }

    public function testOrderBy()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select()->orderBy('id, username');
        $this->assertEquals('SELECT * FROM "users" ORDER BY "id", "username" ASC', $s->render(true));
    }

    public function testGroupBySingle()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select()->groupBy('id');
        $this->assertEquals('SELECT * FROM "users" GROUP BY "id"', $s->render(true));
    }

    public function testGroupByMultiple()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select()->groupBy(array('id', 'username'));
        $this->assertEquals('SELECT * FROM "users" GROUP BY "id", "username"', $s->render(true));
    }

    public function testGroupByArray()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select()->groupBy('id, username');
        $this->assertEquals('SELECT * FROM "users" GROUP BY "id", "username"', $s->render(true));
    }

    public function testHaving()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select()->having()->equalTo('id', 5);
        $this->assertEquals('SELECT * FROM "users" HAVING ("id" = 5)', $s->render(true));
    }

    public function testOffset()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select()->offset(3);
        $this->assertEquals('SELECT * FROM "users" OFFSET 3', $s->render(true));
    }

    public function testSelectColumnAlias()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select(array('user_id' => 'id'));
        $this->assertEquals('SELECT "id" AS "user_id" FROM "users"', $s->render(true));
    }

    public function testSelectJoin()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select()->join('user_data', 'id', 'LEFT JOIN');
        $this->assertEquals('SELECT * FROM "users" LEFT JOIN "user_data" ON "users"."id" = "user_data"."id"', $s->render(true));
    }

    public function testSelectJoinDifferentColumns()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select()->join('user_data', array('id', 'user_id'), 'LEFT JOIN');
        $this->assertEquals('SELECT * FROM "users" LEFT JOIN "user_data" ON "users"."id" = "user_data"."user_id"', $s->render(true));
    }

    public function testSelectDistinct()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->select('username')->distinct();
        $this->assertEquals('SELECT DISTINCT "username" FROM "users"', $s->render(true));
    }

    public function testUpdate()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->update(array('username' => 'newuser'))->orderBy('id')->limit(1);
        $this->assertEquals('UPDATE "users" SET "username" = \'newuser\' ORDER BY "id" ASC LIMIT 1', $s->render(true));
    }

    public function testDelete()
    {
        $s = new Sql(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users');
        $s->delete()->orderBy('id')->limit(1);
        $this->assertEquals('DELETE FROM "users" ORDER BY "id" ASC LIMIT 1', $s->render(true));
    }

}

