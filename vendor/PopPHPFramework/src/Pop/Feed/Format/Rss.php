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
namespace Pop\Feed\Format;

/**
 * RSS feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Rss extends AbstractFormat
{

    /**
     * Method to create an RSS feed object
     *
     * @param  mixed $options
     * @param  int   $limit
     * @throws Exception
     * @return \Pop\Feed\Format\Rss
     */
    public function __construct($options, $limit = 0)
    {
        parent::__construct($options, $limit);

        if (!($this->obj = simplexml_load_string($this->source, 'SimpleXMLElement', LIBXML_NOWARNING))) {
            throw new Exception('That feed URL cannot be read at this time. Please try again later.');
        }

        if (isset($this->obj->channel->lastBuildDate)) {
            $date = (string)$this->obj->channel->lastBuildDate;
        } else if (isset($this->obj->channel->pubDate)) {
            $date = (string)$this->obj->channel->pubDate;
        } else {
            $date = null;
        }

        $this->feed['title']       = (isset($this->obj->channel->title)) ? (string)$this->obj->channel->title : null;
        $this->feed['url']         = (isset($this->obj->channel->link)) ? (string)(string)$this->obj->channel->link : null;
        $this->feed['description'] = (isset($this->obj->channel->description)) ? (string)$this->obj->channel->description : null;
        $this->feed['date']        = $date;
        $this->feed['generator']   = (isset($this->obj->channel->generator)) ? (string)$this->obj->channel->generator : null;
        $this->feed['author']      = (isset($this->obj->channel->managingEditor)) ? (string)$this->obj->channel->managingEditor : null;
    }

    /**
     * Method to parse an RSS feed object
     *
     * @return void
     */
    public function parse()
    {
        $items = array();
        $count = count($this->obj->channel->item);
        $limit = (($this->limit > 0) && ($this->limit <= $count)) ? $this->limit : $count;

        for ($i = 0; $i < $limit; $i++) {
            $items[] = array(
                'title'       => html_entity_decode((string)$this->obj->channel->item[$i]->title, ENT_QUOTES, 'UTF-8'),
                'description' => html_entity_decode((string)$this->obj->channel->item[$i]->description, ENT_QUOTES, 'UTF-8'),
                'link'        => (string)$this->obj->channel->item[$i]->link,
                'published'   => (string)$this->obj->channel->item[$i]->pubDate,
                'time'        => self::calculateTime((string)$this->obj->channel->item[$i]->pubDate)
            );
        }

        $this->feed['items'] = $items;
    }

}
