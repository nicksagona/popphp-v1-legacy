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
    Pop\Auth\Role;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class RoleTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $this->assertInstanceOf('Pop\\Auth\\Role', Role::factory('editor', 5));
    }

    public function testCompare()
    {
        $e = Role::factory('editor', 5);
        $r = Role::factory('reader', 1);
        $this->assertGreaterThan(0, $e->compare($r));
        $this->assertLessThan(0, $r->compare($e));
    }

    public function testSetAndGetLevel()
    {
        $e = Role::factory('editor', 5);
        $e->setLevel(10);
        $this->assertEquals(10, $e->getLevel());
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

