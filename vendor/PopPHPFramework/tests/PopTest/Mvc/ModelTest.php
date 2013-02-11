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
namespace PopTest\Mvc;

use Pop\Loader\Autoloader;
use Pop\Mvc\Model;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ModelTest extends \PHPUnit_Framework_TestCase
{

    public function testModelConstructor()
    {
        $this->assertInstanceOf('Pop\Mvc\Model', new Model('123', 'data'));
        $this->assertInstanceOf('Pop\Mvc\Model', Model::factory('123', 'data'));
    }

    public function testAsArray()
    {
        $m = new Model('123', 'data');
        $ary = $m->asArray();
        $this->assertEquals('123', $ary['data']);
    }

    public function testAsArrayObject()
    {
        $m = new Model('123', 'data');
        $ary = $m->asArrayObject();
        $this->assertEquals('123', $ary->data);
    }

    public function testGetData()
    {
        $m = new Model('123', 'data');
        $ary = $m->getData();
        $this->assertEquals('123', $ary['data']);
    }

    public function testKey()
    {
        $m = new Model('123', 'data');
        $this->assertNull($m->key(0));
    }

    public function testGet()
    {
        $m = new Model('123', 'data');
        $this->assertEquals('123', $m->get('data'));
        $this->assertEquals('123', $m->data);
    }

    public function testSet()
    {
        $m = new Model(array('other' => 789, 'onemorething' => 980));
        $m->set('data', '123');
        $m->something = 456;
        $this->assertEquals('123', $m->data);
        $this->assertEquals('456', $m->something);
    }

    public function testSetException()
    {
        $this->setExpectedException('Pop\Mvc\Exception');
        $m = new Model(123);
    }

    public function testIsset()
    {
        $m = new Model('123', 'data');
        $this->assertTrue(isset($m->data));
    }

    public function testUnset()
    {
        $m = new Model('123', 'data');
        unset($m->data);
        $this->assertNull($m->data);
    }

}

