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
    Pop\Color\Cmyk,
    Pop\Color\Hex,
    Pop\Color\Hsb,
    Pop\Color\Lab,
    Pop\Color\Rgb;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ColorTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructorAndFactory()
    {
        $this->assertInstanceOf('Pop\\Color\\Color', new Color(new Rgb(112, 124, 228)));
        $this->assertInstanceOf('Pop\\Color\\Color', Color::factory(new Cmyk(20, 40, 60, 80)));
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

    public function testConvertCmykException()
    {
        $this->setExpectedException('Pop\\Color\\Exception');
        $c = Color::factory()->convertToCmyk(new Cmyk(20, 40, 60, 80));
    }

    public function testConvertHexException()
    {
        $this->setExpectedException('Pop\\Color\\Exception');
        $c = Color::factory()->convertToHex(new Hex('#ee1c2d'));
    }

    public function testConvertHsbException()
    {
        $this->setExpectedException('Pop\\Color\\Exception');
        $c = Color::factory()->convertToHsb(new Hsb(180, 50, 50));
    }

    public function testConvertLabException()
    {
        $this->setExpectedException('Pop\\Color\\Exception');
        $c = Color::factory()->convertToLab(new Lab(100, 100, 100));
    }

    public function testConvertRgbException()
    {
        $this->setExpectedException('Pop\\Color\\Exception');
        $c = Color::factory()->convertToRgb(new Rgb(112, 124, 228));
    }

    public function testRgbToCmyk()
    {
        $cmyk = Color::factory()->rgbToCmyk(new Rgb(0, 0, 0));
        $this->assertInstanceOf('Pop\\Color\\Cmyk', $cmyk);
        $this->assertEquals('0,0,0,100', (string)$cmyk);
    }

    public function testHsbToRgb()
    {
        $rgb = Color::factory()->hsbToRgb(new Hsb(180, 50, 50));
        $this->assertInstanceOf('Pop\\Color\\Rgb', $rgb);
        $this->assertEquals('64,128,64', (string)$rgb);
    }

    public function testHsbToHex()
    {
        $hex = Color::factory()->hsbToHex(new Hsb(180, 50, 50));
        $this->assertInstanceOf('Pop\\Color\\Hex', $hex);
        $this->assertEquals('#408040', (string)$hex);
    }

    public function testHsbToCmyk()
    {
        $cmyk = Color::factory()->hsbToCmyk(new Hsb(180, 50, 50));
        $this->assertInstanceOf('Pop\\Color\\Cmyk', $cmyk);
        $this->assertEquals('50,0,50,50', (string)$cmyk);
    }

    public function testHsbToLab()
    {
        $lab = Color::factory()->hsbToLab(new Hsb(180, 50, 50));
        $this->assertInstanceOf('Pop\\Color\\Lab', $lab);
        $this->assertEquals('48,-34,28', (string)$lab);
    }

    public function testLabToRgb()
    {
        $rgb = Color::factory()->labToRgb(new Lab(100, 100, 100));
        $this->assertInstanceOf('Pop\\Color\\Rgb', $rgb);
        $this->assertEquals('195,146,49', (string)$rgb);
    }

    public function testLabToHex()
    {
        $hex = Color::factory()->labToHex(new Lab(100, 100, 100));
        $this->assertInstanceOf('Pop\\Color\\Hex', $hex);
        $this->assertEquals('#c39231', (string)$hex);
    }

    public function testLabToCmyk()
    {
        $cmyk = Color::factory()->labToCmyk(new Lab(100, 100, 100));
        $this->assertInstanceOf('Pop\\Color\\Cmyk', $cmyk);
        $this->assertEquals('0,25,75,24', (string)$cmyk);
    }

    public function testLabToHsb()
    {
        $hsb = Color::factory()->labToHsb(new Lab(100, 100, 100));
        $this->assertInstanceOf('Pop\\Color\\Hsb', $hsb);
        $this->assertEquals('40,75,76', (string)$hsb);
    }

    public function testMagicMethods()
    {
        $c = new Color(new Rgb(112, 124, 228));
        $this->assertTrue(isset($c->cmyk));
        $this->assertInstanceOf('Pop\\Color\\Cmyk', $c->cmyk);
        unset($c->cmyk);
        $this->assertFalse(isset($c->cmyk));
    }

}

