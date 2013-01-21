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
 * Vimeo feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Vimeo extends \Pop\Feed\Type\Rss
{

    /**
     * Method to parse an XML Vimeo RSS feed object
     *
     * @return void
     */
    public function parse()
    {
        parent::parse();

        if (null === $this->feed->author) {
            $this->feed->author = str_replace('Vimeo / ', null, $this->feed->title);
        }

        $items = $this->feed->items;
        foreach ($items as $key => $item) {
            $id = substr($item['link'], (strrpos($item['link'], '/') + 1));
            $items[$key]['id'] = $id;
            $vimeo = \Pop\Http\Response::parse('http://vimeo.com/api/v2/video/' . $id . '.php');
            if (!$vimeo->isError()) {
                $info = unserialize($vimeo->getBody());
                if (isset($info[0]) && is_array($info[0])) {
                    $items[$key]['views'] = $info[0]['stats_number_of_plays'];
                    $items[$key]['likes'] = $info[0]['stats_number_of_likes'];
                    $items[$key]['duration'] = $info[0]['duration'];
                    $items[$key]['image_thumb']  = $info[0]['thumbnail_small'];
                    $items[$key]['image_medium'] = $info[0]['thumbnail_medium'];
                    $items[$key]['image_large']  = $info[0]['thumbnail_large'];
                    foreach ($info[0] as $k => $v) {
                        if ($v != '') {
                            $items[$key][$k] = $v;
                        }
                    }
                }
            }
        }

        $this->feed->items = $items;
    }

}
