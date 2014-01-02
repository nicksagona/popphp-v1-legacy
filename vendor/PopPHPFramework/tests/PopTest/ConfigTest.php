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
use Pop\Config;

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

    public function testConfigMerge()
    {
        $cfg1 = array(
            'db' => array(
                'name' => 'testdb',
                'host' => 'localhost',
                'user' => array(
                    'username' => 'testuser',
                    'password' => '12test34',
                    'role'     => 'editor'
                )
            ),
            'nav' => array(
                'some' => 'nav'
            ),
            'module' => 'TestModule',
            'oldvalue' => 123456
        );

        $cfg2 = array(
            'db' => array(
                'name' => 'testdb123',
                'host' => 'localhost',
                'user' => array(
                    'username' => 'testuser2',
                    'password' => '45test67',
                    'role'     => 'editor'
                )
            ),
            'nav' => array(
                'some' => 'nav12'
            ),
            'module' => 'TestModule',
            'newvalue' => array(
                'Some new value'
            )
        );

        $config1 = new Config($cfg1);
        $config2 = new Config($cfg2);
        $config1->merge($config2);
        $this->assertContains('Some new value', $config1->newvalue->asArray());
    }

    public function testConfigMergeException()
    {
        $this->setExpectedException('Exception');

        $cfg1 = array(
            'db' => array(
                'name' => 'testdb',
                'host' => 'localhost',
                'user' => array(
                    'username' => 'testuser',
                    'password' => '12test34',
                    'role'     => 'editor'
                )
            ),
            'nav' => array(
                'some' => 'nav'
            ),
            'module' => 'TestModule',
            'oldvalue' => 123456
        );

        $cfg2 = 'bad value';

        $config1 = new Config($cfg1);
        $config1->merge($cfg2);
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

