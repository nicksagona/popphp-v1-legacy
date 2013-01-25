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
namespace PopTest;

use Pop\Loader\Autoloader,
    Pop\Config;

// Require the library's autoloader.
require_once __DIR__ . '/../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Config', new Config());
        $this->assertInstanceOf('Pop\Config', Config::factory());
    }

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

    public function testConfigException()
    {
        $this->setExpectedException('Exception');
        $c = new Config(array('data' => 123));
        $c->data = 456;
    }

    public function testAsArrayObject()
    {
        $c = new Config(array('data' => 123));
        $this->assertInstanceOf('ArrayObject', $c->asArrayObject());
    }
}

