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
    Pop\Cache\Memcached;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class MemcachedTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        if (class_exists('Memcache')) {
            $this->assertInstanceOf('Pop\Cache\Cache', Cache::factory(new Memcached(), 30));
        }
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testConstructorException()
    {
        if (class_exists('Memcache')) {
            $c = Cache::factory(new Memcached('some-wrong-host'), 30);
        }
    }

    public function testSetAndGetLifetime()
    {
        if (class_exists('Memcache')) {
            $c = Cache::factory(new Memcached(), 30);
            $c->setLifetime(30);
            $this->assertEquals(30, $c->getLifetime());
        }
    }

    public function testSaveAndLoad()
    {
        if (class_exists('Memcache')) {
            $str = 'This is my test variable. It contains a string.';
            $c = Cache::factory(new Memcached(), 30);
            $c->save('str', $str);
            $this->assertEquals($str, $c->load('str'));
            $c->remove('str');
            $c->clear();
        }
    }

    public function testGetVersion()
    {
        if (class_exists('Memcache')) {
            $c = Cache::factory(new Memcached(), 30);
            $this->assertNotNull($c->adapter()->getVersion());
        }
    }

}

