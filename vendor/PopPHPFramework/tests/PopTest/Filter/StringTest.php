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
use Pop\Filter\String;
use Pop\Validator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class StringTest extends \PHPUnit_Framework_TestCase
{

    public $string = 'Hello World';

    public $key = '123456789';

    public function testString()
    {
        $this->assertEquals('hello-world', String::camelCaseToDash('HelloWorld'));
        $this->assertEquals('hello_world', String::camelCaseToUnderscore('HelloWorld'));
        $this->assertEquals('helloWorld', String::dashToCamelCase('hello-world'));
        $this->assertEquals('hello_world', String::dashToUnderscore('hello-world'));
    }

    public function testStringRandom()
    {
        $s = String::random(6);
        $this->assertEquals(6, strlen($s));

        $s = String::random(6, String::ALPHANUM, String::LOWER);
        $val = new Validator\AlphaNumeric();
        $this->assertTrue($val->evaluate($s));

        $s = String::random(6, String::ALPHA, String::UPPER);
        $val = new Validator\Alpha();
        $this->assertTrue($val->evaluate($s));
    }

    public function testBetween()
    {
        $this->assertEquals('world', String::between('hello -world* test', '-', '*'));
    }

    public function testEscape()
    {
        $this->assertEquals("\\\\\\n\\r\\x00\\x1a\\'\\\"\\%\\_", String::escape("\\\n\r\x00\x1a'\"%_", true));
    }

    public function testClean()
    {
        $ms = chr(146) . chr(147) . chr(148) . chr(150) . chr(133);
        $this->assertEquals("'\"\"&#150;...", String::clean($ms));
        $this->assertEquals("&#39;&#34;&#34;&#150;...", String::clean($ms, true));
    }

    public function testDosToUnix()
    {
        $this->assertEquals("hello\n", String::dosToUnix("hello\r\n"));
    }

    public function testUnixToDos()
    {
        $this->assertEquals("hello\r\n", String::unixToDos("hello\n"));
    }

    public function testSlug()
    {
        $this->assertEquals('hello-world', String::slug($this->string));
        $this->assertEquals("hello/world", String::slug('Hello | World', ' | '));
        $this->assertEquals('', String::slug(''));
    }

    public function testLinks()
    {
        $this->assertEquals('hello world: <a href="http://www.google.com/">http://www.google.com/</a>', String::links('hello world: http://www.google.com/'));
        $this->assertEquals('hello world: <a target="_blank" href="http://www.google.com/">http://www.google.com/</a>', String::links('hello world: http://www.google.com/', true));
    }

    public function testCamelCaseToSeparator()
    {
        $this->assertEquals('hello' . DIRECTORY_SEPARATOR . 'world', String::camelCaseToSeparator('helloWorld'));
    }

    public function testDashToSeparator()
    {
        $this->assertEquals('hello' . DIRECTORY_SEPARATOR . 'world', String::dashToSeparator('hello-world'));
    }

    public function testUnderscoreToCamelCase()
    {
        $this->assertEquals('helloWorld', String::underscoreToCamelcase('hello_world'));
    }

    public function testUnderscoreToDash()
    {
        $this->assertEquals('hello-world', String::underscoreToDash('hello_world'));
    }

    public function testUnderscoreToSeparator()
    {
        $this->assertEquals('hello' . DIRECTORY_SEPARATOR . 'world', String::underscoreToSeparator('hello_world'));
    }

}

