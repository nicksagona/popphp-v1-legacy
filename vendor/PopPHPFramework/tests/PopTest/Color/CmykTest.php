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
use Pop\Color\Space\Cmyk;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CmykTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $c = new Cmyk(20, 40, 60, 80);
        $this->assertInstanceOf('Pop\Color\Space\Cmyk', $c);
        $this->assertEquals(20, $c->getCyan());
        $this->assertEquals(40, $c->getMagenta());
        $this->assertEquals(60, $c->getYellow());
        $this->assertEquals(80, $c->getBlack());
    }

    public function testConstructorOutOfRange()
    {
        $this->setExpectedException('Pop\Color\Space\Exception');
        $c = new Cmyk(333, 234, 123, 120);
    }

    public function testGetCmyk()
    {
        $c = new Cmyk(20, 40, 60, 80);
        $this->assertEquals('20,40,60,80', (string)$c);
        $this->assertEquals('20,40,60,80', $c->get(Color::STRING));
        $this->assertEquals(array(20, 40, 60, 80), $c->get(Color::NUM_ARRAY));
        $this->assertEquals(array('c' => 20, 'm' => 40, 'y' => 60, 'k' => 80), $c->get());
    }

}

