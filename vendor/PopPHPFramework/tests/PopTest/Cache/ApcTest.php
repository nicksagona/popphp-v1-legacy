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

namespace PopTest\Cache;

use Pop\Loader\Autoloader,
    Pop\Cache\Cache,
    Pop\Cache\Adapter\Apc;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ApcTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        if (function_exists('apc_add')) {
            $this->assertInstanceOf('Pop\Cache\Cache', Cache::factory(new Apc(), 30));
        }
    }

    public function testSetAndGetLifetime()
    {
        if (function_exists('apc_add')) {
            $c = Cache::factory(new Apc(), 30);
            $c->setLifetime(30);
            $this->assertEquals(30, $c->getLifetime());
        }
    }

    public function testSaveAndLoad()
    {
        if (function_exists('apc_add')) {
            $str = 'This is my test variable. It contains a string.';
            $c = Cache::factory(new Apc(), 30);
            $c->save('str', $str);
            $this->assertEquals($str, $c->load('str'));
            $c->remove('str');
            $c->clear();
        }
    }

    public function testGetInfo()
    {
        if (function_exists('apc_add')) {
            $c = Cache::factory(new Apc(), 30);
            $this->assertTrue(is_array($c->adapter()->getInfo()));
        }
    }

}

