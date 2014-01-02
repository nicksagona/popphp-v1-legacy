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
use Pop\Color\Space\Rgb;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class RgbTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $r = new Rgb(112, 124, 228);
        $this->assertInstanceOf('Pop\Color\Space\Rgb', $r);
        $this->assertEquals(112, $r->getRed());
        $this->assertEquals(124, $r->getGreen());
        $this->assertEquals(228, $r->getBlue());
    }

    public function testConstructorOutOfRange()
    {
        $this->setExpectedException('Pop\Color\Space\Exception');
        $r = new Rgb(275, 320, 400);
    }

    public function testGetRgb()
    {
        $r = new Rgb(112, 124, 228);
        $this->assertEquals('112,124,228', (string)$r);
        $this->assertEquals('112,124,228', $r->get(Color::STRING));
        $this->assertEquals(array(112, 124, 228), $r->get(Color::NUM_ARRAY));
        $this->assertEquals(array('r' => 112, 'g' => 124, 'b' => 228), $r->get());
    }

}

