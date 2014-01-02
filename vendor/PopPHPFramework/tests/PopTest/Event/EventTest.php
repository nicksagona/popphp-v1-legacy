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
namespace PopTest\Event;

use Pop\Loader\Autoloader;
use Pop\Event\Manager;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Test class 'Foo'
class Foo
{
    public $value;

    public function __construct($arg = null)
    {
        $this->value = $arg;
    }

    public static function factory($arg)
    {
        return new self($arg);
    }

    public function bar($arg)
    {
        $this->value = $arg;
        return $this;
    }
}

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class EventTest extends \PHPUnit_Framework_TestCase
{

    public function testDomConstructor()
    {
        $e = new Manager('pre', function() { return 'Hello World'; }, 2);
        $this->assertInstanceOf('Pop\Event\Manager', $e);
        $this->assertEquals(1, count($e->get('pre')));
        $this->assertTrue($e->alive());
    }

    public function testAttachEvent()
    {
        $e = new Manager();
        $e->attach('pre', function() { return 'Hello World'; }, 2);
        $this->assertEquals(1, count($e->get('pre')));
    }

    public function testDetachEvent()
    {
        $func = function() { return 'Hello World'; };
        $e = new Manager();
        $e->attach('pre', $func, 2);
        $e->detach('pre', $func);
        $this->assertEquals(0, count($e->get('pre')));
    }

    public function testTrigger()
    {
        $e = new Manager();
        $e->attach('pre', function($name) { return $name . '!'; }, 2);
        $e->attach('pre', function($result) { return 'Hello, ' . $result; }, 1);
        $e->trigger('pre', array('name' => 'World'));
        $results = $e->getResults('pre');
        $this->assertEquals(2, count($results));
        $this->assertEquals('Hello, World!', $results[1]);
    }

    public function testTriggerWithClass()
    {
        $e = new Manager();
        $e->attach('pre', array(new Foo, 'bar'), 1);
        $e->attach('pre', 'PopTest\Event\Foo->bar', 1);
        $e->attach('pre', 'PopTest\Event\Foo', 1);
        $e->attach('pre', 'new PopTest\Event\Foo', 1);
        $e->attach('pre', function($result) { return 'Hello, ' . $result->value; }, 1);
        $e->trigger('pre', array('arg' => 'World'));
        $results = $e->getResults('pre');
        $this->assertEquals('Hello, World', $results[1]);
    }

    public function testTriggerWithClassFactory()
    {
        $e = new Manager();
        $e->attach('pre', 'PopTest\Event\Foo::factory', 2);
        $e->attach('pre', function($result) { return 'Hello, ' . $result->value; }, 1);
        $e->trigger('pre', array('arg' => 'World'));
        $results = $e->getResults('pre');
        $this->assertEquals('Hello, World', $results[1]);
    }

    public function testStop()
    {
        $e = new Manager();
        $e->attach('pre', function($name) { return Manager::STOP; }, 2);
        $e->attach('pre', function($result) { return 'Hello, ' . $result; }, 1);
        $e->trigger('pre', array('name' => 'World'));
        $results = $e->getResults('pre');
        $this->assertEquals(1, count($results));
        $this->assertEquals(Manager::STOP, $results[0]);
    }

    public function testKill()
    {
        $e = new Manager();
        $e->attach('pre', function() { return Manager::KILL; });
        $e->trigger('pre');
        $results = $e->getResults('pre');
        $this->assertEquals(1, count($results));
        $this->assertEquals(Manager::KILL, $results[0]);
        $this->assertFalse($e->alive());
    }

}

