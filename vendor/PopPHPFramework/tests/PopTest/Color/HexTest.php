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
namespace PopTest\Color;

use Pop\Loader\Autoloader;
use Pop\Color\Color;
use Pop\Color\Space\Hex;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class HexTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $h = new Hex('#ee1c2d');
        $this->assertInstanceOf('Pop\Color\Space\Hex', $h);
        $this->assertEquals('ee', $h->getRed());
        $this->assertEquals('1c', $h->getGreen());
        $this->assertEquals('2d', $h->getBlue());

        $h = new Hex('#def');
        $this->assertInstanceOf('Pop\Color\Space\Hex', $h);
        $this->assertEquals('dd', $h->getRed());
        $this->assertEquals('ee', $h->getGreen());
        $this->assertEquals('ff', $h->getBlue());
    }

    public function testConstructorOutOfRange()
    {
        $this->setExpectedException('Pop\Color\Space\Exception');
        $h = new Hex('#gggggg');
    }

    public function testGetHex()
    {
        $h = new Hex('#ee1c2d');
        $this->assertEquals('#ee1c2d', (string)$h);
        $this->assertTrue(is_array($h->get(Color::ASSOC_ARRAY)));
        $this->assertTrue(is_array($h->get(Color::NUM_ARRAY)));
        $this->assertEquals('#ee1c2d', $h->get(Color::STRING, true));
        $h = new Hex('#def');
        $this->assertEquals('def', $h->get(Color::STRING, false, true));
    }

}

