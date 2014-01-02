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
namespace PopTest\File;

use Pop\Loader\Autoloader;
use Pop\File\File;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class FileTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $f = new File(__DIR__ . '/test.txt');
        $this->assertInstanceOf('Pop\File\File', $f);
        $this->assertContains('File', $f->getDir());
        $this->assertTrue($f->isFile());
        $this->assertFalse($f->isDir());
    }

    public function testCheckDupe()
    {
        $f = File::checkDupe('access.txt', __DIR__ . '/../tmp');
        $this->assertEquals('access_1.txt', $f);
        $f = File::checkDupe('access.txt');
        $this->assertEquals('access.txt', $f);
    }

    public function testRead()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');
        $this->assertContains('12test34', $f->read());
        $this->assertEquals('stus', $f->read(2, 4));
    }

    public function testAllowedTypes()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt', array('txt' => 'text/plain'));
        $this->assertFalse($f->isAllowed('php'));
        $this->assertTrue(is_array($f->getAllowedTypes()));
        $f->setAllowedTypes(array('txt' => 'text/plain', 'php' => 'text/plain'));
        $f->addAllowedTypes(array('sql' => 'text/plain'));
        $this->assertTrue($f->isAllowed('php'));
    }

    public function testSetMime()
    {
        $f = new File('accesslog');
        $f->setMime('text/plain');
        $this->assertEquals('text/plain', $f->getMime());
    }

    public function testSetMimeException()
    {
        $this->setExpectedException('Pop\File\Exception');
        $f = new File('accesslog.txt');
        $f->setMime('bad/mime');
    }

    public function testSetAndGetPermissions()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');

        if (DIRECTORY_SEPARATOR == '/') {
            $this->assertEquals(777, $f->getPermissions());
            $f->setPermissions(0775);
            $this->assertEquals(775, $f->getPermissions());
            $f->setPermissions(0777);
            $this->assertEquals(777, $f->getPermissions());
            $this->assertEquals(777, $f->getDirPermissions());
            $f->setDirPermissions(0775, true);
            $this->assertEquals(775, $f->getDirPermissions());
            $f->setDirPermissions(0777);
        }
    }

    public function testGetOwnerAndGroup()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');
        $this->assertTrue(array_key_exists('name', $f->getOwner()));
        $this->assertTrue(array_key_exists('name', $f->getDirOwner()));
        $this->assertTrue(array_key_exists('name', $f->getGroup()));
        $this->assertTrue(array_key_exists('name', $f->getDirGroup()));
        $this->assertTrue(array_key_exists('name', $f->getUser()));
    }

    public function testCopyAndMove()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');
        $f->copy(__DIR__ . '/../tmp/access2.txt');
        $this->fileExists(__DIR__ . '/../tmp/access2.txt');
        $f->move(__DIR__ . '/../tmp/access3.txt');
        $this->fileExists(__DIR__ . '/../tmp/access3.txt');
        unlink(__DIR__ . '/../tmp/access3.txt');
    }

    public function testCopyException()
    {
        $this->setExpectedException('Pop\File\Exception');
        $f = new File('access.txt');
        $f->copy(__DIR__ . '/../tmp/access.txt');
    }

    public function testMoveException()
    {
        $this->setExpectedException('Pop\File\Exception');
        $f = new File('access.txt');
        $f->move(__DIR__ . '/../tmp/access.txt');
    }

    public function testReadNewFile()
    {
        $f = new File(__DIR__ . '/../tmp/file.txt');
        $f->write('123456');
        $this->assertEquals('345', $f->read(2, 3));
    }

    public function testWrite()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');
        $f->write('123456', true);
        $this->assertContains('123456', $f->read());
    }

    public function testAppend()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');
        $f->append('123456');
        $f->append('789');
        $this->assertContains('123456789', $f->read());
    }

    public function testOutput()
    {
        if (file_exists(__DIR__ . '/../tmp/file.txt')) {
            unlink(__DIR__ . '/../tmp/file.txt');
        }

        $f = new File(__DIR__ . '/../tmp/file.txt');
        $f->write('123');
        $this->setExpectedException('Pop\Http\Exception');
        $f->output();
    }

    public function testWriteSaveAndDelete()
    {
        if (file_exists(__DIR__ . '/../tmp/file.txt')) {
            unlink(__DIR__ . '/../tmp/file.txt');
        }

        $f = new File(__DIR__ . '/../tmp/file.txt');
        $f->write('123')
          ->write('456', true)
          ->save();
        $f->setPermissions(0777);

        $this->fileExists(__DIR__ . '/../tmp/file.txt');
        $this->assertEquals('123456', $f->read());
        $this->assertEquals(6, $f->getSize());
        $this->assertEquals('text/plain', $f->getMime());

        $f->delete();
        $this->assertFalse(file_exists(__DIR__ . '/../tmp/file.txt'));

    }

}

