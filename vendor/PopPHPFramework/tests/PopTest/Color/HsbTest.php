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
use Pop\Color\Space\Hsb;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class HsbTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $h = new Hsb(180, 50, 50);
        $this->assertInstanceOf('Pop\Color\Space\Hsb', $h);
        $this->assertEquals(180, $h->getHue());
        $this->assertEquals(50, $h->getSaturation());
        $this->assertEquals(50, $h->getBrightness());
    }

    public function testConstructorOutOfRange()
    {
        $this->setExpectedException('Pop\Color\Space\Exception');
        $h = new Hsb(400, 120, 150);
    }

    public function testGetHsb()
    {
        $h = new Hsb(180, 50, 50);
        $this->assertEquals('180,50,50', (string)$h);
        $this->assertEquals('180,50,50', $h->get(Color::STRING));
        $this->assertEquals(array(180, 50, 50), $h->get(Color::NUM_ARRAY));
        $this->assertEquals(array('h' => 180, 's' => 50, 'b' => 50), $h->get());
    }

}

