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

namespace PopTest\Record;

use Pop\Loader\Autoloader,
    Pop\Db\Db,
    Pop\Record\Record;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class PreparedUsers extends Record {
    protected $tableName = 'users';
    protected $usePrepared = true;
}

class PreparedTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $r = new Record(array('column' => 'value'), Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')));
        $this->assertInstanceOf('Pop\\Record\\Record', $r);
    }

    public function testGetDefaultDb()
    {
        Record::setDb(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), true);
        $this->assertInstanceOf('Pop\\Db\\Db', Record::getDb());
    }

    public function testFindById()
    {
         $r = PreparedUsers::findById(1);
         $this->assertEquals(1, $r->id);
         $this->assertEquals(0, $r->lastId());
    }

    public function testFindBy()
    {
         $r = PreparedUsers::findBy('email', 'test1@test.com');
         $r->test = $r->escape('test');
         $this->assertEquals('test', $r->test);
         unset($r->test);
         $this->assertNull($r->test);
         $this->assertEquals(1, $r->id);
    }

    public function testFindAll()
    {
         $r = PreparedUsers::findAll('id RAND()');
         $r = PreparedUsers::findAll('id DESC');
         $r = PreparedUsers::findAll('id ASC');
         $this->assertEquals(8, count($r->rows));
         $this->assertEquals(0, $r->numRows());
         $this->assertEquals(5, $r->numFields());
    }

    public function testDistinct()
    {
         $r = PreparedUsers::distinct(array('id'));
         $this->assertEquals(8, count($r->rows));
         $this->assertEquals(8, $r->count());
    }

    public function testSearch()
    {
         $r = PreparedUsers::search(array('username', 'LIKE', '%test%'));
         $this->assertEquals(8, count($r->rows));
    }

    public function testExecute()
    {
         $r = PreparedUsers::execute('SELECT * FROM users');
         $this->assertEquals(8, count($r->rows));
    }

    public function testQuery()
    {
         $r = PreparedUsers::query('SELECT * FROM users');
         $this->assertEquals(8, count($r->rows));
    }

    public function testIsAuto()
    {
        $r = PreparedUsers::findById(1);
        $this->assertTrue($r->isAuto());
    }

    public function testGetId()
    {
        $r = PreparedUsers::findById(1);
        $this->assertEquals('id', $r->getId());
    }

    public function testGetTableName()
    {
        $r = PreparedUsers::findById(1);
        $this->assertEquals('users', $r->getTableName());
    }

    public function testGetPrefix()
    {
        $r = PreparedUsers::findById(1);
        $this->assertNull($r->getPrefix());
    }

    public function testSetValues()
    {
        $r = new Record();
        $r->setValues(array('column' => 'value'));
        $this->assertEquals(1, $r->count());
        $r->setValues();
        $this->assertEquals(0, count($r->rows));
    }

    public function testSetValuesException()
    {
        $this->setExpectedException('Pop\\Record\\Exception');
        $r = new Record();
        $r->setValues(123);
    }
}

