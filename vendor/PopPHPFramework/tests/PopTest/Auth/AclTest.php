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
use Pop\Auth\Resource;
use Pop\Auth\Acl;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class AclTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $a = Acl::factory(Role::factory('admin'), Resource::factory('page'));
        $this->assertInstanceOf('Pop\Auth\Acl', $a);
        $this->assertTrue($a->hasRole('admin'));
        $this->assertTrue($a->hasResource('page'));
    }

    public function testRoles()
    {
        $admin = Role::factory('admin');
        $editor = Role::factory('editor');
        $reader = Role::factory('reader');

        $a = Acl::factory();
        $a->addRoles(array($admin, $editor))
          ->addRole($reader);

        $a->addRoles('publisher');
        $a->addRoles(array('super', 'duper'));
        $this->assertTrue($a->hasRole('admin'));
        $this->assertTrue($a->hasRole('super'));
        $this->assertTrue($a->hasRole('duper'));
        $this->assertEquals('editor', $a->getRole('editor')->getName());
    }

    public function testResources()
    {
        $page = Resource::factory('page');
        $template = Resource::factory('template');
        $user = Resource::factory('user');

        $a = Acl::factory();
        $a->addResources(array($page, $template))
          ->addResource($user);

        $a->addResources('file');
        $a->addResources(array('image', 'event'));

        $this->assertTrue($a->hasResource('page'));
        $this->assertTrue($a->hasResource('file'));
        $this->assertTrue($a->hasResource('image'));
        $this->assertEquals('template', $a->getResource('template')->getName());
    }

    public function testAllow()
    {
        $admin = Role::factory('admin');
        $publisher = Role::factory('publisher');
        $editor = Role::factory('editor');
        $editor->addPermission('edit');
        $page = Resource::factory('page');

        $a = Acl::factory($editor, $page);
        $a->addRoles(array($publisher, $admin));
        $a->allow('editor', 'page', 'edit');
        $a->allow('publisher', 'page');
        $a->allow('admin');
        $this->assertTrue($a->isAllowed($editor, 'page', 'edit'));
        $this->assertTrue($a->isAllowed($publisher, 'page'));
        $this->assertTrue($a->isAllowed($admin));
        $this->assertFalse($a->isDenied($editor, 'page', 'edit'));
    }

    public function testAllowNoRoleException()
    {
        $this->setExpectedException('Pop\Auth\Exception');
        $a = Acl::factory();
        $a->allow('editor');
    }

    public function testAllowNoResource()
    {
        $editor = Role::factory('editor');
        $a = Acl::factory($editor);
        $a->allow('editor', 'page');
        $this->assertTrue($a->hasResource('page'));
    }

    public function testAllowNoPermissionException()
    {
        $this->setExpectedException('Pop\Auth\Exception');
        $editor = Role::factory('editor');
        $editor->addPermission('edit');
        $page = Resource::factory('page');

        $a = acl::factory($editor, $page);
        $a->allow('editor', 'page', 'read');
    }

    public function testRemoveAllow()
    {
        $editor = Role::factory('editor');
        $editor->addPermission('edit');
        $page = Resource::factory('page');

        $a = Acl::factory($editor, $page);
        $a->allow('editor', 'page', 'edit');
        $this->assertTrue($a->isAllowed($editor, 'page', 'edit'));
        $a->removeAllow('editor', 'page', 'edit');
        $a->removeAllow('editor', 'page');
        $a->removeAllow('editor');
        $this->assertFalse($a->isAllowed($editor, 'page', 'edit'));
    }

    public function testRemoveAllowNoRoleException()
    {
        $this->setExpectedException('Pop\Auth\Exception');
        $a = Acl::factory();
        $a->removeAllow('editor');
    }

    public function testRemoveAllowNoRulesException()
    {
        $this->setExpectedException('Pop\Auth\Exception');
        $editor = Role::factory('editor');
        $a = Acl::factory($editor);
        $a->removeAllow('editor');
    }

    public function testRemoveAllowNoResource()
    {
        $editor = Role::factory('editor');
        $a = Acl::factory($editor);
        $a->allow('editor');
        $a->removeAllow('editor', 'page');
        $this->assertTrue($a->hasResource('page'));
    }

    public function testDeny()
    {
        $admin = Role::factory('admin');
        $publisher = Role::factory('publisher');
        $editor = Role::factory('editor');
        $editor->addPermission('edit');
        $page = Resource::factory('page');

        $a = Acl::factory($editor, $page);
        $a->addRoles(array($publisher, $admin));
        $a->deny('editor', 'page', 'edit');
        $a->deny('publisher', 'page');
        $a->deny('admin');
        $this->assertTrue($a->isDenied($editor, 'page', 'edit'));
        $this->assertTrue($a->isDenied($publisher, 'page'));
        $this->assertTrue($a->isDenied($admin));
        $this->assertFalse($a->isAllowed($editor, 'page', 'edit'));
    }

    public function testDenyNoRoleException()
    {
        $this->setExpectedException('Pop\Auth\Exception');
        $a = Acl::factory();
        $a->deny('editor', 'page', 'edit');
    }

    public function testDenyNoResource()
    {
        $editor = Role::factory('editor');
        $a = Acl::factory($editor);
        $a->deny('editor', 'page');
        $this->assertTrue($a->hasResource('page'));
    }

    public function testDenyNoPermissionException()
    {
        $this->setExpectedException('Pop\Auth\Exception');
        $editor = Role::factory('editor');
        $editor->addPermission('edit');
        $page = Resource::factory('page');

        $a = acl::factory($editor, $page);
        $a->deny('editor', 'page', 'read');
    }

    public function testRemoveDeny()
    {
        $editor = Role::factory('editor');
        $editor->addPermission('edit');
        $page = Resource::factory('page');

        $a = Acl::factory($editor, $page);
        $a->allow('editor', 'page', 'edit');
        $a->deny('editor', 'page', 'edit');
        $this->assertFalse($a->isAllowed($editor, 'page', 'edit'));
        $a->removeDeny('editor', 'page', 'edit');
        $a->removeDeny('editor');
        $this->assertTrue($a->isAllowed($editor, 'page', 'edit'));
    }

    public function testRemoveDenyNoRoleException()
    {
        $this->setExpectedException('Pop\Auth\Exception');
        $a = Acl::factory();
        $a->removeDeny('editor');
    }

    public function testRemoveDenyNoRulesException()
    {
        $this->setExpectedException('Pop\Auth\Exception');
        $editor = Role::factory('editor');
        $a = Acl::factory($editor);
        $a->removeDeny('editor');
    }

    public function testRemoveDenyNoResource()
    {
        $editor = Role::factory('editor');
        $a = Acl::factory($editor);
        $a->deny('editor');
        $a->removeDeny('editor', 'page');
        $this->assertTrue($a->hasResource('page'));
    }

    public function testIsAllowedNoRoleException()
    {
        $this->setExpectedException('Pop\Auth\Exception');
        $editor = Role::factory('editor');

        $a = Acl::factory($editor);
        $a->allow('editor');
        $this->assertTrue($a->isAllowed(Role::factory('user'), 'page', 'edit'));
    }

    public function testIsAllowedNoResource()
    {
        $editor = Role::factory('editor');

        $a = Acl::factory($editor);
        $a->allow('editor');
        $this->assertTrue($a->isAllowed($editor, 'page'));
        $this->assertTrue($a->hasResource('page'));
    }

    public function testIsDeniedNoRoleException()
    {
        $this->setExpectedException('Pop\Auth\Exception');
        $editor = Role::factory('editor');

        $a = Acl::factory($editor);
        $a->deny('editor');
        $this->assertTrue($a->isDenied(Role::factory('user'), 'page', 'edit'));
    }

    public function testIsDeniedNoResource()
    {
        $editor = Role::factory('editor');

        $a = Acl::factory($editor);
        $a->deny('editor');
        $this->assertTrue($a->isDenied($editor, 'page'));
        $this->assertTrue($a->hasResource('page'));
    }

}
