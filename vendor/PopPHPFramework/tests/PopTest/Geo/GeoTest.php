<?php
/**
 * Pop PHP Framework Unit Tests (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Test
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace PopTest\Geo;

use Pop\Loader\Autoloader;
use Pop\Geo\Geo;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class GeoTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        if (function_exists('geoip_db_get_all_info')) {
            $this->assertInstanceOf('Pop\Geo\Geo', new Geo('www.google.com'));
        }
    }

    public function testGetDatabases()
    {
        if (function_exists('geoip_db_get_all_info')) {
            $g = new Geo('www.google.com');
            $this->assertEquals(10, count($g->getDatabases()));
            $this->assertTrue(is_bool($g->isDbAvailable('asnum')));
            $this->assertFalse($g->isDbAvailable('bogus'));
        }
    }

    public function testGetHostInfo()
    {
        if (function_exists('geoip_db_get_all_info')) {
            $g = new Geo('www.google.com');
            $info = $g->getHostInfo();
            $this->assertTrue(is_array($info));
        }
    }

}

