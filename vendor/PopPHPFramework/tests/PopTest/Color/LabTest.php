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
use Pop\Color\Space\Lab;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class LabTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $l = new Lab(100, 100, 100);
        $this->assertInstanceOf('Pop\Color\Space\Lab', $l);
        $this->assertEquals(100, $l->getL());
        $this->assertEquals(100, $l->getA());
        $this->assertEquals(100, $l->getB());
    }

    public function testConstructorOutOfRange()
    {
        $this->setExpectedException('Pop\Color\Space\Exception');
        $l = new Lab(120, 150, 150);
    }

    public function testGetLab()
    {
        $l = new Lab(100, 100, 100);
        $this->assertEquals('100,100,100', (string)$l);
        $this->assertEquals('100,100,100', $l->get(Color::STRING));
        $this->assertEquals(array(100, 100, 100), $l->get(Color::NUM_ARRAY));
        $this->assertEquals(array('l' => 100, 'a' => 100, 'b' => 100), $l->get());
    }

}

