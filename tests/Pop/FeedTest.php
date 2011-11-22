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
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once dirname(__FILE__) . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_FeedTest extends PHPUnit_Framework_TestCase
{

    public function testFeedReaderConstructor()
    {
        $f = new Pop_Feed_Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $class = 'Pop_Feed_Reader';
        $this->assertTrue($f instanceof $class);
    }

    public function testFeedWriterConstructor()
    {
        $fh = array('feed_title' => 'Test Feed Title', 'feed_link' => 'http://www.testfeed.com/');
        $item1 = array('item_title' => 'Item Title 1', 'item_link' => 'http://www.testfeed.com/item1');
        $item2 = array('item_title' => 'Item Title 2', 'item_link' => 'http://www.testfeed.com/item2');

        $f = new Pop_Feed_Writer($fh, array($item1, $item2));
        $class = 'Pop_Feed_Writer';
        $this->assertTrue($f instanceof $class);
    }

    public function testFeedReaderRender()
    {
        $f = new Pop_Feed_Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);
        $f->setItemTemplate("<div>[{link}] [{title}] ([{timeElapsed}])<br />\n");
        $this->assertTrue(is_string($f->render('m/d/Y h:i a', true)));
    }

    public function testFeedWriterRender()
    {
        $fh = array('feed_title' => 'Test Feed Title', 'feed_link' => 'http://www.testfeed.com/');
        $item1 = array('item_title' => 'Item Title 1', 'item_link' => 'http://www.testfeed.com/item1');
        $item2 = array('item_title' => 'Item Title 2', 'item_link' => 'http://www.testfeed.com/item2');

        $f = new Pop_Feed_Writer($fh, array($item1, $item2));
        $this->assertTrue(is_string($f->render(true)));
    }

}

?>