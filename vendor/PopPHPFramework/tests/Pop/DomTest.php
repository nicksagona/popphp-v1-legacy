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

namespace Pop;

use Pop\Loader\Autoloader,
    Pop\Dom\Dom,
    Pop\Dom\Child;

// Require the library's autoloader.
require_once __DIR__ . '/../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class DomTest extends \PHPUnit_Framework_TestCase
{

    public function testDomConstructor()
    {
        $d = new Dom(Dom::XHTML11);
        $class = 'Pop\\Dom\\Dom';
        $this->assertTrue($d instanceof $class);
    }

    public function testChildConstructor()
    {
        $c = new Child('p', 'This is a paragraph');
        $class = 'Pop\\Dom\\Child';
        $this->assertTrue($c instanceof $class);
    }

}

?>