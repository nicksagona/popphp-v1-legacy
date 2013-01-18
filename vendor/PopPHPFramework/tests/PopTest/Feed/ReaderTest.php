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
        $this->assertInstanceOf('Pop\Feed\Reader', new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4));
        $this->assertInstanceOf('Pop\Feed\Reader', new Reader('http://vimeo.com/tag:mostviewed/rss', 4));
        $this->assertInstanceOf('Pop\Feed\Reader', new Reader('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 4));
        $this->assertInstanceOf('Pop\Feed\Reader', new Reader('http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=nicksagona', 4));
    }

    public function testConstructorException()
    {
        $this->setExpectedException('Pop\Feed\Exception');
        $feed = new Reader('http://blahblahblah/', 4);
    }

    public function testRenderException()
    {
        $this->setExpectedException('Pop\Feed\Exception');
        $feed = new Reader('http://vimeo.com/tag:mostviewed/rss', 4);
        $code = $feed->render(true);
    }

    public function testSetAndGetTemplate()
    {
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $feed->setTemplate('This is a template');
        $this->assertEquals('This is a template', $feed->getTemplate());
        $feed->setTemplate(__DIR__ . '/../tmp/access.txt');
        $this->assertContains('testuser', $feed->getTemplate());
    }

    public function testSetAndGetDatFormat()
    {
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $feed->setDateFormat('m/d/Y');
        $this->assertEquals('m/d/Y', $feed->getDateFormat());
    }

    public function testYouTubePlaylist()
    {
        $tmpl = '        <div class="feedDiv">\n            <a href="[{link}]" target="_blank">[{title}]</a><br />\n            <strong>[{pubDate}]</strong> ([{timeElapsed}])<br /><br />\n        </div>\n';
        $feed = new Reader('https://gdata.youtube.com/feeds/api/playlists/7F36BD9E41AB1AC5?v=2', 4);
        $feed->setTemplate($tmpl);
        $this->assertContains('<a href="http://www.youtube.com/', $feed->render(true));
    }

    public function testFeedType()
    {
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $this->assertEquals('atom', $feed->getFeedType());
    }

    public function testYouTubeRender()
    {
        $tmpl = '        <div class="feedDiv">\n            <a href="[{link}]" target="_blank">[{title}]</a><br />\n            <strong>[{pubDate}]</strong> ([{timeElapsed}])<br /><br />\n        </div>\n';
        $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $feed->setTemplate($tmpl);
        $code = $feed->render(true);
        ob_start();
        $feed->render();
        $output = ob_get_clean();
        $this->assertContains('<a href="http://www.youtube.com/', $code);
        $this->assertContains('<a href="http://www.youtube.com/', $output);
    }

    public function testRssRender()
    {
        $tmpl = '        <div class="feedDiv">\n            <a href="[{link}]" target="_blank">[{title}]</a><br />\n            <strong>[{pubDate}]</strong> ([{timeElapsed}])<br /><br />\n        </div>\n';
        $feed = new Reader('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss');
        $feed->setTemplate($tmpl);
        $code = $feed->render(true);
        ob_start();
        $feed->render();
        $output = ob_get_clean();
        $this->assertContains('<div class="feedDiv">', $code);
        $this->assertContains('<div class="feedDiv">', $output);
    }

    public function testRssTwitterRender()
    {
        $tmpl = '        <div class="feedDiv">\n            <a href="[{link}]" target="_blank">[{title}]</a><br />\n            <strong>[{pubDate}]</strong> ([{timeElapsed}])<br /><br />\n        </div>\n';
        $feed = new Reader('http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=nicksagona', 4);
        $feed->setTemplate($tmpl);
        $code = $feed->render(true);
        ob_start();
        $feed->render();
        $output = ob_get_clean();
        $this->assertContains('<div class="feedDiv">', $code);
        $this->assertContains('<div class="feedDiv">', $output);
    }

    public function testAtomRender()
    {
        $tmpl = '        <div class="feedDiv">\n            <a href="[{link}]" target="_blank">[{title}]</a><br />\n            <strong>[{pubDate}]</strong> ([{timeElapsed}])<br /><br />\n        </div>\n';
        $feed = new Reader('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=atom', 4);
        $feed->setTemplate($tmpl);
        $code = $feed->render(true);
        ob_start();
        $feed->render();
        $output = ob_get_clean();
        $this->assertContains('<div class="feedDiv">', $code);
        $this->assertContains('<div class="feedDiv">', $output);
    }

}

