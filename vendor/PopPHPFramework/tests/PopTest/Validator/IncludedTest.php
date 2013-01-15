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
    Pop\Validator\Included;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class IncludedTest extends \PHPUnit_Framework_TestCase
{

    public function testEvaluateTrue()
    {
        $v = new Included(3);
        $this->assertTrue($v->evaluate(array(1, 2, 3)));
        $v = new Included(4);
        $this->assertFalse($v->evaluate(array(1, 2, 3)));
    }

    public function testEvaluateFalse()
    {
        $v = new Included(3, null, false);
        $this->assertFalse($v->evaluate(array(1, 2, 3)));
        $v = new Included(4, null, false);
        $this->assertTrue($v->evaluate(array(1, 2, 3)));
    }

}

