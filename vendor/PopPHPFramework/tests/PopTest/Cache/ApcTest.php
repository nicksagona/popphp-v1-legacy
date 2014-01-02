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
use Pop\Cache\Adapter\Apc;

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

