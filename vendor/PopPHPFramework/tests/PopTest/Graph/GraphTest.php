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

namespace PopTest\Graph;

use Pop\Loader\Autoloader,
    Pop\Color\Rgb,
    Pop\Graph\Graph;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class GraphTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\\Graph\\Graph', new Graph('graph.gif', 640, 480));
        $this->assertInstanceOf('Pop\\Graph\\Graph', new Graph('graph.gif', 640, 480, Graph::IMAGICK));
        $this->assertInstanceOf('Pop\\Graph\\Graph', new Graph('graph.pdf', 640, 480));
        $this->assertInstanceOf('Pop\\Graph\\Graph', new Graph('graph.svg', 640, 480));
    }

    public function testAdapter()
    {
        $g = new Graph('graph.gif', 640, 480);
        $this->assertInstanceOf('Pop\\Image\\Gd', $g->adapter());
    }

    public function testAddAndSetFont()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->addFont(__DIR__ . '/../tmp/times.ttf');
        $this->assertInstanceOf('Pop\\Graph\\Graph', $g->setFont('times'));
    }


    public function testAddAndSetFont1()
    {
        $this->setExpectedException('Pop\\Graph\\Exception');
        $g = new Graph('graph.gif', 640, 480);
        $g->addFont(__DIR__ . '/../tmp/times.ttf');
        $g->setFont('bogus');
    }

    public function testAddAndSetFont2()
    {
        $this->setExpectedException('Pop\\Graph\\Exception');
        $g = new Graph('graph.pdf', 640, 480);
        $g->addFont(__DIR__ . '/../tmp/times.ttf');
        $g->setFont('bogus');
    }

    public function testSetAxisOptions()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->setAxisOptions(new Rgb(128, 128, 128), 5);
        $this->assertEquals(new Rgb(128, 128, 128), $g->getAxisColor());
        $this->assertEquals(5, $g->getAxisWidth());
    }

    public function testSetFontSize()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->setFontSize(24);
        $this->assertEquals(24, $g->getFontSize());
    }

    public function testSetFontColor()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->setFontColor(new Rgb(128, 128, 128));
        $this->assertEquals(new Rgb(128, 128, 128), $g->getFontColor());
    }

    public function testSetReverseFontColor()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->setReverseFontColor(new Rgb(128, 128, 128));
        $this->assertEquals(new Rgb(128, 128, 128), $g->getReverseFontColor());
    }

    public function testSetFillColor()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->setFillColor(new Rgb(128, 128, 128));
        $this->assertEquals(new Rgb(128, 128, 128), $g->getFillColor());
    }

    public function testSetStrokeColor()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->setStrokeColor(new Rgb(128, 128, 128));
        $this->assertEquals(new Rgb(128, 128, 128), $g->getStrokeColor());
    }

    public function testSetStrokeWidth()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->setStrokeWidth(5);
        $this->assertEquals(5, $g->getStrokeWidth());
    }

    public function testSetPadding()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->setPadding(50);
        $this->assertEquals(50, $g->getPadding());
    }

    public function testSetBarWidth()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->setBarWidth(5);
        $this->assertEquals(5, $g->getBarWidth());
    }

    public function testShow()
    {
        $g = new Graph('graph.gif', 640, 480);
        $g->showText(true)
          ->showX(true, new Rgb(128, 128, 128))
          ->showY(true, new Rgb(128, 128, 128));
        $this->assertInstanceOf('Pop\\Graph\\Graph', $g);
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

        $this->setExpectedException('Pop\\Http\\Exception');
        $g = new Graph('graph.pdf', 640, 480, Graph::IMAGICK);
        $g->addFont('Arial')
          ->setFontColor(new Rgb(128, 128, 128))
          ->setFillColor(new Rgb(10, 125, 210))
          ->showY(true)
          ->showText(true)
          ->addLineGraph($data, $x, $y)
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

        $this->setExpectedException('Pop\\Http\\Exception');
        $g = new Graph('graph.pdf', 640, 480, Graph::IMAGICK);
        $g->addFont('Arial')
          ->setFontColor(new Rgb(128, 128, 128))
          ->setFillColor(new Rgb(10, 125, 210))
          ->showY(true)
          ->showText(true)
          ->addVBarGraph($data, $x, $y)
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

        $this->setExpectedException('Pop\\Http\\Exception');
        $g = new Graph('graph.pdf', 640, 480, Graph::IMAGICK);
        $g->addFont('Arial')
          ->setFontColor(new Rgb(128, 128, 128))
          ->setFillColor(new Rgb(10, 125, 210))
          ->showY(true)
          ->showText(true)
          ->addHBarGraph($data, $x, $y)
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

        $this->setExpectedException('Pop\\Http\\Exception');
        $g = new Graph('graph.pdf', 640, 480, Graph::IMAGICK);
        $g->addFont('Arial')
          ->setFontColor(new Rgb(128, 128, 128))
          ->showText(true)
          ->addPieChart($pie, $percents, 20)
          ->output();
    }

}

