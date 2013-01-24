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
namespace Pop\Feed\Format\Json;

/**
 * Twitter JSON feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Twitter extends \Pop\Feed\Format\Json
{

    /**
     * Feed URLs templates
     * @var array
     */
    protected $urls = array(
        'name' => 'http://api.twitter.com/1/statuses/user_timeline.json?include_rts=true&screen_name=[{name}]',
        'id'   => 'http://api.twitter.com/1/statuses/user_timeline.json?include_rts=true&user_id=[{id}]'
    );

    /**
     * Method to create a Twitter JSON feed object
     *
     * @param  mixed $options
     * @param  int   $limit
     * @return \Pop\Feed\Format\Json\Twitter
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
     * Method to parse Twitter JSON feed object
     *
     * @return void
     */
    public function parse()
    {
        parent::parse();

        $username = $this->obj[0]['user']['screen_name'];
        $this->feed['username'] = $username;
        $this->feed['user_id'] = $this->obj[0]['user']['id'];
        $this->feed['user_description'] = $this->obj[0]['user']['description'];
        $this->feed['user_website'] = $this->obj[0]['user']['url'];
        $this->feed['author'] = $this->obj[0]['user']['name'];

        if (null === $this->feed['title']) {
            $this->feed['title'] = 'Twitter / ' . $username;
        }

        if (null === $this->feed['url']) {
            $this->feed['url'] = 'http://twitter.com/' . $username;
        }

        if (null === $this->feed['date']) {
            $this->feed['date'] = date('D, d M Y H:i:s O');
        }

        if (null === $this->feed['generator']) {
            $this->feed['generator'] = 'Twitter';
        }

        if (null === $this->feed['author']) {
            $this->feed['author'] = $username;
        }

        if (null === $this->feed['description']) {
            $this->feed['description'] = 'Twitter updates from ' . $this->feed['author'] . ' / ' . $username;
        }

        $this->feed['tweets'] = $this->obj[0]['user']['statuses_count'];
        $this->feed['followers'] = $this->obj[0]['user']['followers_count'];
        $this->feed['following'] = $this->obj[0]['user']['friends_count'];
        $this->feed['image_thumb'] = $this->obj[0]['user']['profile_image_url'];

        $items = $this->feed['items'];
        foreach ($items as $key => $item) {
            if (null === $items[$key]['link']) {
                $items[$key]['link'] = 'http://twitter.com/' . $username . '/statuses/' . $this->obj[$key]['id'];
            }
            $items[$key]['title'] = trim(str_replace($username . ':', '', $item['title']));
            $items[$key]['content'] = trim(str_replace($username . ':', '', $item['content']));
        }

        $this->feed['items'] = $items;
    }

}
