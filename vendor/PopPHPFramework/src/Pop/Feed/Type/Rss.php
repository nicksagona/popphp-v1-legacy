<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Feed\Type;

/**
 * Rss feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Rss
{

    /**
     * Feed reader object
     * @var \Pop\Feed\Reader
     */
    protected $feed = null;

    /**
     * Method to parse an XML RSS feed object
     *
     * @param  \Pop\Feed\Reader   $feed
     * @return \Pop\Feed\Type\Rss
     */
    public function __construct(\Pop\Feed\Reader $feed)
    {
        $this->feed = $feed;

        if (isset($this->feed->xml()->channel->lastBuildDate)) {
            $date = (string)$this->feed->xml()->channel->lastBuildDate;
        } else if (isset($this->feed->xml()->channel->pubDate)) {
            $date = (string)$this->feed->xml()->channel->pubDate;
        } else {
            $date = null;
        }

        $this->feed->title       = (isset($this->feed->xml()->channel->title)) ? (string)$this->feed->xml()->channel->title : null;
        $this->feed->url         = (isset($this->feed->xml()->channel->link)) ? (string)(string)$this->feed->xml()->channel->link : null;
        $this->feed->description = (isset($this->feed->xml()->channel->description)) ? (string)$this->feed->xml()->channel->description : null;
        $this->feed->date        = $date;
        $this->feed->generator   = (isset($this->feed->xml()->channel->generator)) ? (string)$this->feed->xml()->channel->generator : null;
        $this->feed->author      = (isset($this->feed->xml()->channel->managingEditor)) ? (string)$this->feed->xml()->channel->managingEditor : null;
    }

    /**
     * Method to parse an XML RSS feed object
     *
     * @return void
     */
    public function parse()
    {
        $items = array();
        $count = count($this->feed->xml()->channel->item);
        $limit = (($this->feed->getLimit() > 0) && ($this->feed->getLimit() <= $count)) ? $this->feed->getLimit() : $count;

        for ($i = 0; $i < $limit; $i++) {
            $items[] = array(
                'title'       => html_entity_decode((string)$this->feed->xml()->channel->item[$i]->title, ENT_QUOTES, 'UTF-8'),
                'description' => html_entity_decode((string)$this->feed->xml()->channel->item[$i]->description, ENT_QUOTES, 'UTF-8'),
                'link'        => (string)$this->feed->xml()->channel->item[$i]->link,
                'published'   => (string)$this->feed->xml()->channel->item[$i]->pubDate,
                'time'        => \Pop\Feed\Reader::calculateTime((string)$this->feed->xml()->channel->item[$i]->pubDate)
            );
        }

        $this->feed->items = $items;
    }

}
