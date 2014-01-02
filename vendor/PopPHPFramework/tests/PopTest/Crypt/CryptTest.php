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
namespace Pop;

use Pop\Loader\Autoloader;
use Pop\Crypt;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CryptTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructors()
    {
        $c = new Crypt\Crypt();
        $b = new Crypt\Bcrypt();
        $m = new Crypt\Mcrypt();
        $md5 = new Crypt\Md5();
        $sha = new Crypt\Sha();
        $this->assertInstanceOf('Pop\Crypt\Crypt', $c);
        $this->assertInstanceOf('Pop\Crypt\Bcrypt', $b);
        $this->assertInstanceOf('Pop\Crypt\Mcrypt', $m);
        $this->assertInstanceOf('Pop\Crypt\Md5', $md5);
        $this->assertInstanceOf('Pop\Crypt\Sha', $sha);
    }

    public function testCrypt()
    {
        $crypt = new Crypt\Crypt();
        $crypt->setSalt('Test Salt');
        $this->assertEquals('Test Salt', $crypt->getSalt());
        $hash = $crypt->create('12password34');
        $this->assertTrue($crypt->verify('12password34', $hash));
    }

    public function testBcrypt()
    {
        $crypt = new Crypt\Bcrypt();
        $crypt->setSalt('Test Salt');

        $crypt->setCost('40');
        $this->assertEquals('31', $crypt->getCost());
        $crypt->setCost('03');
        $this->assertEquals('04', $crypt->getCost());

        $crypt->setPrefix('$2a$');
        $crypt->setCost('10');
        $this->assertEquals('Test Salt', $crypt->getSalt());
        $this->assertEquals('$2a$', $crypt->getPrefix());
        $this->assertEquals('10', $crypt->getCost());
        $hash = $crypt->create('12password34');
        $this->assertTrue($crypt->verify('12password34', $hash));
    }

    public function testMcrypt()
    {
        $crypt = new Crypt\Mcrypt();
        $crypt->setSalt('Test Salt');
        $this->assertEquals('Test Salt', $crypt->getSalt());
        $this->assertEquals(MCRYPT_RIJNDAEL_256, $crypt->getCipher());
        $this->assertEquals(MCRYPT_MODE_CBC, $crypt->getMode());
        $this->assertEquals(MCRYPT_RAND, $crypt->getSource());
        $hash = $crypt->create('12password34');
        $this->assertTrue($crypt->verify('12password34', $hash));
        $this->assertNotNull($crypt->getIv());
        $this->assertNotNull($crypt->getIvSize());
        $this->assertEquals('12password34', $crypt->decrypt($hash));
    }

    public function testMd5()
    {
        $crypt = new Crypt\Md5();
        $crypt->setSalt('Test Salt');
        $this->assertEquals('Test Salt', $crypt->getSalt());
        $hash = $crypt->create('12password34');
        $this->assertTrue($crypt->verify('12password34', $hash));
    }

    public function testSha256()
    {
        $crypt = new Crypt\Sha();
        $crypt->setSalt('Test Salt');
        $crypt->setRounds(10000);
        $this->assertEquals('Test Salt', $crypt->getSalt());
        $this->assertEquals(10000, $crypt->getRounds());
        $hash = $crypt->create('12password34');
        $this->assertTrue($crypt->verify('12password34', $hash));
    }

    public function testSha512()
    {
        $crypt = new Crypt\Sha(512);
        $crypt->setRounds(1000000000);
        $this->assertEquals(999999999, $crypt->getRounds());
        $crypt->setRounds(100);
        $this->assertEquals(1000, $crypt->getRounds());
        $this->assertEquals(512, $crypt->getBits());
        $hash = $crypt->create('12password34');
        $this->assertTrue($crypt->verify('12password34', $hash));
    }

    public function testShaBitsException()
    {
        $this->setExpectedException('Pop\Crypt\Exception');
        $crypt = new Crypt\Sha();
        $crypt->setBits(100);
    }

}

