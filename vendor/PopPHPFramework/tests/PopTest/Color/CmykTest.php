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
        $class = 'Pop\\Color\\Cmyk';
        $this->assertTrue($c instanceof $class);
        $this->assertEquals(20, $c->getCyan());
        $this->assertEquals(40, $c->getMagenta());
        $this->assertEquals(60, $c->getYellow());
        $this->assertEquals(80, $c->getBlack());
    }

}

?>