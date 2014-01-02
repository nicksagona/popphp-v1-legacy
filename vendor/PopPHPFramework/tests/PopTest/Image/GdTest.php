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
namespace PopTest\Image;

use Pop\Loader\Autoloader;
use Pop\Color\Space\Rgb;
use Pop\Image\Gd;

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

    public function testGetImageResource()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->setStrokeColor(new Rgb(0, 0, 0))
            ->drawRectangle(10, 10, 100, 100);
        $this->assertNotNull($i->resource());
    }

    public function testImageAttributes()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->setCompression(75);
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

    public function testImageFormats()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $this->assertEquals(5, count($i->getFormats()));
        $this->assertEquals(5, $i->getNumberOfFormats());
    }

    public function testStaticImageFormats()
    {
        $this->assertEquals(5, count(Gd::formats()));
    }

    public function testDummyMethods()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->flip();
        $i->flop();
        $this->assertInstanceOf('Pop\Image\Gd', $i->setFilter());
        $this->assertInstanceOf('Pop\Image\Gd', $i->setBlur());
        $this->assertInstanceOf('Pop\Image\Gd', $i->setOverlay());
        $this->assertInstanceOf('Pop\Image\Gd', $i->hue(100));
        $this->assertInstanceOf('Pop\Image\Gd', $i->saturation(100));
        $this->assertInstanceOf('Pop\Image\Gd', $i->hsb(100, 100, 1000));
        $this->assertInstanceOf('Pop\Image\Gd', $i->level(0, 0 ,0));
        $this->assertInstanceOf('Pop\Image\Gd', $i->flatten());
        $this->assertInstanceOf('Pop\Image\Gd', $i->paint(10));
        $this->assertInstanceOf('Pop\Image\Gd', $i->posterize(10));
        $this->assertInstanceOf('Pop\Image\Gd', $i->noise());
        $this->assertInstanceOf('Pop\Image\Gd', $i->diffuse(10));
        $this->assertInstanceOf('Pop\Image\Gd', $i->skew(new Rgb(255, 0, 0), 10, 10));
        $this->assertInstanceOf('Pop\Image\Gd', $i->swirl(10));
        $this->assertInstanceOf('Pop\Image\Gd', $i->wave(10, 10));
        $this->assertInstanceOf('Pop\Image\Gd', $i->setFormats());
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
        $i->drawLine(10, 10, 100, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddRectangle()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->setStrokeColor(new Rgb(0, 0, 0))
          ->drawRectangle(10, 10, 100, 100);
        $i->setBackgroundColor(new Rgb(255, 0, 0));
        $i->drawRectangle(10, 10, 100, 100);
        $i->setFillColor(new Rgb(255, 0, 0));
        $i->drawRectangle(10, 10, 100, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddSquare()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->drawSquare(10, 10, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddEllipse()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->setStrokeColor(new Rgb(0, 0, 0))
          ->drawEllipse(10, 10, 100, 100);
        $i->setBackgroundColor(new Rgb(255, 0, 0));
        $i->drawEllipse(10, 10, 100, 100);
        $i->setFillColor(new Rgb(255, 0, 0));
        $i->drawEllipse(10, 10, 100, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddCircle()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->drawCircle(10, 10, 100);
        $this->assertEquals(640, $i->getWidth());
    }

    public function testAddArc()
    {
        $i = new Gd(__DIR__ . '/../tmp/test.jpg');
        $i->setStrokeColor(new Rgb(0, 0, 0))
          ->drawArc(320, 240, 0, 120, 100, 100);
        $i->setBackgroundColor(new Rgb(255, 0, 0));
        $i->drawArc(320, 240, 0, 120, 100, 100);
        $i->setFillColor(new Rgb(255, 0, 0));
        $i->drawArc(320, 240, 0, 120, 100, 100);
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
          ->drawPolygon($points);
        $i->setBackgroundColor(new Rgb(255, 0, 0));
        $i->drawPolygon($points);
        $i->setFillColor(new Rgb(255, 0, 0));
        $i->drawPolygon($points);
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
        $rgb = $i->getColors(false);
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

