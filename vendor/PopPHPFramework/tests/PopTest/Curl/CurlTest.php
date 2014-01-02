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
namespace PopTest\Curl;

use Pop\Loader\Autoloader;
use Pop\Curl\Curl;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CurlTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $c = new Curl('http://www.popphp.org/license', array(
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => false
        ));
        $this->assertInstanceOf('Pop\Curl\Curl', $c);

        ob_start();
        $result = $c->execute();
        $output = ob_get_clean();
        $this->assertTrue($result);
        $this->assertContains('New BSD', $output);
    }

    public function testCurl()
    {
        $c = new Curl('http://www.popphp.org/version', array(
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true
        ));
        $result = trim($c->execute());
        unset($c);
        $this->assertEquals('1.7.0', $result);
    }

    public function testSetReturnHeader()
    {
        $c = new Curl('http://www.popphp.org/version', array(
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => false
        ));

        $c->setReturnHeader(true);
        $this->assertTrue($c->isReturnHeader());
    }

    public function testSetReturnTransfer()
    {
        $c = new Curl('http://www.popphp.org/version', array(
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => false
        ));

        $c->setReturnTransfer(true);
        $this->assertTrue($c->isReturnTransfer());
    }

    public function testSetPost()
    {
        $c = new Curl('http://www.popphp.org/version', array(
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true
        ));

        $c->setPost(true);
        $this->assertTrue($c->isPost());
    }

    public function testSetAndGetFields()
    {
        $c = new Curl('http://www.popphp.org/version', array(
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true
        ));

        $c->setFields(array('name' => 'Test'));
        $c->setField('email', 'test@test.com');
        $this->assertEquals('Test', $c->getField('name'));
        $this->assertEquals(2, count($c->getFields()));
    }

    public function testSetAndGetOptions()
    {
        $c = new Curl('http://www.popphp.org/version', array(
            CURLOPT_RETURNTRANSFER => true
        ));
        $c->setOption(CURLOPT_HEADER, false);
        $this->assertEquals(1, $c->getOption(CURLOPT_RETURNTRANSFER));
        $this->assertEquals(0, $c->getOption(CURLOPT_HEADER));
    }

    public function testCurlNoReturn()
    {
        $c = new Curl('http://www.popphp.org/version', array(
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => false
        ));

        ob_start();
        $c->execute();
        $output = ob_get_clean();
        $info = $c->getinfo();
        $version = $c->version();
        unset($c);
        $this->assertEquals('1.7.0', trim($output));
        $this->assertEquals('http://www.popphp.org/version', $info['url']);
        $this->assertEquals('text/plain', $info['content_type']);
        $this->assertTrue(isset($version['version']));
    }

    public function testResponse()
    {
        $c = new Curl('http://www.popphp.org/version', array(
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true
        ));
        $c->execute();
        $this->assertEquals('1.7.0', $c->getResponse());
    }

    public function testHeadersAndBody()
    {
        $c = new Curl('http://www.popphp.org/version', array(
            CURLOPT_HEADER         => true,
            CURLOPT_RETURNTRANSFER => true
        ));
        $c->execute();
        $this->assertEquals('text/plain', $c->getHeader('Content-Type'));
        $this->assertGreaterThan(1, count($c->getHeaders()));
        $this->assertContains('HTTP', $c->getRawHeader());
        $this->assertEquals('1.7.0', $c->getBody());
        $this->assertEquals('200', $c->getCode());
        $this->assertEquals('1.1', $c->getHttpVersion());
        $this->assertEquals('OK', $c->getMessage());
    }

    public function testCurlError()
    {
        $c = new Curl('http://badurl/', array(
            CURLOPT_RETURNTRANSFER => false
        ));
        $this->setExpectedException('Pop\Curl\Exception');
        $c->execute();
    }

}

