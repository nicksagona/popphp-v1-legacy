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
    Pop\Data\Data;

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

}

