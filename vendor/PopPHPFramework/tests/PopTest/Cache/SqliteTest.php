<?php
/**
 * Pop PHP Framework Unit Tests (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Test
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace PopTest\Cache;

use Pop\Loader\Autoloader;
use Pop\Cache\Cache;
use Pop\Cache\Adapter\Sqlite;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class SqliteTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Cache\Cache', Cache::factory(new Sqlite(__DIR__ . '/../tmp/cache.sqlite'), 30));
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
        $this->setExpectedException('Pop\Cache\Adapter\Exception');
        $c = Cache::factory(new Sqlite(__DIR__ . '/../test/cache.sqlite'), 30);
    }

    public function testSaveAndLoad()
    {
        $str = 'This is my test variable. It contains a string.';
        $c = Cache::factory(new Sqlite(__DIR__ . '/../tmp/cache.sqlite', 'pop_cache', true), 30);
        $this->assertContains('cache.sqlite', $c->adapter()->getDb());
        $this->assertEquals('pop_cache', $c->adapter()->getTable());
        $c->save('str', $str);
        $val = $c->load('str');
        $this->assertEquals($str, $val);
        $val .= '-new';
        $c->save('str', $val);
        $this->assertEquals($val, $c->load('str'));
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

