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
namespace Pop\Feed\Type\Rss;

/**
 * Facebook RSS feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Facebook extends \Pop\Feed\Type\Rss
{

    /**
     * Method to parse an XML Facebook RSS feed object
     *
     * @return void
     */
    public function parse()
    {
        parent::parse();

        // If graph.facebook.com hasn't been parsed yet
        if (null === $this->feed->likes) {
            if (isset($this->feed->xml()->channel->item[0])) {
                $username = substr($this->feed->xml()->channel->item[0]->link, (strpos($this->feed->xml()->channel->item[0]->link, 'http://www.facebook.com/') + 24));
                $username = substr($username, 0, strpos($username, '/'));
                $graph = json_decode(file_get_contents('http://graph.facebook.com/' . $username), true);
                foreach ($graph as $key => $value) {
                    $this->feed->$key = $value;
                }
            }
        }

        if (strpos($this->feed->url, $this->feed->username) === false) {
            $this->feed->url .= $this->feed->username;
        }
        if (null === $this->feed->author) {
            $this->feed->author = (isset($this->feed->xml()->channel->item[0]->author)) ?
                (string)$this->feed->xml()->channel->item[0]->author : $this->feed->username;
        }
        if (null === $this->feed->date) {
            $this->feed->date = (string)$this->feed->xml()->channel->lastBuildDate;
        }

        $items = $this->feed->items;
        foreach ($items as $key => $item) {
            $items[$key]['title'] = str_replace(array('<![CDATA[', ']]>'), array(null, null), $item['title']);
            $items[$key]['description'] = str_replace(array('<![CDATA[', ']]>'), array(null, null), $item['description']);
        }

        $this->feed->items = $items;
    }

}
