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

namespace PopTest\File;

use Pop\Loader\Autoloader,
    Pop\File\File;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class FileTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $f = new File('test.txt');
        $class = 'Pop\\File\\File';
        $this->assertTrue($f instanceof $class);
    }

    public function testRead()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');
        $this->assertContains('12test34', $f->read());
    }

    public function testWriteSaveAndDelete()
    {
        if (file_exists(__DIR__ . '/../tmp/file.txt')) {
            unlink(__DIR__ . '/../tmp/file.txt');
        }

        $f = new File(__DIR__ . '/../tmp/file.txt');
        $f->write('123')->save();
        $f->setMode(0777);

        $this->fileExists(__DIR__ . '/../tmp/file.txt');
        $this->assertEquals('123', $f->read());
        $this->assertEquals(3, $f->getSize());
        $this->assertEquals('text/plain', $f->getMime());

        $f->delete();
        $this->assertFalse(file_exists(__DIR__ . '/../tmp/file.txt'));
    }

}

