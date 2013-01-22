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
 * Atom feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Atom
{

    /**
     * Feed reader object
     * @var \Pop\Feed\Reader
     */
    protected $feed = null;

    /**
     * Method to parse an XML Atom feed object
     *
     * @param  \Pop\Feed\Reader    $feed
     * @return \Pop\Feed\Type\Atom
     */
    public function __construct(\Pop\Feed\Reader $feed)
    {
        $this->feed = $feed;
        $this->feed->title       = (isset($this->feed->xml()->title)) ? (string)$this->feed->xml()->title : null;
        $this->feed->url         = (isset($this->feed->xml()->link->attributes()->href)) ? (string)$this->feed->xml()->link->attributes()->href : null;
        $this->feed->description = (isset($this->feed->xml()->subtitle)) ? (string)$this->feed->xml()->subtitle : null;
        $this->feed->date        = (isset($this->feed->xml()->updated)) ? (string)$this->feed->xml()->updated : null;
        $this->feed->generator   = (isset($this->feed->xml()->generator)) ? (string)$this->feed->xml()->generator : null;
        $this->feed->author      = (isset($this->feed->xml()->author->name)) ? (string)$this->feed->xml()->author->name : null;
    }

    /**
     * Method to parse an XML Atom feed object
     *
     * @return void
     */
    public function parse()
    {
        $items = array();
        $count = count($this->feed->xml()->entry);
        $limit = (($this->feed->getLimit() > 0) && ($this->feed->getLimit() <= $count)) ? $this->feed->getLimit() : $count;

        for ($i = 0; $i < $limit; $i++) {
            $description = (isset($this->feed->xml()->entry[$i]->content) ?
                (string)$this->feed->xml()->entry[$i]->content :
                (string)$this->feed->xml()->entry[$i]->summary);

            $items[] = array(
                'title'       => html_entity_decode((string)$this->feed->xml()->entry[$i]->title, ENT_QUOTES, 'UTF-8'),
                'description' => html_entity_decode($description, ENT_QUOTES, 'UTF-8'),
                'link'        => (string)$this->feed->xml()->entry[$i]->link->attributes()->href,
                'published'   => (string)$this->feed->xml()->entry[$i]->published,
                'time'        => \Pop\Feed\Reader::calculateTime((string)$this->feed->xml()->entry[$i]->published)
            );
        }

        $this->feed->items = $items;
    }

}
