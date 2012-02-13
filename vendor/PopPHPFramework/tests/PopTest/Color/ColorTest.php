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

class ColorTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $c = new Color(new Rgb(112, 124, 228));
        $class = 'Pop\\Color\\Color';
        $this->assertTrue($c instanceof $class);
    }

    public function testConvert()
    {
        $c = new Color(new Rgb(112, 124, 228));
        $this->assertEquals(51, $c->cmyk->getCyan());
        $this->assertEquals(46, $c->cmyk->getMagenta());
        $this->assertEquals(0, $c->cmyk->getYellow());
        $this->assertEquals(11, $c->cmyk->getBlack());
        $this->assertEquals('70', $c->hex->getRed());
        $this->assertEquals('7c', $c->hex->getGreen());
        $this->assertEquals('e4', $c->hex->getBlue());
        $this->assertEquals(234, $c->hsb->getHue());
        $this->assertEquals(51, $c->hsb->getSaturation());
        $this->assertEquals(89, $c->hsb->getBrightness());
        $this->assertEquals(55, $c->lab->getL());
        $this->assertEquals(23, $c->lab->getA());
        $this->assertEquals(-54, $c->lab->getB());
    }

}

