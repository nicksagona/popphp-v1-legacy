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
    Pop\Cache\Sqlite;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class SqliteTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\\Cache\\Cache', Cache::factory(new Sqlite(__DIR__ . '/../tmp/cache.sqlite'), 30));
    }

    public function testSetAndGetLifetime()
    {
        $c = Cache::factory(new Sqlite(__DIR__ . '/../tmp/cache.sqlite'), 30);
        $c->setLifetime(30);
        $this->assertEquals(30, $c->getLifetime());
    }

    public function testSetAndGetTable()
    {
        $c = Cache::factory(new Sqlite(__DIR__ . '/../tmp/cache.sqlite'), 30);
        $c->adapter()->setTable('pop_cache');
        $this->assertEquals('pop_cache', $c->adapter()->getTable());
    }

    public function testCacheDir()
    {
        $this->setExpectedException('Pop\\Cache\\Exception');
        $c = Cache::factory(new Sqlite(__DIR__ . '/../test/cache.sqlite'), 30);
    }

    public function testSaveAndLoad()
    {
        $str = 'This is my test variable. It contains a string.';
        $c = Cache::factory(new Sqlite(__DIR__ . '/../tmp/cache.sqlite'), 30);
        $this->assertContains('cache.sqlite', $c->adapter()->getDb());
        $this->assertEquals('pop_cache', $c->adapter()->getTable());
        $c->save('str', $str);
        $this->assertEquals($str, $c->load('str'));
        $c->remove('str');
        $c->clear();
    }

    public function testDelete()
    {
        $c = Cache::factory(new Sqlite(__DIR__ . '/../tmp/cache.sqlite'), 30);
        $c->adapter()->delete();
        $this->assertFalse(file_exists(__DIR__ . '/../tmp/cache.sqlite'));
    }

}

