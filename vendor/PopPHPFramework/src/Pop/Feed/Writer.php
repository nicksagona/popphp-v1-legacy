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

/**
 * Pop_Feed_Writer
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Feed_Writer extends Pop_Dom
{

    /**
     * Feed headers
     * @var array
     */
    protected $_headers = array();

    /**
     * Feed items
     * @var array
     */
    protected $_items = array();

    /**
     * Feed type
     * @var string
     */
    protected $_feed_type = null;

    /**
     * Feed date format
     * @var string
     */
    protected $_date = null;


    /**
     * Constructor
     *
     * Instantiate the feed object.
     *
     * @param  array  $hdrs
     * @param  array  $itms
     * @param  string $type
     * @param  string $dt
     * @return void
     */
    public function __construct($hdrs, $itms, $type = 'RSS', $dt = 'D, j M Y H:i:s O')
    {
        $this->_headers = $hdrs;
        $this->_items = $itms;
        $this->_feed_type = $type;
        $this->_date = $dt;

        parent::__construct($this->_feed_type, 'utf-8');
        $this->_init();
    }

    /**
     * Initialize the feed.
     *
     * @throws Exception
     * @return void
     */
    protected function _init()
    {
        if ($this->_feed_type == 'RSS') {
            // Set up the RSS child node.
            $rss = new Pop_Dom_Child('rss');
            $rss->setAttributes('version', '2.0');
            $rss->setAttributes('xmlns:content', 'http://purl.org/rss/1.0/modules/content/');
            $rss->setAttributes('xmlns:wfw', 'http://wellformedweb.org/CommentAPI/');

            // Set up the Channel child node and the header children.
            $channel = new Pop_Dom_Child('channel');
            foreach ($this->_headers as $key => $value) {
                $channel->addChild(new Pop_Dom_Child($key, $value));
            }

            // Set up the Item child nodes and add them to the Channel child node.
            foreach ($this->_items as $itm) {
                $item = new Pop_Dom_Child('item');
                foreach ($itm as $key => $value) {
                    $item->addChild(new Pop_Dom_Child($key, $value));
                }
                $channel->addChild($item);
            }

            // Add the Channel child node to the RSS child node, add the RSS child node to the DOM.
            $rss->addChild($channel);
            $this->addChild($rss);
        } else if ($this->_feed_type == 'ATOM') {
            // Set up the Feed child node.
            $feed = new Pop_Dom_Child('feed');
            $feed->setAttributes('xmlns', 'http://www.w3.org/2005/Atom');

            if (isset($this->_headers['language'])) {
                $feed->setAttributes('xml:lang', $this->_headers['language']);
            }

            // Set up the header children.
            foreach ($this->_headers as $key => $value) {
                if ($key == 'author') {
                    $auth = new Pop_Dom_Child($key);
                    $auth->addChild(new Pop_Dom_Child('name', $value));
                    $feed->addChild($auth);
                } else if ($key == 'link') {
                    $link = new Pop_Dom_Child($key);
                    $link->setAttributes('href', $value);
                    $feed->addChild($link);
                } else if ($key != 'language') {
                    $val = (stripos($key, 'date') !== false) ? date($this->_date, strtotime($value)) : $value;
                    $feed->addChild(new Pop_Dom_Child($key, $val));
                }
            }

            // Set up the Entry child nodes and add them to the Feed child node.
            foreach ($this->_items as $itm) {
                $item = new Pop_Dom_Child('entry');
                foreach ($itm as $key => $value) {
                    if ($key == 'link') {
                        $link = new Pop_Dom_Child($key);
                        $link->setAttributes('href', $value);
                        $item->addChild($link);
                    } else {
                        $val = (stripos($key, 'date') !== false) ? date($this->_date, strtotime($value)) : $value;
                        $item->addChild(new Pop_Dom_Child($key, $val));
                    }
                }
                $feed->addChild($item);
            }

            // Add the Feed child node to the DOM.
            $this->addChild($feed);
        } else {
            throw new Exception(Pop_Locale::load()->__('Error: The feed type must be only RSS or ATOM.'));
        }
    }

}
