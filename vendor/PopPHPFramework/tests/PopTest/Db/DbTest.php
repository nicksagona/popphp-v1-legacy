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
use Pop\Db\Record;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class DbTest extends \PHPUnit_Framework_TestCase
{

    public function testGetDbException()
    {
        $this->setExpectedException('Pop\Db\Exception');
        $this->assertInstanceOf('Pop\Db\Db', Record::getDb());
    }

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\Db\Db', Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')));
    }

    public function testQuery()
    {
        $d = Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite'));
        $d->adapter()->query('SELECT * FROM users WHERE id = 1');
        $r = null;
        while (($row = $d->adapter()->fetch()) != false) {
            $r = $row;
        }
        $this->assertEquals(1, $r['id']);
        $this->assertEquals('test1', $r['username']);
        $this->assertEquals('password1', $r['password']);
        $this->assertEquals('test1@test.com', $r['email']);
        $this->assertEquals('reader', $r['access']);
        $this->assertEquals(1, $d->adapter()->numRows());
        $this->assertEquals(5, $d->adapter()->numFields());
    }

    public function testGetConnection()
    {
        $d = Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite'));
        $d->adapter()->query('SELECT * FROM users WHERE id = 1');
        $this->assertNotNull($d->adapter()->getConnection());
    }

    public function testGetResult()
    {
        $d = Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite'));
        $d->adapter()->query('SELECT * FROM users WHERE id = 1');
        $this->assertNotNull($d->adapter()->getResult());
    }

    public function testVersion()
    {
        $d = Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite'));
        $this->assertContains('SQLite', $d->adapter()->version());
        $this->assertFalse($d->isPdo());
    }

    public function testIsPdo()
    {
        $d = Db::factory('Pdo', array('database' => __DIR__ . '/../tmp/test.sqlite', 'type' => 'sqlite'));
        $this->assertTrue($d->isPdo());
    }

}

