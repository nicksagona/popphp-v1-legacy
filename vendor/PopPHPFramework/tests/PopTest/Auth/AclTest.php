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
use Pop\Auth\Acl;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class AclTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $a = Acl::factory();
        $this->assertInstanceOf('Pop\Auth\Acl', $a);
    }

    public function testRoles()
    {
        $admin = Role::factory('admin', 3);
        $editor = Role::factory('editor',2);
        $reader = Role::factory('reader', 1);

        $a = Acl::factory();
        $a->addRoles(array($admin, $editor))
          ->addRoles($reader);

        $this->assertEquals(3, $a->getRole('admin')->getLevel());

        $a->removeRole('admin');
        $this->assertNull($a->getRole('admin'));
    }

    public function testSetRequiredRole()
    {
        $editor = Role::factory('editor',2);
        $a = Acl::factory();
        $a->setRequiredRole('admin', 3);
        $this->assertEquals(3, $a->getRequiredRole()->getLevel());
        $a->setRequiredRole($editor);
        $this->assertEquals(2, $a->getRequiredRole()->getLevel());
        $a->setRequiredRole();
        $this->assertNull($a->getRequiredRole());
        $this->assertTrue($a->isAuthorized($editor));
    }

    public function testIsAuthorized()
    {
        $admin = Role::factory('admin', 2);
        $editor = Role::factory('editor', 1);

        $a = Acl::factory(array($admin, $editor));
        $a->setRequiredRole('admin');
        $this->assertEquals(2, $a->getRequiredRole()->getLevel());
        $this->assertFalse($a->isAuthorized($editor));
    }

}

