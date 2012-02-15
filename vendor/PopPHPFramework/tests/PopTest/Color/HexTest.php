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
    Pop\Color\Hex;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class HexTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $h = new Hex('#ee1c2d');
        $this->assertInstanceOf('Pop\\Color\\Hex', $h);
        $this->assertEquals('ee', $h->getRed());
        $this->assertEquals('1c', $h->getGreen());
        $this->assertEquals('2d', $h->getBlue());

        $h = new Hex('#def');
        $this->assertInstanceOf('Pop\\Color\\Hex', $h);
        $this->assertEquals('dd', $h->getRed());
        $this->assertEquals('ee', $h->getGreen());
        $this->assertEquals('ff', $h->getBlue());
    }

    public function testConstructorOutOfRange()
    {
        $this->setExpectedException('Pop\\Color\\Exception');
        $h = new Hex('#gggggg');
    }

    public function testGetHex()
    {
        $h = new Hex('#ee1c2d');
        $this->assertEquals('#ee1c2d', (string)$h);
        $this->assertEquals('#ee1c2d', $h->getHex(true));
        $h = new Hex('#def');
        $this->assertEquals('def', $h->getHex(false, true));
    }

}

