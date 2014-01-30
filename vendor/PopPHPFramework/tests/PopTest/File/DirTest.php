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
use Pop\File\Dir;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class DirTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\File\Dir', new Dir(__DIR__ . '/../tmp'));
    }

    public function testConstructorException()
    {
        $this->setExpectedException('UnexpectedValueException');
        $d = new Dir(__DIR__ . '/../baddir');
    }

    public function testFiles()
    {
        $d = new Dir(__DIR__ . '/../tmp/');
        $this->assertEquals(15, count($d->getFiles()));
        $d = new Dir(__DIR__ . '/../tmp/', true);
        $this->assertEquals(15, count($d->getFiles()));
        $d = new Dir(__DIR__ . '/../tmp/', true, true);
        $this->assertEquals(15, count($d->getFiles()));
        $d = new Dir(__DIR__ . '/../tmp/', true, true, true);
        $this->assertEquals(15, count($d->getFiles()));
    }

    public function testGetOwnerAndGroup()
    {
        $d = new Dir(__DIR__ . '/../tmp/');
        $this->assertTrue(array_key_exists('name', $d->getOwner()));
        $this->assertTrue(array_key_exists('name', $d->getGroup()));
        $this->assertTrue(array_key_exists('name', $d->getUser()));
        $this->assertTrue($d->isDir());
        $this->assertFalse($d->isFile());
        $this->assertGreaterThan(1, count($d->getObjects()));
    }

    public function testGetPath()
    {
        $d = new Dir(__DIR__ . '/../tmp/');
        $this->assertContains('tmp', $d->getPath());
    }

    public function testGetSystemTemp()
    {
        $this->assertNotNull(Dir::getSystemTemp());
        $this->assertContains(DIRECTORY_SEPARATOR, Dir::getSystemTemp());
    }

    public function testGetUploadTemp()
    {
        $this->assertNotNull(Dir::getUploadTemp());
        $this->assertContains(DIRECTORY_SEPARATOR, Dir::getUploadTemp());
    }

    public function testGetAndSetPermissions()
    {
        $d = new Dir(__DIR__ . '/../tmp/');
        $this->assertEquals(777, $d->getPermissions());
        $d->setPermissions(0775, true);
        $this->assertEquals(775, $d->getPermissions());
        $d->setPermissions(0777);
    }

}

