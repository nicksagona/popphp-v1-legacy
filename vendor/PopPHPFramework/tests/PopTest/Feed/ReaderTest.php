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
namespace PopTest\Feed;

use Pop\Loader\Autoloader;
use Pop\Feed;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class ReaderTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\Feed\Reader', new Feed\Reader(
            new Feed\Format\Rss('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 4)
        ));
        $this->assertInstanceOf('Pop\Feed\Reader', Feed\Reader::factory(
            new Feed\Format\Rss('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 4)
        ));
        $this->assertInstanceOf('Pop\Feed\Reader', Feed\Reader::getByUrl('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 4));
        $this->assertInstanceOf('Pop\Feed\Reader', Feed\Reader::getByUrl('http://twitter.com/highvoltagenola', 4));
        $this->assertInstanceOf('Pop\Feed\Reader', Feed\Reader::getByUrl('http://vimeo.com/api/v2/video/6271487.php', 1));
        $this->assertInstanceOf('Pop\Feed\Reader', Feed\Reader::getByUrl('http://www.popphp.org/phpfeedtest', 1));
    }

    public function testConstructorException()
    {
        $this->setExpectedException('PHPUnit_Framework_Error_Warning');
        $feed = new Feed\Reader(new Feed\Format\Rss('http://blahblahblah/', 4));
    }

    public function testConstructorBadUrlException()
    {
        $this->setExpectedException('Pop\Feed\Format\Exception');
        $feed = new Feed\Reader(new Feed\Format\Rss('badurl', 4));
    }

    public function testManualAccounts()
    {
        $this->assertInstanceOf('Pop\Feed\Reader', new Feed\Reader(
            new Feed\Format\Rss\Twitter(array('url' => 'http://twitter.com/highvoltagenola'), 4)
        ));
        $this->assertInstanceOf('Pop\Feed\Reader', new Feed\Reader(
            new Feed\Format\Atom\Facebook(array('id' => '49700389248'), 4)
        ));
        $this->assertInstanceOf('Pop\Feed\Reader', new Feed\Reader(
            new Feed\Format\Atom\Facebook(array('name' => 'highvoltagenola'), 4)
        ));
        $this->assertInstanceOf('Pop\Feed\Reader', new Feed\Reader(
            new Feed\Format\Atom\Flickr(array('id' => '96247146@N00'), 4)
        ));
        $this->assertInstanceOf('Pop\Feed\Reader', new Feed\Reader(
            new Feed\Format\Json\Facebook(array('id' => '49700389248'), 4)
        ));
        $this->assertInstanceOf('Pop\Feed\Reader', new Feed\Reader(
            new Feed\Format\Json\Facebook(array('name' => 'highvoltagenola'), 4)
        ));
        $this->assertInstanceOf('Pop\Feed\Reader', new Feed\Reader(
            new Feed\Format\Json\Youtube(array('id' => '35318AF7BEB5DD11'), 4)
        ));
        $this->assertInstanceOf('Pop\Feed\Reader', new Feed\Reader(
            new Feed\Format\Php\Flickr(array('id' => '96247146@N00'), 4)
        ));
    }

    public function testGetByAccountName()
    {
        $feed = Feed\Reader::getByAccountName('facebook', 'highvoltagenola', 4);
        $this->assertGreaterThan(0, $feed->items);
        $this->assertEquals(4, $feed->adapter()->getLimit());
        $feed->adapter()->test = 123;
        $this->assertEquals(123, $feed->adapter()->test);
        $this->assertTrue(isset($feed->adapter()->test));
        unset($feed->adapter()->test);
        $this->assertNull($feed->adapter()->test);
        $feed = Feed\Reader::getByAccountName('twitter', 'highvoltagenola', 4);
        $this->assertGreaterThan(0, $feed->items);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Feed\Reader::getByAccountName('vimeo', 'royraz', 4);
        $this->assertGreaterThan(0, $feed->items);
        $this->assertInstanceOf('Pop\Feed\Format\Rss\Vimeo', $feed->adapter());
        $this->assertInstanceOf('ArrayObject', $feed->feed());
        $this->assertInstanceOf('SimpleXMLElement', $feed->adapter()->obj());
        $feed->adapter()->setFeed(array());
        $this->assertEquals(0, count($feed->adapter()->getFeed()));
    }

    public function testGetByAccountNameException()
    {
        $this->setExpectedException('Pop\Feed\Exception');
        $feed = Feed\Reader::getByAccountName('badservice', '1234567890', 4);
    }

    public function testGetByAccountId()
    {
        $feed = Feed\Reader::getByAccountId('facebook', '49700389248', 4);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Feed\Reader::getByAccountId('flickr', '96247146@N00', 4);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Feed\Reader::getByAccountId('youtube', '35318AF7BEB5DD11', 4);
        $this->assertGreaterThan(0, $feed->items);
        $feed = Feed\Reader::getByAccountId('vimeo', '2136270', 4);
        $this->assertGreaterThan(0, $feed->entries);
    }

    public function testGetByAccountIdException()
    {
        $this->setExpectedException('Pop\Feed\Exception');
        $feed = Feed\Reader::getByAccountId('badservice', '1234567890', 4);
    }

    public function testRenderNoTemplateException()
    {
        $this->setExpectedException('Pop\Feed\Exception');
        $feed = new Feed\Reader(new Feed\Format\Rss\Vimeo('http://vimeo.com/tag:mostviewed/rss', 4));
        $code = $feed->render(true);
    }

    public function testRenderNoContentException()
    {
        $this->setExpectedException('Pop\Feed\Exception');
        $feed = new Feed\Reader(new Feed\Format\Rss\Vimeo('http://vimeo.com/tag:mostviewed/rss', 4));
        unset($feed->adapter()->items);
        $code = $feed->render(true);
    }

    public function testSetAndGetTemplate()
    {
        $feed = Feed\Reader::getByUrl('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $feed->setTemplate('This is a template');
        $this->assertEquals('This is a template', $feed->getTemplate());
        $feed->setTemplate(__DIR__ . '/../tmp/access.txt');
        $this->assertContains('testuser', $feed->getTemplate());
    }

    public function testSetAndGetDateFormat()
    {
        $feed = Feed\Reader::getByUrl('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $feed->setDateFormat('m/d/Y');
        $this->assertEquals('m/d/Y', $feed->getDateFormat());
    }

    public function testBooleanMethods()
    {
        $feed = new Feed\Reader(new Feed\Format\Atom('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4));
        $this->assertTrue($feed->isAtom());
        $this->assertFalse($feed->isRss());
        $this->assertFalse($feed->isJson());
        $this->assertFalse($feed->isPhp());
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

        $feed = new Feed\Reader(new Feed\Format\Rss('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 4));
        $feed->setTemplate($tmpl);
        $this->assertContains('Google', $feed->title);
        $code = $feed->render(true);
        ob_start();
        $feed->render();
        $output = ob_get_clean();

        ob_start();
        echo $feed;
        $echoOutput = ob_get_clean();
        $this->assertContains('<div class="news-div">', $code);
        $this->assertContains('<div class="news-div">', $output);
        $this->assertContains('<div class="news-div">', $echoOutput);
    }

}

