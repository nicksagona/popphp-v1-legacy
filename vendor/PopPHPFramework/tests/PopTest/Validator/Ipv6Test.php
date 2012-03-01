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

namespace PopTest\Validator;

use Pop\Loader\Autoloader,
    Pop\Validator\Validator\Ipv6;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class Ipv6Test extends \PHPUnit_Framework_TestCase
{

    public function testEvaluateTrue()
    {
        $v = new Ipv6();
        $this->assertTrue($v->evaluate('fe80::21a:4dff:fe50:11de'));
        $this->assertFalse($v->evaluate('123456'));
    }

    public function testEvaluateFalse()
    {
        $v = new Ipv6(null, false);
        $this->assertFalse($v->evaluate('fe80::21a:4dff:fe50:11de'));
        $this->assertTrue($v->evaluate('123456'));
    }

}

