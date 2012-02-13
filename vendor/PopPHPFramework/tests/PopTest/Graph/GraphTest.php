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
        $g = new Graph('graph.gif', 640, 480);
        $class = 'Pop\\Graph\\Graph';
        $this->assertTrue($g instanceof $class);
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

}

