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

namespace PopTest\Color;

use Pop\Loader\Autoloader,
    Pop\Color\Color,
    Pop\Color\Lab;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class LabTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $l = new Lab(100, 100, 100);
        $this->assertInstanceOf('Pop\Color\Lab', $l);
        $this->assertEquals(100, $l->getL());
        $this->assertEquals(100, $l->getA());
        $this->assertEquals(100, $l->getB());
    }

    public function testConstructorOutOfRange()
    {
        $this->setExpectedException('Pop\Color\Exception');
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

