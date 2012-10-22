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
    Pop\Db\Db,
    Pop\Record\Record;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class DbTest extends \PHPUnit_Framework_TestCase
{

    public function testGetDbException()
    {
        $this->setExpectedException('Pop\Record\Exception');
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

}

