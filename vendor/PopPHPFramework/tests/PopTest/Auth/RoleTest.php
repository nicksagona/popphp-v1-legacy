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
        $this->assertInstanceOf('Pop\Auth\Role', Role::factory('editor'));
    }

    public function testGetName()
    {
        $e = Role::factory('editor');
        $this->assertEquals('editor', $e->getName());
    }

    public function testAddChild()
    {
        $e = Role::factory('editor');
        $r = Role::factory('reader');
        $r->addChild($e);
        $this->assertTrue($e->hasParent());
        $this->assertEquals('reader', $e->getParent()->getName());
    }

    public function testSetParent()
    {
        $e = Role::factory('editor');
        $r = Role::factory('reader');
        $e->setParent($r);
        $this->assertTrue($e->hasParent());
        $this->assertEquals('reader', $e->getParent()->getName());
    }

    public function testAddAndCheckPermission()
    {
        $ad = Role::factory('admin');
        $p = Role::factory('publisher');
        $e = Role::factory('editor');
        $r = Role::factory('reader');
        $p->addPermission('publisher');
        $e->addPermission('edit');
        $r->addPermission('read');
        $r->addChild($e->addChild($p->addChild($ad)));
        //$this->assertTrue($e->hasPermission('edit'));
        $this->assertTrue($ad->hasPermission('read'));
    }

    public function testToString()
    {
        $e = Role::factory('editor');
        $this->assertEquals('editor', (string)$e);
    }

}

