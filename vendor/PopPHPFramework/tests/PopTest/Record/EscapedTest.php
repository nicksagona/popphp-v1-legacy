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

class Users extends Record {
    protected $usePrepared = false;
}

class EscapedTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $r = new Record(array('column' => 'value'), Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')));
        $this->assertInstanceOf('Pop\Record\Record', $r);
    }

    public function testGetDefaultDb()
    {
        Record::setDb(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')), true);
        $this->assertInstanceOf('Pop\Db\Db', Record::getDb());
    }

    public function testFindById()
    {
         $r = Users::findById(1);
         $this->assertEquals(1, $r->id);
         $this->assertEquals(0, $r->lastId());
    }

    public function testFindBy()
    {
         $r = Users::findBy('email', 'test1@test.com');
         $r->test = $r->escape('test');
         $this->assertEquals('test', $r->test);
         unset($r->test);
         $this->assertNull($r->test);
         $this->assertEquals(1, $r->id);
    }

    public function testFindAll()
    {
         $r = Users::findAll('id RAND()');
         $r = Users::findAll('id DESC');
         $r = Users::findAll('id ASC');
         $this->assertEquals(8, count($r->rows));
         $this->assertEquals(8, $r->numRows());
         $this->assertEquals(5, $r->numFields());
    }

    public function testDistinct()
    {
         $r = Users::distinct(array('id'));
         $this->assertEquals(8, count($r->rows));
    }

    public function testSearch()
    {
         $r = Users::search(array('username', 'LIKE', '%test%'));
         $this->assertEquals(8, count($r->rows));
    }

    public function testExecute()
    {
         $r = Users::execute('SELECT * FROM users');
         $this->assertEquals(8, count($r->rows));
    }

    public function testQuery()
    {
         $r = Users::query('SELECT * FROM users');
         $this->assertEquals(8, count($r->rows));
    }

}

