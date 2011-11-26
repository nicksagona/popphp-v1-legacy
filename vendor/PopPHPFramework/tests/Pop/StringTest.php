<?php
/**
 * Pop PHP Framework
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
 * @category   Pop
 * @package    Pop_String
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once dirname(__FILE__) . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_StringTest extends PHPUnit_Framework_TestCase
{

    public function testStringConstructor()
    {
        $s = new Pop_String('This is a string');
        $class = 'Pop_String';
        $this->assertTrue($s instanceof $class);
    }

    public function testStringToString()
    {
        $x = 'This is a string';
        $s = new Pop_String($x);
        $this->assertEquals($x, (string)$s);
    }

    public function testStringFactory()
    {
        $s = Pop_String::factory('This is a string');
        $class = 'Pop_String';
        $this->assertTrue($s instanceof $class);
    }


    public function testStringCanComputeLength()
    {
        $x = 'This is a string';
        $s = new Pop_String($x);
        $this->assertEquals(strlen($x), $s->length());
    }

    public function testStringCanComputePosition()
    {
        $x = 'This is a string';
        $s = new Pop_String($x);
        $c = 'str';
        $this->assertEquals(strpos($x, $c), $s->pos($c));
    }

    public function testStringCanComputeiPosition()
    {
        $x = 'This is a String';
        $s = new Pop_String($x);
        $c = 'str';
        $this->assertEquals(stripos($x, $c), $s->ipos($c));
    }

    public function testStringCanSplitString()
    {
        $x = 'one|two|three|four|five';
        $s = new Pop_String($x);
        $d = '|';
        $this->assertEquals(explode($d, $x), $s->split($d));
    }

    public function testStringCanGlueString()
    {
        $x = array('one', 'two', 'three', 'four', 'five');
        $s = new Pop_String();
        $d = '|';
        $this->assertEquals(implode($d, $x), (string)$s->glue($d, $x));
    }

    public function testStringCanLowerString()
    {
        $x = 'This Is A String';
        $s = new Pop_String($x);
        $this->assertEquals(strtolower($x), (string)$s->lower());
    }

    public function testStringCanUpperString()
    {
        $x = 'this is a string';
        $s = new Pop_String($x);
        $this->assertEquals(ucwords($x), (string)$s->upper());
    }

    public function testStringCanUpperAllString()
    {
        $x = 'this is a string';
        $s = new Pop_String($x);
        $this->assertEquals(strtoupper($x), (string)$s->upperall());
    }

    public function testStringCanUpperFirst()
    {
        $x = 'this is a string';
        $s = new Pop_String($x);
        $this->assertEquals(ucfirst($x), (string)$s->upperfirst());
    }

    public function testStringCanSubString()
    {
        $x = 'this is a string';
        $s = new Pop_String($x);
        $start = 5;
        $this->assertEquals(substr($x, $start), (string)$s->sub($start));
    }

    public function testStringCanBetween()
    {
        $x = 'this! is! a string';
        $s = new Pop_String($x);

        $x = substr($x, (strpos($x, '!') + strlen('!')));
        $x = substr($x, 0, (strpos($x, '!')));

        $this->assertEquals($x, (string)$s->between('!', '!'));
    }

    public function testStringCanReplace()
    {
        $x = 'This is a string';
        $s = new Pop_String($x);
        $search = 'This';
        $replace = 'That';
        $this->assertEquals(str_replace($search, $replace, $x), (string)$s->replace($search, $replace));
    }

    public function testStringCaniReplace()
    {
        $x = 'This is a string';
        $s = new Pop_String($x);
        $search = 'this';
        $replace = 'that';
        $this->assertEquals(str_ireplace($search, $replace, $x), (string)$s->ireplace($search, $replace));
    }

    public function testStringCanPregReplace()
    {
        $x = 'This is a string';
        $s = new Pop_String($x);
        $pattern = '/string/';
        $replace = 'STRING';
        $this->assertEquals(preg_replace($pattern, $replace, $x), (string)$s->preplace($pattern, $replace));
    }

    public function testStringCanAddSlashes()
    {
        $x = "This is 'a string'";
        $s = new Pop_String($x);
        $this->assertEquals(addslashes($x), (string)$s->add());
    }

    public function testStringCanStripSlashes()
    {
        $x = "This is \\'a string\\'";
        $s = new Pop_String($x);
        $this->assertEquals(stripslashes($x), (string)$s->strip());
    }

    public function testStringCanConvertToBr()
    {
        $x = "This is a string\nAnd another string\n";
        $s = new Pop_String($x);
        $this->assertEquals(nl2br($x), (string)$s->br());
    }

    public function testStringCanWrap()
    {
        $x = "This is a string And another string This is a string.";
        $s = new Pop_String($x);
        $str1 = (string)$s->wrap('15');
        $str2 = wordwrap("This is a string And another string This is a string.", 15, "\n");
        $this->assertEquals($str1, $str2);
    }

    public function testStringCanConvertToHtml()
    {
        $x = "<p>This is a string</p>";
        $s = new Pop_String($x);
        $this->assertEquals(htmlentities($x, ENT_QUOTES, 'UTF-8'), (string)$s->html());
    }

    public function testStringCanConvertFromHtml()
    {
        $x = "&lt;p&gt;This is a string&lt;/p&gt;";
        $s = new Pop_String($x);
        $this->assertEquals(html_entity_decode($x, ENT_QUOTES, 'UTF-8'), (string)$s->dehtml());
    }

    public function testStringCanConvertToSlug()
    {
        $s = new Pop_String("Hello You 283 &^%$ 'Dud\\e798(*0:");
        $expected = '/hello-you-283-and-dude7980';
        $this->assertEquals($expected, (string)$s->slug());
    }

    public function testStringCanConvertToLinks()
    {
        $s = new Pop_String("http://www.moc10media.com/ is a website");
        $expected = "<a href=\"http://www.moc10media.com/\">http://www.moc10media.com/</a> is a website";
        $this->assertEquals($expected, (string)$s->links());
    }

    public function testStringCanFormatDate()
    {
        $x = "2009-08-28";
        $s = new Pop_String($x);
        $format = 'm/d/Y';
        $this->assertEquals(date($format, strtotime($x)), (string)$s->date($format));
    }

    public function testStringCanGenerateRandom()
    {
        $s = new Pop_String();
        $s->random(7);
        $this->assertEquals(7, $s->length());
    }

}

?>