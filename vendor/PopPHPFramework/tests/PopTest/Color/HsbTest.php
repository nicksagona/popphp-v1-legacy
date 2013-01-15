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
    Pop\Color\Hsb;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class HsbTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $h = new Hsb(180, 50, 50);
        $this->assertInstanceOf('Pop\Color\Hsb', $h);
        $this->assertEquals(180, $h->getHue());
        $this->assertEquals(50, $h->getSaturation());
        $this->assertEquals(50, $h->getBrightness());
    }

    public function testConstructorOutOfRange()
    {
        $this->setExpectedException('Pop\Color\Exception');
        $h = new Hsb(400, 120, 150);
    }

    public function testGetHsb()
    {
        $h = new Hsb(180, 50, 50);
        $this->assertEquals('180,50,50', (string)$h);
        $this->assertEquals('180,50,50', $h->get(Color::STRING));
        $this->assertEquals(array(180, 50, 50), $h->get(Color::NUM_ARRAY));
        $this->assertEquals(array('h' => 180, 's' => 50, 'b' => 50), $h->get());
    }

}

