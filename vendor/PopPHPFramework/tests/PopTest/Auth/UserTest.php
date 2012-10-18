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

