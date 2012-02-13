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

namespace Pop;

use Pop\Loader\Autoloader,
    Pop\Filter\String;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class StringTest extends \PHPUnit_Framework_TestCase
{

    public $string = 'Hello World';

    public function testStringFactory()
    {
        $s = String::factory($this->string);
        $class = 'Pop\\Filter\\String';
        $this->assertTrue($s instanceof $class);
    }

    public function testStringBasic()
    {
        $s = String::factory($this->string);
        $this->assertEquals('hello world', (string)$s->lower());
        $this->assertEquals('HELLO WORLD', (string)$s->upper());
        $this->assertEquals('/hello-world', (string)$s->slug());
        $s = String::factory($this->string);
        $this->assertEquals(md5('Hello World'), (string)$s->md5());
        $s = String::factory($this->string);
        $this->assertEquals(sha1('Hello World'), (string)$s->sha1());
    }

    public function testStringAdvanced()
    {
        $s = String::factory('HelloWorld');
        $this->assertEquals('hello-world', (string)$s->camelCaseToDash());
        $s = String::factory('HelloWorld');
        $this->assertEquals('hello_world', (string)$s->camelCaseToUnderscore());
        $s = String::factory('hello-world');
        $this->assertEquals('helloWorld', (string)$s->dashToCamelCase());
        $s = String::factory('hello-world');
        $this->assertEquals('hello_world', (string)$s->dashToUnderscore());
    }

}

