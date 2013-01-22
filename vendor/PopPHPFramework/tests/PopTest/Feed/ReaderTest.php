<?php
/**
 * Pop PHP Framework Unit Tests (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Test
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace PopTest\Feed;

use Pop\Loader\Autoloader,
    Pop\Feed\Reader;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Feed\Reader', new Reader('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 4));
        $this->assertInstanceOf('Pop\Feed\Reader', Reader::parseByUrl('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 4));
    }

    public function testConstructorException()
    {
        $this->setExpectedException('Pop\Feed\Exception');
        $feed = new Reader('http://blahblahblah/', 4);
    }

    public function testParseByName()
    {
        $feed = Reader::parseByName('highvoltagenola', 'facebook', 4);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Reader::parseByName('highvoltagenola', 'facebook', 4, Reader::ATOM);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Reader::parseByName('highvoltagenola', 'twitter', 4);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Reader::parseByName('highvoltagenola', 'youtube', 4);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Reader::parseByName('highvoltagenola', 'youtube', 4, Reader::ATOM);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Reader::parseByName('royraz', 'vimeo', 4);
        $this->assertGreaterThan(0, $feed->items);
    }

    public function testParseById()
    {
        $feed = Reader::parseById('49700389248', 'facebook', 4);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Reader::parseById('49700389248', 'facebook', 4, Reader::ATOM);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Reader::parseById('35318AF7BEB5DD11', 'youtube', 4);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Reader::parseById('35318AF7BEB5DD11', 'youtube', 4, Reader::ATOM);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Reader::parseById('2136270', 'vimeo', 4);
        $this->assertGreaterThan(0, $feed->items);
    }

    public function testParseByIdNoUrlException()
    {
        $this->setExpectedException('Pop\Feed\Exception');
        $feed = Reader::parseById('1234567890', 'Twitter', 4);
    }

    public function testRenderException()
    {
        $this->setExpectedException('Pop\Feed\Exception');
        $feed = new Reader('http://vimeo.com/tag:mostviewed/rss', 4);
        $code = $feed->render(true);
    }

    public function testUrl()
    {
        $feed = new Reader('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 4);
        $this->assertEquals('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', $feed->url());
    }

    public function testXml()
    {
        $feed = new Reader('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 4);
        $this->assertInstanceOf('SimpleXmlElement', $feed->xml());
    }

    public function testFeedType()
    {
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $this->assertEquals('atom', $feed->getType());
    }

    public function testGetLimit()
    {
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $this->assertEquals(4, $feed->getLimit());
    }

    public function testSetAndGetTemplate()
    {
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $feed->setTemplate('This is a template');
        $this->assertEquals('This is a template', $feed->getTemplate());
        $feed->setTemplate(__DIR__ . '/../tmp/access.txt');
        $this->assertContains('testuser', $feed->getTemplate());
    }

    public function testSetAndGetDateFormat()
    {
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $feed->setDateFormat('m/d/Y');
        $this->assertEquals('m/d/Y', $feed->getDateFormat());
    }

    public function testSetAndGetFeed()
    {
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $feed->setFeed(array('test' => 123));
        $f = $feed->getFeed();
        $feed->something = 456;
        $this->assertEquals($f['test'], $feed->test);
        $this->assertTrue(isset($feed->something));
        $this->assertEquals(456, $feed->something);
        unset($feed->something);
        $this->assertNull($feed->something);
        $feed->entry = 123;
        $feed->entries = 456;
        $this->assertTrue(isset($feed->entry));
        $this->assertTrue(isset($feed->entries));
        $this->assertEquals(123, $feed->entry);
        $this->assertEquals(456, $feed->entries);
        unset($feed->entry);
        unset($feed->entries);
        $this->assertNull($feed->entry);
        $this->assertNull($feed->entries);
    }

    public function testSetAndGetPrefix()
    {
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $feed->setPrefix('SomeClass\\');
        $this->assertEquals('SomeClass\\', $feed->getPrefix());
    }

    public function testBooleanMethods()
    {
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $this->assertTrue($feed->isAtom());
        $this->assertFalse($feed->isRss());
        $this->assertTrue($feed->isYoutube());
        $this->assertFalse($feed->isFacebook());
        $this->assertFalse($feed->isTwitter());
        $this->assertFalse($feed->isVimeo());
        $this->assertFalse($feed->isPlaylist());
    }

    public function testRssRender()
    {
        $tmpl = <<<NEWS
    <div class="news-div">
        <a href="[{link}]">[{title}]</a><br />
        <strong>[{published}]</strong> ([{time}])<br />
        <p>[{description}]</p>
    </div>

NEWS;

        $feedRss = new Reader('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 3);
        $feedRss->setTemplate($tmpl);
        $code = $feedRss->render(true);
        ob_start();
        $feedRss->render();
        $output = ob_get_clean();

        ob_start();
        echo $feedRss;
        $echoOutput = ob_get_clean();
        $this->assertContains('<div class="news-div">', $code);
        $this->assertContains('<div class="news-div">', $output);
        $this->assertContains('<div class="news-div">', $echoOutput);
    }

    public function testAtomRender()
    {
        $tmpl = <<<NEWS
    <div class="news-div">
        <a href="[{link}]">[{title}]</a><br />
        <strong>[{published}]</strong> ([{time}])<br />
        <p>[{description}]</p>
    </div>

NEWS;

        $feedAtom = new Reader('https://www.facebook.com/feeds/page.php?id=49700389248&format=atom10', 3);
        $feedAtom->setTemplate($tmpl);
        $code = $feedAtom->render(true);
        ob_start();
        $feedAtom->render();
        $output = ob_get_clean();

        ob_start();
        echo $feedAtom;
        $echoOutput = ob_get_clean();
        $this->assertContains('<div class="news-div">', $code);
        $this->assertContains('<div class="news-div">', $output);
        $this->assertContains('<div class="news-div">', $echoOutput);
    }

}

