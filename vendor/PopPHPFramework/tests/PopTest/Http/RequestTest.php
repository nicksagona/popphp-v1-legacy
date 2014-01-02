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
namespace PopTest\Http;

use Pop\Loader\Autoloader;
use Pop\Http\Request;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class RequestTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Http\Request', new Request());
    }

    public function testGetAndSetBasePath()
    {
        $r = new Request();
        $r->setBasePath('/admin');
        $this->assertEquals('/admin', $r->getBasePath());
    }

    public function testGetAndSetQuery()
    {
        $r = new Request();
        $r->setQuery('test', 123);
        $this->assertEquals(123, $r->getQuery('test'));
    }

    public function testGetAndSetPost()
    {
        $r = new Request();
        $r->setPost('test', 123);
        $this->assertEquals(123, $r->getPost('test'));
    }

    public function testGetAndSetHeaders()
    {
        $r = new Request();
        $this->assertNull($r->getHeader('Auth'));
        $this->assertEquals(0, count($r->getHeaders()));
    }

    public function testRequest()
    {
        $r = new Request();
        $r->setRequestUri('/test', '/admin');
        $this->assertEquals('/admin', $r->getBasePath());
        $this->assertEquals('/test', $r->getRequestUri());
        $this->assertEquals('/admin/test', $r->getFullUri());
        $this->assertFalse($r->isFile());
        $this->assertFalse($r->isSecure());
        $this->assertEquals('', $r->getDocRoot());
        $this->assertEquals('/admin', $r->getFullPath());
        $this->assertNull($r->getFilename());
        $this->assertEquals('http', $r->getScheme());
        $this->assertTrue(is_array($r->getQuery()));
        $this->assertNull($r->getQuery('test'));
        $this->assertTrue(is_array($r->getPost()));
        $this->assertNull($r->getPost('test'));
        $this->assertTrue(is_array($r->getPut()));
        $this->assertNull($r->getPut('test'));
        $this->assertTrue(is_array($r->getPatch()));
        $this->assertNull($r->getPatch('test'));
        $this->assertTrue(is_array($r->getDelete()));
        $this->assertNull($r->getDelete('test'));
        $this->assertTrue(is_array($r->getCookie()));
        $this->assertNull($r->getCookie('test'));
        $this->assertTrue(is_array($r->getServer()));
        $this->assertNull($r->getServer('test'));
        $this->assertTrue(is_array($r->getEnv()));
        $this->assertNull($r->getEnv('test'));
    }

    public function testGetPath()
    {
        $r = new Request();
        $r->setRequestUri('/test/something', '/admin');
        $this->assertEquals('test', $r->getPath(0));
        $this->assertEquals(2, count($r->getPath()));
    }

    public function testMethods()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $r = new Request();
        $this->assertTrue($r->isGet());
        $_SERVER['REQUEST_METHOD'] = 'HEAD';
        $r = new Request();
        $this->assertTrue($r->isHead());
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $r = new Request();
        $this->assertTrue($r->isPost());
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $r = new Request();
        $this->assertTrue($r->isPut());
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $r = new Request();
        $this->assertTrue($r->isDelete());
        $_SERVER['REQUEST_METHOD'] = 'TRACE';
        $r = new Request();
        $this->assertTrue($r->isTrace());
        $_SERVER['REQUEST_METHOD'] = 'OPTIONS';
        $r = new Request();
        $this->assertTrue($r->isOptions());
        $_SERVER['REQUEST_METHOD'] = 'CONNECT';
        $r = new Request();
        $this->assertTrue($r->isConnect());
        $_SERVER['REQUEST_METHOD'] = 'PATCH';
        $r = new Request();
        $this->assertTrue($r->isPatch());
        $this->assertEquals('PATCH', $r->getMethod());
    }

    public function testHost()
    {
        $_SERVER['HTTP_HOST'] = '';
        $_SERVER['SERVER_NAME'] = 'domain.com';
        $_SERVER['SERVER_PORT'] = '8443';
        $r = new Request();
        $this->assertEquals('domain.com:8443', $r->getHost());
        $_SERVER['HTTP_HOST'] = 'www.domain.com';
        $_SERVER['SERVER_NAME'] = 'domain.com';
        $_SERVER['SERVER_PORT'] = '80';
        $r = new Request();
        $this->assertEquals('www.domain.com', $r->getHost());
    }

    public function testIp()
    {
        $_SERVER['HTTP_X_FORWARDED_FOR'] = '255.255.255.255';
        $r = new Request();
        $this->assertEquals('255.255.255.255', $r->getIp(true));
        $_SERVER['HTTP_CLIENT_IP'] = '123.123.123.123';
        $r = new Request();
        $this->assertEquals('123.123.123.123', $r->getIp(true));
        unset($_SERVER['HTTP_X_FORWARDED_FOR']);
        unset($_SERVER['HTTP_CLIENT_IP']);
        $_SERVER['REMOTE_ADDR'] = '123.123.123.123';
        $r = new Request();
        $this->assertEquals('123.123.123.123', $r->getIp());

    }

}

