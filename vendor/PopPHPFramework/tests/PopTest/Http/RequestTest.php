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

namespace PopTest\Http;

use Pop\Loader\Autoloader,
    Pop\Http\Request;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class RequestTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\\Http\\Request', new Request());
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

    public function testRequest()
    {
        $r = new Request();
        $r->setRequestUri('/test', '/admin');
        $this->assertEquals('/test', $r->getRequestUri());
        $this->assertEquals('/admin', $r->getBasePath());
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
        $this->assertTrue(is_array($r->getCookie()));
        $this->assertNull($r->getCookie('test'));
        $this->assertTrue(is_array($r->getServer()));
        $this->assertNull($r->getServer('test'));
        $this->assertTrue(is_array($r->getEnv()));
        $this->assertNull($r->getEnv('test'));
    }

}

