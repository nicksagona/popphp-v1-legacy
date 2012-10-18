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
    Pop\Validator\Validator\IsSubnetOf;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class IsSubnetOfTest extends \PHPUnit_Framework_TestCase
{

    public function testEvaluateTrue()
    {
        $v = new IsSubnetOf('192.168.1');
        $this->assertTrue($v->evaluate('192.168.1.10'));
        $this->assertFalse($v->evaluate('10.0.0.79'));
    }

    public function testEvaluateFalse()
    {
        $v = new IsSubnetOf('192.168.1', false);
        $this->assertFalse($v->evaluate('192.168.1.10'));
        $this->assertTrue($v->evaluate('10.0.0.79'));
    }

    public function testEvaluateException()
    {
        $this->setExpectedException('Pop\Validator\Validator\Exception');
        $v = new IsSubnetOf('192.168.1', false);
        $v->evaluate('192168110');
    }
}

