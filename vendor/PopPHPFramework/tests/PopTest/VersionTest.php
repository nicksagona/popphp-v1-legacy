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
namespace PopTest;

use Pop\Loader\Autoloader;
use Pop\Version;

// Require the library's autoloader.
require_once __DIR__ . '/../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class VersionTest extends \PHPUnit_Framework_TestCase
{

    public function testVersion()
    {
        $this->assertEquals('1.7.0', Version::getVersion());
        $this->assertEquals('1.7.0', trim(Version::getLatest()));
        $this->assertEquals(1, Version::compareVersion(1.8));
    }

    public function testCheck()
    {
        $results = Version::check();
        $results = Version::check(Version::HTML);
        $results = Version::check(Version::DATA);
        $this->assertGreaterThan(0, count($results));
    }

}

