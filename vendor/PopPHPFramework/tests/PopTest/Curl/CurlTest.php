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

namespace PopTest\Curl;

use Pop\Loader\Autoloader,
    Pop\Curl\Curl;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class CurlTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $c = new Curl(array(
            CURLOPT_URL    => 'http://www.popphp.org/LICENSE.TXT',
            CURLOPT_HEADER => false,
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
        $c = new Curl(array(
            CURLOPT_URL    => 'http://www.popphp.org/version.txt',
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true
        ));
        $result = trim($c->execute());
        unset($c);
        $this->assertEquals('1.0.2', $result);
    }

    public function testSetAndGetOptions()
    {
        $c = new Curl(array(
            CURLOPT_URL    => 'http://www.popphp.org/version.txt',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_WRITEFUNCTION => true
        ));
        $c->setOption(CURLOPT_HEADER, false);
        $c->setOption(CURLOPT_WRITEFUNCTION, true);
        $this->assertEquals(1, $c->getOption(CURLOPT_RETURNTRANSFER));
        $this->assertEquals(0, $c->getOption(CURLOPT_HEADER));

    }

    public function testCurlNoReturn()
    {
        $c = new Curl(array(
            CURLOPT_URL    => 'http://www.popphp.org/version.txt',
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => false
        ));

        ob_start();
        $c->execute();
        $output = ob_get_clean();
        $info = $c->getinfo();
        $version = $c->version();
        unset($c);
        $this->assertEquals('1.0.2', trim($output));
        $this->assertEquals('http://www.popphp.org/version.txt', $info['url']);
        $this->assertEquals('text/plain', $info['content_type']);
        $this->assertTrue(isset($version['version']));
    }

    public function testCurlData()
    {
        $c = new Curl(array(
            CURLOPT_URL    => 'http://www.popphp.org/version.txt',
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_WRITEFUNCTION => true
        ));
        $c->execute();
        $this->assertEquals('1.0.2', trim($c->data));
    }

    public function testCurlError()
    {
        $c = new Curl(array(
            CURLOPT_URL    => 'http://blahblah.bla/',
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => false
        ));
        $this->setExpectedException('Pop\Curl\Exception');
        $c->execute();
    }

}

