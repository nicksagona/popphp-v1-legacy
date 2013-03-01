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
namespace PopTest\Auth;

use Pop\Loader\Autoloader;
use Pop\Auth\Role;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class RoleTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\Auth\Role', Role::factory('editor', 5));
    }

    public function testCompare()
    {
        $e = Role::factory('editor', 5);
        $r = Role::factory('reader', 1);
        $this->assertGreaterThan(0, $e->compare($r));
        $this->assertLessThan(0, $r->compare($e));
    }

    public function testSetAndGetValue()
    {
        $e = Role::factory('editor', 5);
        $e->setValue(10);
        $this->assertEquals(10, $e->getValue());
    }

    public function testSetAndGetName()
    {
        $e = Role::factory('editor', 5);
        $e->setName('admin');
        $this->assertEquals('admin', $e->getName());
    }

    public function testGetter()
    {
        $e = Role::factory('editor', 5);
        $this->assertEquals(5, $e->editor);
    }

    public function testToString()
    {
        $e = Role::factory('editor', 5);
        $this->assertEquals('editor', (string)$e);
    }

}

