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
namespace PopTest\Service;

use Pop\Loader\Autoloader;
use Pop\Service\Locator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class Foo
{

    public $value = null;

    public function __construct($val = null)
    {
        $this->value = $val;
    }

    public function bar($val = null)
    {
        return new \Pop\Config(array('test' => $val));
    }

    public static function baz($val = null)
    {
        return new \Pop\Config(array('test' => $val));
    }

}

class ServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Service\Locator', new Locator());
    }

    public function testConstructorException()
    {
        $this->setExpectedException('Pop\Service\Exception');
        $s = new Locator(array('service' => null));
    }

    public function testSetandGetServices()
    {
        $l = new Locator(array(
            'config' => array(
                'call'   => 'Pop\Config',
                'params' => array(array('test' => 123), true)
            ),
            'std' => array(
                'call'  => 'stdClass'
            ),
            'rgb' => array(
                'call'   => 'Pop\Color\Space\Rgb',
                'params' => function() { return array(255, 0, 0); }
            ),
            'cmyk' => new \Pop\Color\Space\Cmyk(100, 0, 0, 50),
            'color' => function($locator) {
                return new \Pop\Color\Color($locator->get('rgb'));
            }
        ));
        $this->assertInstanceOf('Pop\Config', $l->get('config'));
        $this->assertInstanceOf('stdClass', $l->get('std'));
        $this->assertInstanceOf('Pop\Color\Space\Rgb', $l->get('rgb'));
        $this->assertInstanceOf('Pop\Color\Space\Cmyk', $l->get('cmyk'));
        $this->assertInstanceOf('Pop\Color\Color', $l->get('color'));
    }

    public function testRemove()
    {
        $l = new Locator(array(
            'config' => array(
                'call'   => 'Pop\Config',
                'params' => array(array('test' => 123), true)
            ),
            'rgb' => array(
                'call'   => 'Pop\Color\Space\Rgb',
                'params' => function() { return array(255, 0, 0); }
            ),
            'color' => function($locator) {
                return new \Pop\Color\Color($locator->get('rgb'));
            }
        ));
        $c = $l->get('config');
        $l->remove('config');
        $this->assertInstanceOf('Pop\Config', $c);
        $this->assertNull($l->get('config'));
    }

    public function testClass()
    {
        $l = new Locator();
        $l->set('config1', 'PopTest\Service\Foo')
          ->set('config2', 'PopTest\Service\Foo->bar')
          ->set('config3', 'PopTest\Service\Foo::baz');

        $c1 = $l->get('config1');
        $c2 = $l->get('config2');
        $c3 = $l->get('config3');
        $this->assertInstanceOf('PopTest\Service\Foo', $c1);
        $this->assertInstanceOf('Pop\Config', $c2);
        $this->assertInstanceOf('Pop\Config', $c3);
    }

    public function testClassWithParams()
    {
        $l = new Locator();
        $l->set('config1', 'PopTest\Service\Foo', array(123))
          ->set('config2', 'PopTest\Service\Foo->bar', array(456))
          ->set('config3', 'PopTest\Service\Foo::baz', array(789));

        $c1 = $l->get('config1');
        $c2 = $l->get('config2');
        $c3 = $l->get('config3');
        $this->assertInstanceOf('PopTest\Service\Foo', $c1);
        $this->assertInstanceOf('Pop\Config', $c2);
        $this->assertInstanceOf('Pop\Config', $c3);
    }

    public function testGetNull()
    {
        $l = new Locator();
        $this->assertNull($l->get('service'));
    }

    public function testRecursiveException()
    {
        $this->setExpectedException('Pop\Service\Exception');
        $l = new Locator(array(
            'service1' => function($locator) {
                return $locator->get('service2');
            },
            'service2' => function($locator) {
                return $locator->get('service1');
            }
        ));
        $s = $l->get('service1');
    }

}

