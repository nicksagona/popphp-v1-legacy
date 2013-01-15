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

namespace PopTest\Data;

use Pop\Loader\Autoloader,
    Pop\File\File,
    Pop\Data\Type\Sql;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class SqlTest extends \PHPUnit_Framework_TestCase
{

    public function testDecode()
    {
        $f = new File(__DIR__ . '/../tmp/test.sql');
        $s = Sql::decode($f->read());
        $keys = array('id', 'username', 'password', 'email', 'access');
        $this->assertEquals(9, count($s));
        $this->assertEquals($keys, array_keys($s['row_1']));
    }

    public function testEncode()
    {
        $ary = array(
            array('Name' => 'Test1', 'Num' => 1),
            array('Name' => 'Test2', 'Num' => 2),
            array('Name' => 'Test2', 'Num' => 2),
            array('Name' => 'Test2', 'Num' => 2),
            array('Name' => 'Test2', 'Num' => 2),
            array('Name' => 'Test2', 'Num' => 2),
            array('Name' => 'Test2', 'Num' => 2),
            array('Name' => 'Test2', 'Num' => 2),
            array('Name' => 'Test2', 'Num' => 2),
            array('Name' => 'Test2', 'Num' => 2)
        );
        $s = Sql::encode($ary, null, null, 5);
        $this->assertContains('INSERT INTO data (Name, Num) VALUES', $s);
    }

}

