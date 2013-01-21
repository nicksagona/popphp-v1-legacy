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
 * Twitter RSS feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Twitter extends \Pop\Feed\Type\Rss
{

    /**
     * Method to parse an XML Twitter RSS feed object
     *
     * @return void
     */
    public function parse()
    {
        parent::parse();

        $username = substr($this->feed->xml()->channel->link, (strpos($this->feed->xml()->channel->link, 'http://twitter.com/') + 19));
        $this->feed->username = $username;
        $this->feed->handle = '@' . $username;

        if (null === $this->feed->date) {
            $this->feed->date = date('D, d M Y H:i:s O');
        }

        if (null === $this->feed->generator) {
            $this->feed->generator = 'Twitter';
        }

        if (null === $this->feed->author) {
            $this->feed->author = $username;
        }

        $items = $this->feed->items;
        foreach ($items as $key => $item) {
            $items[$key]['title'] = trim(str_replace($username . ':', '', $item['title']));
            $items[$key]['description'] = trim(str_replace($username . ':', '', $item['description']));
        }

        $this->feed->items = $items;
    }

}
