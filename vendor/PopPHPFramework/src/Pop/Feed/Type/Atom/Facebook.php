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
namespace Pop\Feed\Type\Atom;

/**
 * Facebook Atom feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Facebook extends \Pop\Feed\Type\Atom
{

    /**
     * Feed URLs
     * @var array
     */
    protected static $urls = array(
        'name' => 'http://graph.facebook.com/[{name}]',
        'id'   => 'http://www.facebook.com/feeds/page.php?id=[{id}]&format=atom10'
    );

    /**
     * JSON result from the graph URL
     * @var array
     */
    protected static $json = array();

    /**
     * Method to get Facebook Atom URL
     *
     * @param  string $key
     * @param  string $value
     * @return string
     */
    public static function url($key, $value)
    {
        $url = null;

        if (isset(self::$urls[$key])) {
            $url = str_replace('[{' . $key . '}]', $value, self::$urls[$key]);
            if (stripos($url, 'graph.facebook.com') !== false) {
                self::$json = json_decode(file_get_contents($url), true);
                $url = 'http://www.facebook.com/feeds/page.php?id=' . self::$json['id'] . '&format=atom10';
            }
        }

        return $url;
    }

    /**
     * Method parse Facebook Atom feed
     *
     * @return void
     */
    public function parse()
    {
        parent::parse();

        // If graph.facebook.com hasn't been stored in the feed object yet
        if (null === $this->feed->likes) {
            if (count(self::$json) == 0) {
                if (isset($this->feed->xml()->entry[0])) {
                    $username = substr($this->feed->xml()->entry[0]->link->attributes()->href, (strpos($this->feed->xml()->entry[0]->link->attributes()->href, 'http://www.facebook.com/') + 24));
                    $username = substr($username, 0, strpos($username, '/'));
                    self::$json = json_decode(file_get_contents('http://graph.facebook.com/' . $username), true);
                }
            }
            foreach (self::$json as $key => $value) {
                $this->feed->$key = $value;
            }
        }

        if (strpos($this->feed->url, $this->feed->username) === false) {
            $this->feed->url .= $this->feed->username;
        }
        if (null === $this->feed->author) {
            $this->feed->author = (isset($this->feed->xml()->entry[0]->author->name)) ?
                (string)$this->feed->xml()->entry[0]->author->name : $this->feed->username;
        }
        if (null === $this->feed->date) {
            $this->feed->date = (string)$this->feed->xml()->updated;
        }

        $items = $this->feed->items;
        foreach ($items as $key => $item) {
            $items[$key]['title'] = str_replace(array('<![CDATA[', ']]>'), array(null, null), $item['title']);
            $items[$key]['description'] = str_replace(array('<![CDATA[', ']]>'), array(null, null), $item['description']);
        }

        $this->feed->items = $items;
    }

}
