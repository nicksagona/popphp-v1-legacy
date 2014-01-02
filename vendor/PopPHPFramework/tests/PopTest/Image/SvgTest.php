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
use Pop\Image\Svg;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class SvgTest extends \PHPUnit_Framework_TestCase
{

    public function testSvgConstructor()
    {
        $this->assertInstanceOf('Pop\Image\Svg', new Svg('graph.svg', 640, 480, new Rgb(255, 0, 0)));
    }

    public function testGdConstructorException()
    {
        $this->setExpectedException('Pop\Image\Exception');
        $i = new Svg('graph.svg');
    }

    public function testSvgConstructorUnits()
    {
        $s = new Svg('graph.svg', '5in', '4in', new Rgb(255, 0, 0));
        $s = new Svg('graph.svg', '90%', '90%', new Rgb(255, 0, 0));
    }

    public function testSvgConstructorFromFile()
    {
        $s = new Svg(__DIR__ . '/../tmp/test.svg');
        $this->assertEquals(640, $s->getWidth());
        $this->assertEquals(480, $s->getHeight());
    }

    public function testImageAttributes()
    {
        $s = new Svg('graph.svg', '640px', '480px', new Rgb(255, 0, 0));
        $s->setFillColor(new Rgb(255, 0, 0));
        $s->setBackgroundColor(new Rgb(0, 0, 255));
        $s->setStrokeColor(new Rgb(0, 0, 0));
        $s->setStrokeWidth();
        $s->setStrokeWidth(5, 6, 4);
        $s->setOpacity(50);
        $this->assertEquals(640, $s->getWidth());
        $this->assertEquals(480, $s->getHeight());
        $this->assertEquals('px', $s->getUnits());
    }

    public function testGradients()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->addGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255));
        $s->addGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255), Svg::VERTICAL);
        $s->addGradient(new Rgb(255, 0, 0), new Rgb(0, 0, 255), Svg::RADIAL);
        $s->setGradient(0);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddClippingRectangle()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->drawClippingRectangle(10, 10, 320, 240);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddClippingSquare()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->drawClippingSquare(10, 10, 240);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddClippingEllipse()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->drawClippingEllipse(10, 10, 320, 240)
          ->setClippingPath(0);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddClippingCircle()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->drawClippingCircle(10, 10, 240);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddClippingPolygon()
    {
        $points = array(
            array('x' => 320, 'y' => 50),
            array('x' => 400, 'y' => 100),
            array('x' => 420, 'y' => 200),
            array('x' => 280, 'y' => 320),
            array('x' => 200, 'y' => 180)
        );
        $s = new Svg('graph.svg', '640px', '480px');
        $s->drawClippingPolygon($points)
          ->setClippingPath(0);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testText()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->setFillColor(new Rgb(255, 0, 0));
        $s->text('Hello World', 36, 10, 100, 'Arial', 10, true);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddLine()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->drawLine(10, 10, 100, 100);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddRectangle()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->setStrokeColor(new Rgb(0, 0, 0))
          ->drawRectangle(10, 10, 100, 100);
        $s->setBackgroundColor(new Rgb(255, 0, 0));
        $s->drawRectangle(10, 10, 100, 100);
        $s->setFillColor(new Rgb(255, 0, 0));
        $s->drawRectangle(10, 10, 100, 100);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddSquare()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->drawSquare(10, 10, 100);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddEllipse()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->setStrokeColor(new Rgb(0, 0, 0))
          ->drawEllipse(10, 10, 100, 100);
        $s->setBackgroundColor(new Rgb(255, 0, 0));
        $s->drawEllipse(10, 10, 100, 100);
        $s->setFillColor(new Rgb(255, 0, 0));
        $s->drawEllipse(10, 10, 100, 100);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddCircle()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->drawCircle(10, 10, 100);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddArc()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->setStrokeColor(new Rgb(0, 0, 0))
          ->drawArc(320, 240, 0, 120, 100);
        $s->setBackgroundColor(new Rgb(255, 0, 0));
        $s->drawArc(320, 240, 0, 120, 100, 100);
        $s->setFillColor(new Rgb(255, 0, 0));
        $s->drawArc(320, 240, 0, 120, 100, 100);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testAddPolygon()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $points = array(
            array('x' => 320, 'y' => 50),
            array('x' => 400, 'y' => 100),
            array('x' => 420, 'y' => 200),
            array('x' => 280, 'y' => 320),
            array('x' => 200, 'y' => 180)
        );
        $s->setStrokeColor(new Rgb(0, 0, 0))
          ->drawPolygon($points);
        $s->setBackgroundColor(new Rgb(255, 0, 0));
        $s->drawPolygon($points);
        $s->setFillColor(new Rgb(255, 0, 0));
        $s->drawPolygon($points);
        $this->assertEquals(640, $s->getWidth());
    }

    public function testBorder()
    {
        $s = new Svg('graph.svg', '640px', '480px');
        $s->setStrokeWidth(5, 6, 4);
        $s->border(5);
        $this->assertEquals(640, $s->getWidth());
    }

}

