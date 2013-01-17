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

namespace PopTest\Event;

use Pop\Loader\Autoloader,
    Pop\Event\Manager;

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

}

