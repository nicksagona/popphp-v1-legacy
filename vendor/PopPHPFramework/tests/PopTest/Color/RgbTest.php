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
    Pop\Color\Rgb;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class RgbTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $r = new Rgb(112, 124, 228);
        $this->assertInstanceOf('Pop\\Color\\Rgb', $r);
        $this->assertEquals(112, $r->getRed());
        $this->assertEquals(124, $r->getGreen());
        $this->assertEquals(228, $r->getBlue());
    }

    public function testConstructorOutOfRange()
    {
        $this->setExpectedException('Pop\\Color\\Exception');
        $r = new Rgb(275, 320, 400);
    }

    public function testGetRgb()
    {
        $r = new Rgb(112, 124, 228);
        $this->assertEquals('112,124,228', (string)$r);
        $this->assertEquals('112,124,228', $r->getRgb(Color::STRING));
        $this->assertEquals(array(112, 124, 228), $r->getRgb(Color::NUM_ARRAY));
        $this->assertEquals(array('r' => 112, 'g' => 124, 'b' => 228), $r->getRgb());
    }

}

