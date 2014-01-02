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
namespace PopTest\Graph;

use Pop\Loader\Autoloader;
use Pop\Color\Space\Rgb;
use Pop\Graph\Graph;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class GraphTest extends \PHPUnit_Framework_TestCase
{

    protected $imageOptions = array(
        'filename' => 'graph.gif',
        'width'    => 640,
        'height'   => 480
    );

    protected $pdfOptions = array(
        'filename' => 'graph.pdf',
        'width'    => 640,
        'height'   => 480
    );

    protected $svgOptions = array(
        'filename' => 'graph.svg',
        'width'    => 640,
        'height'   => 480
    );

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Graph\Graph', new Graph($this->imageOptions, Graph::FORCE_GD));
        $this->assertInstanceOf('Pop\Graph\Graph', new Graph($this->imageOptions));
        $this->assertInstanceOf('Pop\Graph\Graph', new Graph($this->pdfOptions));
        $this->assertInstanceOf('Pop\Graph\Graph', new Graph($this->svgOptions));
    }

    public function testAdapter()
    {
        $g = new Graph($this->imageOptions, Graph::FORCE_GD);
        $this->assertInstanceOf('Pop\Image\Gd', $g->adapter());
    }

    public function testAddAndSetFont()
    {
        $g = new Graph($this->imageOptions);
        $g->addFont(__DIR__ . '/../tmp/times.ttf');
        $this->assertInstanceOf('Pop\Graph\Graph', $g->setFont('times'));
    }


    public function testAddAndSetFont1()
    {
        $this->setExpectedException('Pop\Graph\Exception');
        $g = new Graph($this->imageOptions);
        $g->addFont(__DIR__ . '/../tmp/times.ttf');
        $g->setFont('bogus');
    }

    public function testAddAndSetFont2()
    {
        $this->setExpectedException('Pop\Graph\Exception');
        $g = new Graph($this->pdfOptions);
        $g->addFont(__DIR__ . '/../tmp/times.ttf');
        $g->setFont('bogus');
    }

    public function testSetAxisOptions()
    {
        $g = new Graph($this->imageOptions);
        $g->setAxisOptions(new Rgb(128, 128, 128), 5);
        $this->assertEquals(new Rgb(128, 128, 128), $g->getAxisColor());
        $this->assertEquals(5, $g->getAxisWidth());
    }

    public function testSetFontSize()
    {
        $g = new Graph($this->imageOptions);
        $g->setFontSize(24);
        $this->assertEquals(24, $g->getFontSize());
    }

    public function testSetFontColor()
    {
        $g = new Graph($this->imageOptions);
        $g->setFontColor(new Rgb(128, 128, 128));
        $this->assertEquals(new Rgb(128, 128, 128), $g->getFontColor());
    }

    public function testSetReverseFontColor()
    {
        $g = new Graph($this->imageOptions);
        $g->setReverseFontColor(new Rgb(128, 128, 128));
        $this->assertEquals(new Rgb(128, 128, 128), $g->getReverseFontColor());
    }

    public function testSetFillColor()
    {
        $g = new Graph($this->imageOptions);
        $g->setFillColor(new Rgb(128, 128, 128));
        $this->assertEquals(new Rgb(128, 128, 128), $g->getFillColor());
    }

    public function testSetStrokeColor()
    {
        $g = new Graph($this->imageOptions);
        $g->setStrokeColor(new Rgb(128, 128, 128));
        $this->assertEquals(new Rgb(128, 128, 128), $g->getStrokeColor());
    }

    public function testSetStrokeWidth()
    {
        $g = new Graph($this->imageOptions);
        $g->setStrokeWidth(5);
        $this->assertEquals(5, $g->getStrokeWidth());
    }

    public function testSetPadding()
    {
        $g = new Graph($this->imageOptions);
        $g->setPadding(50);
        $this->assertEquals(50, $g->getPadding());
    }

    public function testSetBarWidth()
    {
        $g = new Graph($this->imageOptions);
        $g->setBarWidth(5);
        $this->assertEquals(5, $g->getBarWidth());
    }

    public function testShow()
    {
        $g = new Graph($this->imageOptions);
        $g->showText(true)
          ->showX(true, new Rgb(128, 128, 128))
          ->showY(true, new Rgb(128, 128, 128));
        $this->assertInstanceOf('Pop\Graph\Graph', $g);
    }

    public function testAddLineGraph()
    {
        $x = array('1995', '2000', '2005', '2010', '2015');
        $y = array('0M', '50M', '100M', '150M', '200M');

        $data = array(
            array(1995, 0),
            array(1997, 35),
            array(1998, 25),
            array(2002, 100),
            array(2004, 84),
            array(2006, 98),
            array(2007, 76),
            array(2010, 122),
            array(2012, 175),
            array(2015, 162)
        );

        $this->setExpectedException('Pop\Http\Exception');
        $g = new Graph($this->pdfOptions);
        $g->addFont('Arial')
          ->setFontColor(new Rgb(128, 128, 128))
          ->setFillColor(new Rgb(10, 125, 210))
          ->showY(true)
          ->showText(true)
          ->createLineGraph($data, $x, $y)
          ->output();
    }

    public function testAddVBarGraph()
    {
        $x = array('1995', '2000', '2005', '2010', '2015');
        $y = array('0M', '50M', '100M', '150M', '200M');

        $data = array(
            array(5, new Rgb(200, 15, 15)),
            array(25, new Rgb(80, 5, 10)),
            array(100, new Rgb(80, 180, 100)),
            array(76, new Rgb(50, 125, 210)),
            array(175, new Rgb(80, 180, 10))
        );

        $this->setExpectedException('Pop\Http\Exception');
        $g = new Graph($this->pdfOptions);
        $g->addFont('Arial')
          ->setFontColor(new Rgb(128, 128, 128))
          ->setFillColor(new Rgb(10, 125, 210))
          ->showY(true)
          ->showText(true)
          ->createVBarGraph($data, $x, $y)
          ->output();
    }

    public function testAddHBarGraph()
    {
        $x = array('1995', '2000', '2005', '2010', '2015');
        $y = array('0M', '50M', '100M', '150M', '200M');

        $data = array(
            array(5, new Rgb(200, 15, 15)),
            array(25, new Rgb(80, 5, 10)),
            array(100, new Rgb(80, 180, 100)),
            array(76, new Rgb(50, 125, 210)),
            array(175, new Rgb(80, 180, 10))
        );

        $this->setExpectedException('Pop\Http\Exception');
        $g = new Graph($this->pdfOptions);
        $g->addFont('Arial')
          ->setFontColor(new Rgb(128, 128, 128))
          ->setFillColor(new Rgb(10, 125, 210))
          ->showY(true)
          ->showText(true)
          ->createHBarGraph($data, $x, $y)
          ->output();
    }

    public function testAddPieChart()
    {
        $pie = array(
            'x' => 320,
            'y' => 240,
            'w' => 200,
            'h' => 100
        );

        $percents = array(
            array(10, new Rgb(200, 15, 15)),
            array(8, new Rgb(80, 5, 10)),
            array(12, new Rgb(80, 180, 100)),
            array(18, new Rgb(50, 125, 210)),
            array(22, new Rgb(80, 180, 10)),
            array(18, new Rgb(100, 125, 210)),
            array(12, new Rgb(80, 180, 10))
        );

        $this->setExpectedException('Pop\Http\Exception');
        $g = new Graph($this->pdfOptions);
        $g->addFont('Arial')
          ->setFontColor(new Rgb(128, 128, 128))
          ->showText(true)
          ->createPieChart($pie, $percents, 20)
          ->output();
    }

}

