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

namespace PopTest\Dir;

use Pop\Loader\Autoloader,
    Pop\Dir\Dir;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class DirTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\\Dir\\Dir', new Dir(__DIR__ . '/../tmp'));
    }

    public function testConstructorException()
    {
        $this->setExpectedException('UnexpectedValueException');
        $d = new Dir(__DIR__ . '/../baddir');
    }

    public function testFiles()
    {
        $d = new Dir(__DIR__ . '/../tmp/');
        $this->assertEquals(12, count($d->files));
        $d = new Dir(__DIR__ . '/../tmp/', true);
        $this->assertEquals(12, count($d->files));
        $d = new Dir(__DIR__ . '/../tmp/', true, true);
        $this->assertEquals(12, count($d->files));
        $d = new Dir(__DIR__ . '/../tmp/', true, true, true);
        $this->assertEquals(12, count($d->files));
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

    public function testMode()
    {
        $d = new Dir(__DIR__ . '/../tmp/');
        $d->setMode(0777);
        $this->assertTrue(is_numeric($d->getMode()));
    }

}

