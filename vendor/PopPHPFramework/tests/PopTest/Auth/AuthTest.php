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
    Pop\Auth\Auth,
    Pop\Auth\Role,
    Pop\Auth\Adapter\AuthFile,
    Pop\Auth\Adapter\AuthTable,
    Pop\Db\Db,
    Pop\Record\Record;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

// Test table class
class Users extends Record { }

Users::setDb(Db::factory('Sqlite', array('database' => __DIR__ . '/../tmp/test.sqlite')));

class AuthTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $class = 'Pop\\Auth\\Auth';
        $this->assertTrue($a instanceof $class);
    }

    public function testBadFile()
    {
        $this->setExpectedException('Pop\\Auth\\Adapter\\Exception');
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/badaccess.txt'));
    }

    public function testIsValidWithFile()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $a->authenticate('testuser1', '12test34');
        $this->assertTrue($a->isValid());
        $this->assertEquals(1, $a->getAttempts());
        $this->assertTrue(is_int($a->getStart()));
        $this->assertEquals(0, $a->getEncryption());
        $this->assertEquals(1, $a->getResult());
        $this->assertEquals('The user is valid.', $a->getResultMessage());

        $a->authenticate('baduser', '123456');
        $this->assertFalse($a->isValid());
        $this->assertEquals(2, $a->getResult());
        $this->assertEquals('The user was not found.', $a->getResultMessage());

        $a->authenticate('testuser1', 'wrongpass');
        $this->assertFalse($a->isValid());
        $this->assertEquals(4, $a->getResult());
        $this->assertEquals('The password was incorrect.', $a->getResultMessage());

        $a->authenticate('testuser4', 'test1234');
        $this->assertFalse($a->isValid());
        $this->assertEquals(3, $a->getResult());
        $this->assertEquals('The user is blocked.', $a->getResultMessage());
    }

    public function testIsAuthorizedWithFile()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $a->addRoles(Role::factory('admin', 3));
        $a->addRoles(array(
            Role::factory('editor', 2),
            Role::factory('reader', 1)
        ));
        $a->removeRole('reader');
        $a->setRequiredRole('admin')
          ->authenticate('testuser1', '12test34');
        $this->assertTrue($a->isAuthorized());
        $this->assertEquals('admin', $a->getRequiredRole()->getName());

        $a->setRequiredRole()
          ->authenticate('testuser1', '12test34');
        $this->assertTrue($a->isAuthorized());

        $class = 'Pop\\Auth\\User';
        $this->assertTrue($a->getUser() instanceof $class);
    }

    public function testIsValidWithTable()
    {
        $a = new Auth(new AuthTable('PopTest\\Auth\\Users', 'username', 'password', 'access'));
        $a->authenticate('test1', 'password1');
        $this->assertTrue($a->isValid());

        $a->authenticate('baduser', '123456');
        $this->assertFalse($a->isValid());

        $a->authenticate('test1', 'wrongpass');
        $this->assertFalse($a->isValid());

        $a->authenticate('test8', 'password8');
        $this->assertFalse($a->isValid());

        $a->authenticate('test1', 'password1');
        $a->validate();
        $this->assertTrue($a->isValid());
    }

    public function testSetAndGetExpiration()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $a->setExpiration(30);
        $this->assertEquals(30, $a->getExpiration());
        $a->setExpiration();
        $this->assertEquals(0, $a->getExpiration());
    }

    public function testSetAndGetSalt()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $a->setSalt('abcdefg');
        $this->assertEquals('abcdefg', $a->getSalt());
    }

    public function testRequiredRole()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $a->setRequiredRole('admin', 5);
        $this->assertEquals('admin', $a->getRequiredRole()->getName());
        $a->setRequiredRole(Role::factory('editor', 4));
        $this->assertEquals('editor', $a->getRequiredRole()->getName());
        $a->setRequiredRole();
        $this->assertEquals(null, $a->getRequiredRole());
    }

    public function testSetAttemptLimit()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $a->setAttempts(5);
        $a->setAttemptLimit(3);
        $this->assertEquals(5, $a->getAttempts());
        $this->assertEquals(3, $a->getValidator('attempts')->getValidator()->getValue());
        $a->setAttemptLimit();
        $this->assertEquals(null, $a->getValidator('attempts'));
    }

    public function testSetBlockedIps()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $a->setBlockedIps(array('123.123.123.123', '124.124.124.124'));
        $this->assertEquals(array('123.123.123.123', '124.124.124.124'), $a->getValidator('blockedIps')->getValidator()->getValue());
        $a->setBlockedIps();
        $this->assertEquals(null, $a->getValidator('blockedIps'));
    }

    public function testSetBlockedSubnets()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $a->setBlockedSubnets(array('123.123.123', '124.124.124'));
        $this->assertEquals(array('123.123.123', '124.124.124'), $a->getValidator('blockedSubnets')->getValidator()->getValue());
        $a->setBlockedSubnets();
        $this->assertEquals(null, $a->getValidator('blockedSubnets'));
    }

    public function testSetAllowedIps()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $a->setAllowedIps('123.123.123.123');
        $a->setAllowedIps(array('123.123.123.123', '124.124.124.124'));
        $this->assertEquals(array('123.123.123.123', '124.124.124.124'), $a->getValidator('allowedIps')->getValidator()->getValue());
        $a->setAllowedIps();
        $this->assertEquals(null, $a->getValidator('allowedIps'));
    }

    public function testSetAllowedSubnets()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'));
        $a->setAllowedSubnets('123.123.123');
        $a->setAllowedSubnets(array('123.123.123', '124.124.124'));
        $this->assertEquals(array('123.123.123', '124.124.124'), $a->getValidator('allowedSubnets')->getValidator()->getValue());
        $a->setAllowedSubnets();
        $this->assertEquals(null, $a->getValidator('allowedSubnets'));
    }

    public function testPasswordEncryption()
    {
        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'), Auth::ENCRYPT_MD5);
        $a->authenticate('testuser1', '12test34');
        $this->assertFalse($a->isValid());

        unset($a);

        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'), Auth::ENCRYPT_SHA1);
        $a->authenticate('testuser1', '12test34');
        $this->assertFalse($a->isValid());

        unset($a);

        $a = new Auth(new AuthFile(__DIR__ . '/../tmp/access.txt'), Auth::ENCRYPT_CRYPT, 'abcdefg');
        $a->authenticate('testuser1', '12test34');
        $this->assertFalse($a->isValid());
    }
}

?>