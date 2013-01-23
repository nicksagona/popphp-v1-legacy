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
 * Atom feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Atom extends AbstractFormat
{

    /**
     * Method to create an Atom feed object
     *
     * @param  mixed $options
     * @param  int   $limit
     * @throws Exception
     * @return \Pop\Feed\Format\Atom
     */
    public function __construct($options, $limit = 0)
    {
        parent::__construct($options, $limit);

        if (!($this->obj = simplexml_load_string($this->source, 'SimpleXMLElement', LIBXML_NOWARNING))) {
            throw new Exception('That feed URL cannot be read at this time. Please try again later.');
        }

        $this->feed['title']       = (isset($this->obj->title)) ? (string)$this->obj->title : null;
        $this->feed['url']         = (isset($this->obj->link->attributes()->href)) ? (string)$this->obj->link->attributes()->href : null;
        $this->feed['description'] = (isset($this->obj->subtitle)) ? (string)$this->obj->subtitle : null;
        $this->feed['date']        = (isset($this->obj->updated)) ? (string)$this->obj->updated : null;
        $this->feed['generator']   = (isset($this->obj->generator)) ? (string)$this->obj->generator : null;
        $this->feed['author']      = (isset($this->obj->author->name)) ? (string)$this->obj->author->name : null;
    }

    /**
     * Method to parse an Atom feed object
     *
     * @return void
     */
    public function parse()
    {
        $items = array();
        $count = count($this->obj->entry);
        $limit = (($this->limit > 0) && ($this->limit <= $count)) ? $this->limit : $count;

        for ($i = 0; $i < $limit; $i++) {
            $description = (isset($this->obj->entry[$i]->content) ?
                (string)$this->obj->entry[$i]->content :
                (string)$this->obj->entry[$i]->summary);

            $date = (isset($this->obj->entry[$i]->published)) ?
                (string)$this->obj->entry[$i]->published :
                (string)$this->obj->entry[$i]->updated;

            $items[] = array(
                'title'       => html_entity_decode((string)$this->obj->entry[$i]->title, ENT_QUOTES, 'UTF-8'),
                'description' => html_entity_decode($description, ENT_QUOTES, 'UTF-8'),
                'link'        => (string)$this->obj->entry[$i]->link->attributes()->href,
                'published'   => $date,
                'time'        => self::calculateTime($date)
            );
        }

        $this->feed['items'] = $items;
    }

}
