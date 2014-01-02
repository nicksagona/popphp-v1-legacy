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
namespace PopTest\Pdf;

use Pop\Loader\Autoloader;
use Pop\Pdf\Object\Object;

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

