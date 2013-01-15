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

namespace PopTest\Pdf;

use Pop\Loader\Autoloader,
    Pop\Pdf\Object\Object;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ObjectTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Pdf\Object\Object', new Object(1));
    }

    public function testSetAndGetDef()
    {
        $o = new Object(5);
        $o->define('some def /Xobject something');
        $this->assertEquals('some def /Xobject something', $o->getDef());
        $this->assertTrue($o->isXObject());
        $this->assertEquals(40, $o->getByteLength());
    }

    public function testGetStream()
    {
        $o = new Object("<<5 0 obj\nstream\nBlah Blah\nendstreamendobj\n>>");
        $this->assertEquals('Blah Blah', trim($o->getStream()));
    }

    public function testCompress()
    {
        $o = new Object("<<5 0 obj\nstream\nBlah Blah\nendstreamendobj\n>>");
        $o->compress();
        $this->assertContains('<</Length 16 /Filter /FlateDecode>>', (string)$o);
        $this->assertTrue($o->isCompressed());
    }

    public function testSetAndGetPalette()
    {
        $o = new Object("<<5 0 obj\nstream\nBlah Blah\nendstreamendobj\n>>");
        $o->setPalette(true);
        $this->assertTrue($o->isPalette());
    }

}

