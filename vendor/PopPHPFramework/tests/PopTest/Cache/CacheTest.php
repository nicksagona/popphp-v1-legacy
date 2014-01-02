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
use Pop\Cache\Adapter\File;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CacheTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Cache\Cache', Cache::factory(new File(__DIR__ . '/../tmp'), 30));
    }

    public function testSetAndGetLifetime()
    {
        $c = Cache::factory(new File(__DIR__ . '/../tmp'), 30);
        $c->setLifetime(30);
        $this->assertEquals(30, $c->getLifetime());
    }

    public function testCacheDirExists()
    {
        $this->setExpectedException('Pop\Cache\Adapter\Exception');
        $c = Cache::factory(new File(__DIR__ . '/../test'), 30);
    }

    public function testSaveAndLoad()
    {
        if (!file_exists(__DIR__ . '/../tmp/cache')) {
            mkdir(__DIR__ . '/../tmp/cache');
            chmod(__DIR__ . '/../tmp/cache', 0777);
        }

        $str = 'This is my test variable. It contains a string.';
        $c = Cache::factory(new File(__DIR__ . '/../tmp/cache'), 30);
        $this->fileExists($c->adapter()->getDir());
        $c->save('str', $str);
        $this->assertEquals($str, $c->load('str'));
        $c->remove('str');
        $c->clear();

        if (file_exists(__DIR__ . '/../tmp/cache')) {
            rmdir(__DIR__ . '/../tmp/cache');
        }
    }

}

