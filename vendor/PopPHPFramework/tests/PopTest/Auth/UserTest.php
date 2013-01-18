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

use Pop\Loader\Autoloader,
    Pop\Auth\Role,
    Pop\Auth\User;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class UserTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $r = Role::factory('editor', 5);
        $u = new User('John', '12john34', $r);
        $this->assertInstanceOf('Pop\Auth\User', $u);
    }

    public function testFactory()
    {
        $r = Role::factory('editor', 5);
        $u = User::factory('John', '12john34', $r);
        $this->assertInstanceOf('Pop\Auth\User', $u);
    }

    public function testGetRole()
    {
        $r = Role::factory('editor', 5);
        $u = User::factory('John', '12john34', $r);
        $this->assertEquals('editor', $u->getRole()->getName());
    }

    public function testSetAndGetUsernameAndPassword()
    {
        $r = Role::factory('editor', 5);
        $u = new User('John', '12john34', $r);
        $u->setUsername('Bubba');
        $u->setPassword('12bubba34');
        $this->assertEquals('Bubba', $u->getUsername());
        $this->assertEquals('12bubba34', $u->getPassword());
    }

    public function testFields()
    {
        $r = Role::factory('editor', 5);
        $u = new User('John', '12john34', $r);
        $this->assertEquals('John', $u->username);
    }

    public function testIsAuthorizedAs()
    {
        $e = Role::factory('editor', 5);
        $r = Role::factory('reader', 1);
        $u = new User('John', '12john34', $e);
        $this->assertTrue($u->isAuthorizedAs($r));
    }

}

