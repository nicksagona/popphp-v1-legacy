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
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Feed;

use Pop\Dom\Dom,
    Pop\Dom\Child;

/**
 * This is the Writer class for the Feed component.
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.0
 */
class Writer extends Dom
{

    /**
     * Feed headers
     * @var array
     */
    protected $headers = array();

    /**
     * Feed items
     * @var array
     */
    protected $items = array();

    /**
     * Feed type
     * @var string
     */
    protected $feedType = null;

    /**
     * Feed date format
     * @var string
     */
    protected $date = null;

    /**
     * Constructor
     *
     * Instantiate the feed object.
     *
     * @param  array  $hdrs
     * @param  array  $itms
     * @param  mixed  $type
     * @param  string $dt
     * @return \Pop\Feed\Writer
     */
    public function __construct($hdrs, $itms, $type = Dom::RSS, $dt = 'D, j M Y H:i:s O')
    {
        $this->headers = $hdrs;
        $this->items = $itms;
        $this->feedType = $type;
        $this->date = $dt;

        parent::__construct($this->feedType, 'utf-8');
        $this->init();
    }

    /**
     * Initialize the feed.
     *
     * @throws Exception
     * @return void
     */
    protected function init()
    {
        if ($this->feedType == Dom::RSS) {
            // Set up the RSS child node.
            $rss = new Child('rss');
            $rss->setAttributes('version', '2.0');
            $rss->setAttributes('xmlns:content', 'http://purl.org/rss/1.0/modules/content/');
            $rss->setAttributes('xmlns:wfw', 'http://wellformedweb.org/CommentAPI/');

            // Set up the Channel child node and the header children.
            $channel = new Child('channel');
            foreach ($this->headers as $key => $value) {
                $channel->addChild(new Child($key, $value));
            }

            // Set up the Item child nodes and add them to the Channel child node.
            foreach ($this->items as $itm) {
                $item = new Child('item');
                foreach ($itm as $key => $value) {
                    $item->addChild(new Child($key, $value));
                }
                $channel->addChild($item);
            }

            // Add the Channel child node to the RSS child node, add the RSS child node to the DOM.
            $rss->addChild($channel);
            $this->addChild($rss);
        } else if ($this->feedType == Dom::ATOM) {
            // Set up the Feed child node.
            $feed = new Child('feed');
            $feed->setAttributes('xmlns', 'http://www.w3.org/2005/Atom');

            if (isset($this->headers['language'])) {
                $feed->setAttributes('xml:lang', $this->headers['language']);
            }

            // Set up the header children.
            foreach ($this->headers as $key => $value) {
                if ($key == 'author') {
                    $auth = new Child($key);
                    $auth->addChild(new Child('name', $value));
                    $feed->addChild($auth);
                } else if ($key == 'link') {
                    $link = new Child($key);
                    $link->setAttributes('href', $value);
                    $feed->addChild($link);
                } else if ($key != 'language') {
                    $val = (stripos($key, 'date') !== false) ? date($this->date, strtotime($value)) : $value;
                    $feed->addChild(new Child($key, $val));
                }
            }

            // Set up the Entry child nodes and add them to the Feed child node.
            foreach ($this->items as $itm) {
                $item = new Child('entry');
                foreach ($itm as $key => $value) {
                    if ($key == 'link') {
                        $link = new Child($key);
                        $link->setAttributes('href', $value);
                        $item->addChild($link);
                    } else {
                        $val = (stripos($key, 'date') !== false) ? date($this->date, strtotime($value)) : $value;
                        $item->addChild(new Child($key, $val));
                    }
                }
                $feed->addChild($item);
            }

            // Add the Feed child node to the DOM.
            $this->addChild($feed);
        } else {
            throw new Exception('Error: The feed type must be only RSS or ATOM.');
        }
    }

}
