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
namespace PopTest\Data;

use Pop\Loader\Autoloader;
use Pop\File\File;
use Pop\Data\Type\Sql;

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

