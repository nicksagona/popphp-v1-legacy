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
namespace PopTest\Code;

use Pop\Loader\Autoloader;
use Pop\Code\Reflection;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ReflectionTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\Code\Reflection', Reflection::factory('Pop\Auth\Auth'));
    }

    public function testGetGenerator()
    {
        $r = Reflection::factory('Pop\Auth\Auth');
        $g = $r->generator();
        $this->assertInstanceOf('Pop\Code\Generator', $g);
        $this->assertEquals('Pop\Auth', $g->getNamespace()->getNamespace());
    }

    public function testGetCode()
    {
        $r = Reflection::factory('Pop\Auth\Auth');
        $this->assertEquals('Pop\Auth\Auth', $r->code());
    }

    public function testBuildGenerator()
    {
        $r = Reflection::factory('Pop\File\File');
        $r = Reflection::factory('Pop\Web\Session');
        $r = Reflection::factory('Pop\Dom\AbstractDom');
        $this->assertTrue($r->isAbstract());
        $r = Reflection::factory('Pop\Form\Form');
        $this->assertEquals('Dom', $r->generator()->code()->getParent());
        $r = Reflection::factory('Pop\Cache\Adapter\File');
        $this->assertTrue(is_array($r->getInterfaces()));
    }

}

