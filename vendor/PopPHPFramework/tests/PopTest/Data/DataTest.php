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
use Pop\Data\Data;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class DataTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Data\Data', new Data(__DIR__ . '/../tmp/test.sql'));
    }

    public function testData()
    {
        $d = new Data(__DIR__ . '/../tmp/test.sql');
        $ary = $d->parseFile();
        $keys = array('id', 'username', 'password', 'email', 'access');
        $this->assertEquals(9, count($ary));
        $this->assertEquals($keys, array_keys($ary['row_1']));
    }

    public function testGetFile()
    {
        $d = new Data(__DIR__ . '/../tmp/test.sql');
        $this->assertContains('INSERT INTO', $d->getFile());
    }

    public function testGetData()
    {
        $d = new Data('<users><row><name>Test></name></row></users>');
        $this->assertContains('<users>', $d->getData());
    }

    public function testSetAndGetTable()
    {
        $d = new Data(__DIR__ . '/../tmp/test.sql');
        $d->setTable('users');
        $this->assertEquals('users', $d->getTable());
    }

    public function testSetAndGetIdQuote()
    {
        $d = new Data(__DIR__ . '/../tmp/test.sql');
        $d->setIdQuote('`');
        $this->assertEquals('`', $d->getIdQuote());
    }

    public function testSetAndGetPma()
    {
        $d = new Data(__DIR__ . '/../tmp/test.sql');
        $d->setPma(true);
        $this->assertTrue($d->getPma());
    }

    public function testParseDataException()
    {
        $ary = array(
            array('name' => 'Test1', 'email' => 'test1@test.com'),
            array('name' => 'Test2', 'email' => 'test2@test.com')
        );
        $d = new Data($ary);
        $this->setExpectedException('Pop\Data\Exception');
        $d->parseData('txt');
    }

    public function testParseData()
    {
        $ary = array(
            array('name' => 'Test1', 'email' => 'test1@test.com'),
            array('name' => 'Test2', 'email' => 'test2@test.com')
        );
        $d = new Data($ary);
        $d->setTable('users')
          ->setIdQuote('`');
        $this->assertContains('INSERT INTO `users` (`name`, `email`) VALUES', $d->parseData('sql'));
        $this->assertContains('<name>Test1</name>', $d->parseData('xml'));
        $this->assertContains('Test1,test1@test.com', $d->parseData('csv'));
    }

    public function testWriteData()
    {
        $ary = array(
            array('name' => 'Test1', 'email' => 'test1@test.com'),
            array('name' => 'Test2', 'email' => 'test2@test.com')
        );
        $d = Data::factory($ary)->writeData(__DIR__ . '/../tmp/datatest.csv');
        $d = Data::factory($ary)->writeData(__DIR__ . '/../tmp/datatest.sql');
        $d = Data::factory($ary)->writeData(__DIR__ . '/../tmp/datatest.xml');
        $d = Data::factory($ary)->writeData(__DIR__ . '/../tmp/datatest.json');
        $d = Data::factory($ary)->writeData(__DIR__ . '/../tmp/datatest.yml');
        $this->assertFileExists(__DIR__ . '/../tmp/datatest.csv');
        $this->assertFileExists(__DIR__ . '/../tmp/datatest.sql');
        $this->assertFileExists(__DIR__ . '/../tmp/datatest.xml');
        $this->assertFileExists(__DIR__ . '/../tmp/datatest.json');
        $this->assertFileExists(__DIR__ . '/../tmp/datatest.yml');

        if (file_exists(__DIR__ . '/../tmp/datatest.csv')) {
            unlink(__DIR__ . '/../tmp/datatest.csv');
        }
        if (file_exists(__DIR__ . '/../tmp/datatest.sql')) {
            unlink(__DIR__ . '/../tmp/datatest.sql');
        }
        if (file_exists(__DIR__ . '/../tmp/datatest.xml')) {
            unlink(__DIR__ . '/../tmp/datatest.xml');
        }
        if (file_exists(__DIR__ . '/../tmp/datatest.json')) {
            unlink(__DIR__ . '/../tmp/datatest.json');
        }
        if (file_exists(__DIR__ . '/../tmp/datatest.yml')) {
            unlink(__DIR__ . '/../tmp/datatest.yml');
        }
    }

    public function testWriteDataOutput()
    {
        $ary = array(
            array('name' => 'Test1', 'email' => 'test1@test.com'),
            array('name' => 'Test2', 'email' => 'test2@test.com')
        );
        $this->setExpectedException('Pop\Http\Exception');
        Data::factory($ary)->writeData(__DIR__ . '/../tmp/datatest.csv', true);
    }

    public function testWriteDataException()
    {
        $this->setExpectedException('Pop\Data\Exception');
        $ary = array(
            array('name' => 'Test1', 'email' => 'test1@test.com'),
            array('name' => 'Test2', 'email' => 'test2@test.com')
        );
        $d = Data::factory($ary)->writeData(__DIR__ . '/../tmp/datatest.txt');
    }

}

