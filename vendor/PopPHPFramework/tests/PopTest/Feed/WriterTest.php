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

namespace PopTest\Feed;

use Pop\Loader\Autoloader,
    Pop\Dom\Dom,
    Pop\Feed\Writer;

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
        $feed = new Writer($headers, array($entry), Dom::ATOM);
        $this->assertContains('http://www.w3.org/2005/Atom', $feed->render(true));
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

