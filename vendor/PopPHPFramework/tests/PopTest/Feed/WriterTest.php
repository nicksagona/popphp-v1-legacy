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
use Pop\Feed\Writer;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class WriterTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $headers = array(
            'title'     => 'Test Feed Title',
            'subtitle'  => 'Test Feed Description',
            'link'      => 'http://www.testfeed.com/',
            'language'  => 'en',
            'updated'   => '2010-01-12 13:01:32',
            'generator' => 'http://www.website.com/',
            'author'    => 'Some Editor'
        );

        $entry = array(
            'title'    => 'Entry Title 1',
            'link'     => 'http://www.testfeed.com/entry1',
            'comments' => 'http://www.testfeed.com/entry1#comments',
            'author'   => 'Entry Author 1',
            'updated'  => '2010-01-13 14:12:24',
            'summary'  => 'Entry Desc 1'
        );

        $this->assertInstanceOf('Pop\Feed\Writer', new Writer($headers, array($entry)));
        $this->assertInstanceOf('Pop\Feed\Writer', Writer::factory($headers, array($entry)));
    }

    public function testAtom()
    {
        $headers = array(
            'title'     => 'Test Feed Title',
            'subtitle'  => 'Test Feed Description',
            'link'      => 'http://www.testfeed.com/',
            'language'  => 'en',
            'updated'   => '2010-01-12 13:01:32',
            'generator' => 'http://www.website.com/',
            'author'    => 'Some Editor'
        );

        $entry = array(
            'title'    => 'Entry Title 1',
            'link'     => 'http://www.testfeed.com/entry1',
            'comments' => 'http://www.testfeed.com/entry1#comments',
            'author'   => 'Entry Author 1',
            'updated'  => '2010-01-13 14:12:24',
            'summary'  => 'Entry Desc 1'
        );
        $feed = new Writer($headers, array($entry), Writer::ATOM);
        $this->assertContains('http://www.w3.org/2005/Atom', $feed->render(true));
    }

    public function testJson()
    {
        $headers = array(
            'title'     => 'Test Feed Title',
            'subtitle'  => 'Test Feed Description',
            'link'      => 'http://www.testfeed.com/',
            'language'  => 'en',
            'updated'   => '2010-01-12 13:01:32',
            'generator' => 'http://www.website.com/',
            'author'    => 'Some Editor'
        );

        $entry = array(
            'title'    => 'Entry Title 1',
            'link'     => 'http://www.testfeed.com/entry1',
            'comments' => 'http://www.testfeed.com/entry1#comments',
            'author'   => 'Entry Author 1',
            'updated'  => '2010-01-13 14:12:24',
            'summary'  => 'Entry Desc 1'
        );
        $feed = new Writer($headers, array($entry), Writer::JSON);
        $this->assertContains('{', $feed->render(true));
    }

    public function testPhp()
    {
        $headers = array(
            'title'     => 'Test Feed Title',
            'subtitle'  => 'Test Feed Description',
            'link'      => 'http://www.testfeed.com/',
            'language'  => 'en',
            'updated'   => '2010-01-12 13:01:32',
            'generator' => 'http://www.website.com/',
            'author'    => 'Some Editor'
        );

        $entry = array(
            'title'    => 'Entry Title 1',
            'link'     => 'http://www.testfeed.com/entry1',
            'comments' => 'http://www.testfeed.com/entry1#comments',
            'author'   => 'Entry Author 1',
            'updated'  => '2010-01-13 14:12:24',
            'summary'  => 'Entry Desc 1'
        );
        $feed = new Writer($headers, array($entry), Writer::PHP);
        $this->assertContains('Test Feed Title', $feed->render(true));
    }

    public function testException()
    {
        $headers = array(
            'title'     => 'Test Feed Title',
            'subtitle'  => 'Test Feed Description',
            'link'      => 'http://www.testfeed.com/',
            'language'  => 'en',
            'updated'   => '2010-01-12 13:01:32',
            'generator' => 'http://www.website.com/',
            'author'    => 'Some Editor'
        );

        $entry = array(
            'title'    => 'Entry Title 1',
            'link'     => 'http://www.testfeed.com/entry1',
            'comments' => 'http://www.testfeed.com/entry1#comments',
            'author'   => 'Entry Author 1',
            'updated'  => '2010-01-13 14:12:24',
            'summary'  => 'Entry Desc 1'
        );
        $this->setExpectedException('Pop\Feed\Exception');
        $feed = new Writer($headers, array($entry), 25);
    }

}

