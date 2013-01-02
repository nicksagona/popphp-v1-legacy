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

namespace PopTest\Image;

use Pop\Loader\Autoloader,
    Pop\Color\Rgb,
    Pop\Image\Gd;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class GdTest extends \PHPUnit_Framework_TestCase
{

    public function testGdConstructor()
    {
        $this->assertInstanceOf('Pop\Image\Gd', new Gd('graph.gif', 640, 480));
        $this->assertInstanceOf('Pop\Image\Gd', new Gd('graph.jpg', 640, 480));
    }

    public function testGdConstructorException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $i = new Gd('graph.gif');
    }

    public function testImageAttributes()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->setFillColor(new Rgb(255, 0, 0));
        $i->setStrokeColor(new Rgb(0, 0, 255));
        $i->setStrokeWidth(5);
        $this->assertEquals(640, $i->getWidth());
        $this->assertEquals(480, $i->getHeight());
        $this->assertEquals(3, $i->getChannels());
        $this->assertEquals(8, $i->getDepth());
        $this->assertEquals('RGB', $i->getColorMode());
        $this->assertFalse($i->hasAlpha());
    }

    public function testPng()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.png');
        $i->setQuality(75)
          ->setOpacity(50)
          ->resizeToWidth(240);
        $this->assertEquals(240, $i->getWidth());
    }

    public function testGif()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.gif');
        $i->resizeToHeight(120);
        $this->assertEquals(120, $i->getHeight());
    }

    public function testResize()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->resize(240);
        $this->assertEquals(240, $i->getWidth());
    }

    public function testScale()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->scale(0.1);
        $this->assertEquals(64, $i->getWidth());
    }

    public function testCrop()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->crop(100, 50);
        $this->assertEquals(100, $i->getWidth());
    }

    public function testCropThumb()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->cropThumb(50);
        $this->assertEquals(50, $i->getWidth());
    }

    public function testRotate()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->setBackgroundColor(new Rgb(255, 0, 0))
          ->rotate(45)
          ->save(__DIR__ . '/../tmp/test2.jpg');
        $this->assertEquals(792, $i->getWidth());
        unlink(__DIR__ . '/../tmp/test2.jpg');
    }

    public function testText()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->text('Hello World', 36, 10, 100, __DIR__ . '/../tmp/times.ttf', 10, true);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testSystemText()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->text('Hello World', 36, 10, 100);
        $this->assertEquals(640, $i->getWidth());
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->text('Hello World', 0, 10, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddLine()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->addLine(10, 10, 100, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddRectangle()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->setStrokeColor(new Rgb(0, 0, 0))
          ->addRectangle(10, 10, 100, 100);
        $i->setBackgroundColor(new Rgb(255, 0, 0));
        $i->addRectangle(10, 10, 100, 100);
        $i->setFillColor(new Rgb(255, 0, 0));
        $i->addRectangle(10, 10, 100, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddSquare()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->addSquare(10, 10, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddEllipse()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->setStrokeColor(new Rgb(0, 0, 0))
          ->addEllipse(10, 10, 100, 100);
        $i->setBackgroundColor(new Rgb(255, 0, 0));
        $i->addEllipse(10, 10, 100, 100);
        $i->setFillColor(new Rgb(255, 0, 0));
        $i->addEllipse(10, 10, 100, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddCircle()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->addCircle(10, 10, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddArc()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->setStrokeColor(new Rgb(0, 0, 0))
          ->addArc(320, 240, 0, 120, 100, 100);
        $i->setBackgroundColor(new Rgb(255, 0, 0));
        $i->addArc(320, 240, 0, 120, 100, 100);
        $i->setFillColor(new Rgb(255, 0, 0));
        $i->addArc(320, 240, 0, 120, 100, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddPolygon()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $points = array(
            array('x' => 320, 'y' => 50),
            array('x' => 400, 'y' => 100),
            array('x' => 420, 'y' => 200),
            array('x' => 280, 'y' => 320),
            array('x' => 200, 'y' => 180)
        );
        $i->setStrokeColor(new Rgb(0, 0, 0))
          ->addPolygon($points);
        $i->setBackgroundColor(new Rgb(255, 0, 0));
        $i->addPolygon($points);
        $i->setFillColor(new Rgb(255, 0, 0));
        $i->addPolygon($points);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testFilters()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->brightness(50)
          ->contrast(50)
          ->desaturate()
          ->sharpen(10)
          ->blur(10)
          ->border(5, 5)
          ->border(5, 5, Gd::OUTER_BORDER)
          ->overlay(__DIR__ . '/../tmp/test.png')
          ->colorize(new Rgb(255, 0, 0))
          ->invert()
          ->pixelate(10)
          ->pencil();
        $this->assertEquals(640, $i->getWidth());
    }

    public function testColorTotal()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.gif');
        $this->assertEquals(16, $i->colorTotal());
    }

    public function testGetColors()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.gif');
        $hex = $i->getColors();
        $rgb = $i->getColors('RGB');
        $this->assertEquals(16, count($hex));
        $this->assertEquals(16, count($rgb));
        $this->assertTrue(in_array('113405', $hex));
        $this->assertTrue(in_array('17,52,5', $rgb));
    }

    public function testConvert()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.gif');
        $i->convert('png');
        $this->assertEquals(640, $i->getWidth());
        $i = new Gd(__DIR__ . '/../tmp/test.png');
        $i->convert('gif');
        $this->assertEquals(640, $i->getWidth());
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->convert('png');
        $this->assertEquals(640, $i->getWidth());
    }

    public function testConvertExceptionBadType()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $i = new Gd(__DIR__ . '/../tmp/test.gif');
        $i->convert('tif');
    }

    public function testConvertExceptionDupeType()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $i = new Gd(__DIR__ . '/../tmp/test.gif');
        $i->convert('gif');
    }

}

