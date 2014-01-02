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
use Pop\Auth\Auth;
use Pop\Auth\Role;
use Pop\Auth\Adapter\File;
use Pop\Auth\Adapter\Table;
use Pop\Db\Db;
use Pop\Db\Record;

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
        $this->assertInstanceOf('Pop\Auth\Auth', new Auth(new File(__DIR__ . '/../tmp/access.txt')));
        $this->assertInstanceOf('Pop\Auth\Auth', Auth::factory(new File(__DIR__ . '/../tmp/access.txt')));
    }

    public function testBadFile()
    {
        $this->setExpectedException('Pop\Auth\Adapter\Exception');
        $a = new Auth(new File(__DIR__ . '/../tmp/badaccess.txt'));
    }

    public function testIsValidWithFile()
    {
        $a = new Auth(new File(__DIR__ . '/../tmp/access.txt'));
        $a->authenticate('testuser1', '12test34');
        $this->assertTrue($a->isValid());
        $this->assertEquals(1, $a->getAttempts());
        $this->assertEquals(0, $a->getEncryption());
        $this->assertEquals(1, $a->getResult());
        $this->assertEquals('The user is valid.', $a->getResultMessage());
        $u = $a->getUser();
        $this->assertEquals('testuser1', $u['username']);

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

    public function testIsValidWithTable()
    {
        $a = new Auth(new Table('PopTest\Auth\Users', 'username', 'password', 'access'));
        $a->authenticate('test1', 'password1');
        $this->assertTrue($a->isValid());
        $u = $a->getUser();
        $this->assertEquals('test1', $u['username']);

        $a->authenticate('baduser', '123456');
        $this->assertFalse($a->isValid());

        $a->authenticate('test1', 'wrongpass');
        $this->assertFalse($a->isValid());

        $a->authenticate('test8', 'password8');
        $this->assertFalse($a->isValid());

        $a->authenticate('test1', 'password1');
        $this->assertTrue($a->isValid());
    }

    public function testSetAttemptLimit()
    {
        $a = new Auth(new File(__DIR__ . '/../tmp/access.txt'));
        $a->setAttempts(5);
        $a->setAttemptLimit(3);
        $a->authenticate('testuser1', '12test34');
        $this->assertEquals(Auth::ATTEMPTS_EXCEEDED, $a->getResult());
        $this->assertEquals('The allowed login attempts (3) have been exceeded.', $a->getResultMessage());
        $this->assertEquals(6, $a->getAttempts());
        $this->assertEquals(3, $a->getValidator('attempts')->getValue());
        $a->setAttemptLimit();
        $this->assertEquals(null, $a->getValidator('attempts'));
    }

    public function testSetBlockedIps()
    {
        $a = new Auth(new File(__DIR__ . '/../tmp/access.txt'));
        $a->setBlockedIps(array('123.123.123.123', '124.124.124.124'));
        $this->assertEquals(array('123.123.123.123', '124.124.124.124'), $a->getValidator('blockedIps')->getValue());
        $a->setBlockedIps();
        $this->assertEquals(null, $a->getValidator('blockedIps'));
    }

    public function testSetBlockedSubnets()
    {
        $a = new Auth(new File(__DIR__ . '/../tmp/access.txt'));
        $a->setBlockedSubnets(array('123.123.123', '124.124.124'));
        $this->assertEquals(array('123.123.123', '124.124.124'), $a->getValidator('blockedSubnets')->getValue());
        $a->setBlockedSubnets();
        $this->assertEquals(null, $a->getValidator('blockedSubnets'));
    }

    public function testSetAllowedIps()
    {
        $a = new Auth(new File(__DIR__ . '/../tmp/access.txt'));
        $a->setAllowedIps('123.123.123.123');
        $a->setAllowedIps(array('123.123.123.123', '124.124.124.124'));
        $this->assertEquals(array('123.123.123.123', '124.124.124.124'), $a->getValidator('allowedIps')->getValue());
        $a->setAllowedIps();
        $this->assertEquals(null, $a->getValidator('allowedIps'));
    }

    public function testSetAllowedSubnets()
    {
        $a = new Auth(new File(__DIR__ . '/../tmp/access.txt'));
        $a->setAllowedSubnets('123.123.123');
        $a->setAllowedSubnets(array('123.123.123', '124.124.124'));
        $this->assertEquals(array('123.123.123', '124.124.124'), $a->getValidator('allowedSubnets')->getValue());
        $a->setAllowedSubnets();
        $this->assertEquals(null, $a->getValidator('allowedSubnets'));
    }

    public function testPasswordEncryptionOptions()
    {
        $a = new Auth(new File(__DIR__ . '/../tmp/access.txt'), Auth::ENCRYPT_CRYPT_SHA_256, array('rounds' => 10000));
        $opts = $a->getEncryptionOptions();
        $this->assertEquals(10000, $opts['rounds']);
        $a->setEncryptionOptions(array('rounds' => 7500));
        $opts = $a->getEncryptionOptions();
        $this->assertEquals(7500, $opts['rounds']);
    }

    public function testPasswordEncryption()
    {
        $a = new Auth(new File(__DIR__ . '/../tmp/access.txt'), Auth::ENCRYPT_MD5);
        $a->authenticate('testuser1', '12test34');
        $this->assertFalse($a->isValid());

        unset($a);

        $a = new Auth(new File(__DIR__ . '/../tmp/access.txt'), Auth::ENCRYPT_SHA1);
        $a->authenticate('testuser1', '12test34');
        $this->assertFalse($a->isValid());

        unset($a);

        $a = new Auth(new File(__DIR__ . '/../tmp/access.txt'), Auth::ENCRYPT_CRYPT, array('salt' => 'abcdefg'));
        $a->authenticate('testuser1', '12test34');
        $this->assertFalse($a->isValid());
    }

}
