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
    Pop\Http\Response;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $r = new Response(200, array('Content-Type' => 'text/plain'));
        $class = 'Pop\\Http\\Response';
        $this->assertTrue($r instanceof $class);
    }

    public function testSetCode()
    {
        $r = new Response(200, array('Content-Type' => 'text/plain'));
        $r->setCode(404);
        $this->assertEquals(404, $r->getCode());
    }

    public function testSetMessage()
    {
        $r = new Response(200, array('Content-Type' => 'text/plain'));
        $r->setMessage('OK');
        $this->assertEquals('OK', $r->getMessage());
    }

    public function testSetHeader()
    {
        $r = new Response(200, array('Content-Type' => 'text/plain'));
        $r->setHeader('Content-Type', 'text/plain');
        $this->assertEquals('text/plain', $r->getHeader('Content-Type'));
    }

    public function testSetBody()
    {
        $r = new Response(200, array('Content-Type' => 'text/plain'));
        $r->setBody('This is a test.');
        $this->assertEquals('This is a test.', $r->getBody());
    }

    public function testOutput()
    {
        $r = new Response(200, array('Content-Type' => 'text/plain'));
        $r->setBody('This is a test.');
        $response = $r->getHeadersAsString() . PHP_EOL . $r->getBody();
        $this->assertTrue((strpos($response, 'HTTP/1.1 200 OK') !== false));
        $this->assertTrue((strpos($response, 'Content-Type: text/plain') !== false));
        $this->assertTrue((strpos($response, 'This is a test') !== false));
    }

    public function testParse()
    {
        $r = Response::parse('http://www.popphp.org/version.txt');
        $this->assertEquals('200', $r->getCode());
        $this->assertEquals('OK', $r->getMessage());
        $this->assertEquals('0.9', trim($r->getBody()));
        $this->assertEquals('text/plain', $r->getHeader('Content-Type'));
        $this->assertTrue($r->isSuccessful());
        $this->assertFalse($r->isError());
    }

}

