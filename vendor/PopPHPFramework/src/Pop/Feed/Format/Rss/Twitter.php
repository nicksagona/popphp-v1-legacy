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
namespace Pop\Feed\Format\Rss;

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
class Twitter extends \Pop\Feed\Format\Rss
{

    /**
     * Feed URLs templates
     * @var array
     */
    protected $urls = array(
        'name' => 'http://api.twitter.com/1/statuses/user_timeline.rss?include_rts=true&screen_name=[{name}]',
        'id'   => 'http://api.twitter.com/1/statuses/user_timeline.rss?include_rts=true&user_id=[{id}]'
    );

    /**
     * Method to create a Twitter RSS feed object
     *
     * @param  mixed $options
     * @param  int   $limit
     * @return \Pop\Feed\Format\Rss\Twitter
     */
    public function __construct($options, $limit = 0)
    {
        // Attempt to get the correct URL to parse
        if (is_array($options)) {
            if (isset($options['name'])) {
                $this->url = str_replace('[{name}]', $options['name'], $this->urls['name']);
                if ((int)$limit > 0) {
                    $this->url .= '&count=' . (int)$limit;
                }
            } else if (isset($options['id'])) {
                $this->url = str_replace('[{id}]', $options['id'], $this->urls['id']);
                if ((int)$limit > 0) {
                    $this->url .= '&count=' . (int)$limit;
                }
            }
        }

        parent::__construct($options, $limit);
    }

    /**
     * Method to parse a Twitter RSS feed object
     *
     * @return void
     */
    public function parse()
    {
        parent::parse();

        $username = substr($this->obj->channel->link, (strpos($this->obj->channel->link, 'http://twitter.com/') + 19));
        $this->feed['username'] = $username;

        if (null === $this->feed['date']) {
            $this->feed['date'] = date('D, d M Y H:i:s O');
        }

        if (null === $this->feed['generator']) {
            $this->feed['generator'] = 'Twitter';
        }

        if (null === $this->feed['author']) {
            $author = str_replace('Twitter updates from ', null, $this->feed['description']);
            $author = trim(substr($author, 0, strpos($author, '/')));
            $this->feed['author'] = $author;
        }

        // Parse the JSON URL to get the additional information
        $jsonUrl = 'http://api.twitter.com/1/statuses/user_timeline.json?include_rts=true&count=1&screen_name=' . $username;
        $json = json_decode(file_get_contents($jsonUrl), true);
        if (isset($json[0])) {
            $this->feed['user_id'] = $json[0]['user']['id'];
            $this->feed['user_description'] = $json[0]['user']['description'];
            $this->feed['user_website'] = $json[0]['user']['url'];
            $this->feed['tweet_count'] = $json[0]['user']['statuses_count'];
            $this->feed['followers'] = $json[0]['user']['followers_count'];
            $this->feed['following'] = $json[0]['user']['friends_count'];
            $this->feed['image_thumb'] = $json[0]['user']['profile_image_url'];
        }

        $items = $this->feed['items'];
        foreach ($items as $key => $item) {
            $items[$key]['title'] = trim(str_replace($username . ':', '', $item['title']));
            $items[$key]['content'] = trim(str_replace($username . ':', '', $item['content']));
        }

        $this->feed['items'] = $items;
    }

}
