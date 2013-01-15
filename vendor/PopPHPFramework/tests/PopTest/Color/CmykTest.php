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
    Pop\Color\Cmyk;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CmykTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $c = new Cmyk(20, 40, 60, 80);
        $this->assertInstanceOf('Pop\Color\Cmyk', $c);
        $this->assertEquals(20, $c->getCyan());
        $this->assertEquals(40, $c->getMagenta());
        $this->assertEquals(60, $c->getYellow());
        $this->assertEquals(80, $c->getBlack());
    }

    public function testConstructorOutOfRange()
    {
        $this->setExpectedException('Pop\Color\Exception');
        $c = new Cmyk(333, 234, 123, 120);
    }

    public function testGetCmyk()
    {
        $c = new Cmyk(20, 40, 60, 80);
        $this->assertEquals('20,40,60,80', (string)$c);
        $this->assertEquals('20,40,60,80', $c->get(Color::STRING));
        $this->assertEquals(array(20, 40, 60, 80), $c->get(Color::NUM_ARRAY));
        $this->assertEquals(array('c' => 20, 'm' => 40, 'y' => 60, 'k' => 80), $c->get());
    }

}

