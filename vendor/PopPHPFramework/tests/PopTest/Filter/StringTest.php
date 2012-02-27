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
    Pop\Filter\String,
    Pop\Validator\Validator;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class StringTest extends \PHPUnit_Framework_TestCase
{

    public $string = 'Hello World';

    public function testStringFactory()
    {
        $this->assertInstanceOf('Pop\\Filter\\String', String::factory($this->string));
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

    public function testStringRandom()
    {
        $s = String::random(6);
        $this->assertEquals(6, strlen($s));

        $s = String::random(6, String::ALPHANUM, String::LOWER);
        $val = new Validator(new Validator\AlphaNumeric());
        $this->assertTrue($val->evaluate((string)$s));

        $s = String::random(6, String::ALPHA, String::UPPER);
        $val = new Validator(new Validator\Alpha());
        $this->assertTrue($val->evaluate((string)$s));
    }

    public function testUpperWords()
    {
        $s = String::factory('hello world');
        $this->assertEquals('Hello World', (string)$s->upperWords());
    }

    public function testUpperFirst()
    {
        $s = String::factory('hello world');
        $this->assertEquals('Hello world', (string)$s->upperFirst());
    }

    public function testBetween()
    {
        $s = String::factory('hello -world* test');
        $this->assertEquals('world', (string)$s->between('-', '*'));
    }

    public function testReplaceCase()
    {
        $s = String::factory('hello world');
        $this->assertEquals('hello squirrel', (string)$s->replace('WORLD', 'squirrel', false));
    }

    public function testReplaceCaseArray()
    {
        $ary = array(array('WORLD', 'squirrel'), array('GIRL', 'boy'));
        $s = String::factory('hello world, hello girl');
        $this->assertEquals('hello squirrel, hello boy', (string)$s->replace($ary, null, false));
    }

    public function testPregReplace()
    {
        $s = String::factory('hello world');
        $this->assertEquals('hello-world', (string)$s->pregReplace('/\s/', '-'));
    }

    public function testTrim()
    {
        $s = String::factory(' hello world ');
        $this->assertEquals('hello world', (string)$s->trim());
    }

    public function testTrimChars()
    {
        $s = String::factory("\nhello world ");
        $this->assertEquals('hello world ', (string)$s->trim("\n"));
    }

    public function testAddSlashes()
    {
        $s = String::factory("hello ' world");
        $this->assertEquals("hello \\' world", (string)$s->addSlashes());
    }

    public function testStripSlashes()
    {
        $s = String::factory("hello \\' world");
        $this->assertEquals("hello ' world", (string)$s->stripSlashes());
    }

    public function testStripTags()
    {
        $s = String::factory("hello<br />world");
        $this->assertEquals("helloworld", (string)$s->stripTags());
    }

    public function testStripTagsAllowed()
    {
        $s = String::factory("hello<br /><a href=\"#\">world</a>");
        $this->assertEquals("hello<br />world", (string)$s->stripTags('<br>'));
    }

    public function testHtmlAndDeHtml()
    {
        $s = String::factory("hello<br /><a href=\"#\">world</a>");
        $this->assertEquals("hello&lt;br /&gt;&lt;a href=&quot;#&quot;&gt;world&lt;/a&gt;", (string)$s->html());
        $s = String::factory("hello&lt;br /&gt;&lt;a href=&quot;#&quot;&gt;world&lt;/a&gt;");
        $this->assertEquals("hello<br /><a href=\"#\">world</a>", (string)$s->dehtml());
    }

    public function testBr()
    {
        $s = String::factory("hello\nworld");
        $this->assertEquals("hello<br />\nworld", (string)$s->br());
    }

    public function testEscape()
    {
        $s = String::factory("\\\n\r\x00\x1a'\"%_");
        $this->assertEquals("\\\\\\n\\r\\x00\\x1a\\'\\\"\\%\\_", (string)$s->escape(true));
    }

    public function testClean()
    {
        $ms = chr(146) . chr(147) . chr(148) . chr(150) . chr(133);
        $s = String::factory($ms);
        $this->assertEquals("'\"\"&#150;...", (string)$s->clean());
        $s = String::factory($ms);
        $this->assertEquals("&#39;&#34;&#34;&#150;...", (string)$s->clean(true));

    }

    public function testDosToUnix()
    {
        $s = String::factory("hello\r\n");
        $this->assertEquals("hello\n", (string)$s->dosToUnix());
    }

    public function testUnixToDos()
    {
        $s = String::factory("hello\n");
        $this->assertEquals("hello\r\n", (string)$s->unixToDos());
    }

    public function testSlug()
    {
        $s = String::factory("Hello | World");
        $this->assertEquals("/hello/world", (string)$s->slug(' | '));
        $s = String::factory('');
        $this->assertEquals('', (string)$s->slug());
    }

    public function testLinks()
    {
        $s = String::factory('hello world: http://www.google.com/');
        $this->assertEquals('hello world: <a href="http://www.google.com/">http://www.google.com/</a>', (string)$s->links());
        $s = String::factory('hello world: http://www.google.com/');
        $this->assertEquals('hello world: <a target="_blank" href="http://www.google.com/">http://www.google.com/</a>', (string)$s->links(true));
    }

    public function testCrypt()
    {
        $s = String::factory('123456');
        $this->assertGreaterThan(1, strlen($s->crypt()));
        $s = String::factory('123456');
        $this->assertEquals('09wwM231u9CnE', $s->crypt('098765'));
    }

    public function testCamelCaseToSeparator()
    {
        $s = String::factory('helloWorld');
        $this->assertEquals('hello' . DIRECTORY_SEPARATOR . 'world', (string)$s->camelCaseToSeparator());
    }

    public function testDashToSeparator()
    {
        $s = String::factory('hello-world');
        $this->assertEquals('hello' . DIRECTORY_SEPARATOR . 'world', (string)$s->dashToSeparator());
    }

    public function testUnderscoreToCamelCase()
    {
        $s = String::factory('hello_world');
        $this->assertEquals('helloWorld', (string)$s->underscoreToCamelcase());
    }

    public function testUnderscoreToDash()
    {
        $s = String::factory('hello_world');
        $this->assertEquals('hello-world', (string)$s->underscoreToDash());
    }

    public function testUnderscoreToSeparator()
    {
        $s = String::factory('hello_world');
        $this->assertEquals('hello' . DIRECTORY_SEPARATOR . 'world', (string)$s->underscoreToSeparator());
    }

}

