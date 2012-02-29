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

namespace PopTest;

use Pop\Loader\Autoloader,
    Pop\Config;

// Require the library's autoloader.
require_once __DIR__ . '/../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testConfig()
    {
        $c = new Config(array('data' => 123), true);
        $this->assertEquals(123, $c->data);
        $c->data = 456;
        $this->assertEquals(456, $c->data);
        $this->assertEquals(1, count($c->asArray()));
        unset($c->data);
        $this->assertNull($c->data);
    }

    //public function testSetException()
    //{
    //    $this->setExpectedException('Exception');
    //    $c = new Config(array('data' => 123));
    //    $c->data = 456;
    //}

    public function testAsArrayObject()
    {
        $c = new Config(array('data' => 123));
        $this->assertInstanceOf('ArrayObject', $c->asArrayObject());
    }
}

