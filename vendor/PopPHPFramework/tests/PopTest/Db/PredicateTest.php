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
use Pop\Db\Sql\Predicate;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class PredicateTest extends \PHPUnit_Framework_TestCase
{

    public function testNest()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->nest()->equalTo('id', 5, 'OR')
                  ->equalTo('id', 6, 'OR');
        $p->equalTo('access', 'reader');
        $this->assertTrue($p->hasNest());
        $this->assertInstanceOf('Pop\Db\Sql\Predicate', $p->getNest(0));
        $this->assertEquals('(("id" = 5) OR ("id" = 6)) AND ("access" = \'reader\')', (string)$p);
    }

    public function testNotEqualTo()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->notEqualTo('id', 5);
        $this->assertEquals('("id" != 5)', (string)$p);
    }

    public function testGreaterThan()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->greaterThan('id', 5);
        $this->assertEquals('("id" > 5)', (string)$p);
    }

    public function testGreaterThanOrEqualTo()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->greaterThanOrEqualTo('id', 5);
        $this->assertEquals('("id" >= 5)', (string)$p);
    }

    public function testLessThan()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->lessThan('id', 5);
        $this->assertEquals('("id" < 5)', (string)$p);
    }

    public function testLessThanOrEqualTo()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->lessThanOrEqualTo('id', 5);
        $this->assertEquals('("id" <= 5)', (string)$p);
    }

    public function testLike()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->like('email', '%@test.com');
        $this->assertEquals('("email" LIKE \'%@test.com\')', (string)$p);
    }

    public function testNotLike()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->notLike('email', '%@test.com');
        $this->assertEquals('("email" NOT LIKE \'%@test.com\')', (string)$p);
    }

    public function testBetween()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->between('id', 5, 10);
        $this->assertEquals('("id" BETWEEN 5 AND 10)', (string)$p);
    }

    public function testNotBetween()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->notBetween('id', 5, 10);
        $this->assertEquals('("id" NOT BETWEEN 5 AND 10)', (string)$p);
    }

    public function testIn()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->in('id', array(1, 2, 3));
        $this->assertEquals('("id" IN (1, 2, 3))', (string)$p);
    }

    public function testNotIn()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->notIn('id', array(1, 2, 3));
        $this->assertEquals('("id" NOT IN (1, 2, 3))', (string)$p);
    }

    public function testIsNull()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->isNull('email');
        $this->assertEquals('("email" IS NULL)', (string)$p);
    }

    public function testIsNotNull()
    {
        $p = new Predicate(Sql::factory(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), 'users'));
        $p->isNotNull('email');
        $this->assertEquals('("email" IS NOT NULL)', (string)$p);
    }

}

