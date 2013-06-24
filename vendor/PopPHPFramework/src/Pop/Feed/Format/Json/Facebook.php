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
 * Facebook JSON feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.3.0
 */
class Facebook extends \Pop\Feed\Format\Json
{

    /**
     * Feed URLs templates
     * @var array
     */
    protected $urls = array(
        'name' => 'http://graph.facebook.com/[{name}]',
        'id'   => 'http://www.facebook.com/feeds/page.php?id=[{id}]&format=json'
    );

    /**
     * Method to create a Facebook JSON feed object
     *
     * @param  mixed  $options
     * @param  int    $limit
     * @return \Pop\Feed\Format\Json\Facebook
     */
    public function __construct($options, $limit = 0)
    {
        // Attempt to get the correct URL to parse
        if (is_array($options)) {
            if (isset($options['name'])) {
                $jsonUrl = str_replace('[{name}]', $options['name'], $this->urls['name']);
                $json = json_decode(file_get_contents($jsonUrl), true);
                $this->url = str_replace('[{id}]', $json['id'], $this->urls['id']);
                foreach ($json as $key => $value) {
                    $this->feed[$key] = $value;
                }
            } else if (isset($options['id'])) {
                $this->url = str_replace('[{id}]', $options['id'], $this->urls['id']);
            }
        }

        parent::__construct($options, $limit);
    }

    /**
     * Method to parse Facebook JSON feed object
     *
     * @return void
     */
    public function parse()
    {
        parent::parse();

        // If graph.facebook.com hasn't been parsed yet.
        if (!isset($this->feed['username'])) {
            $objItems = $this->obj['entries'];
            $username = null;
            foreach ($objItems as $itm) {
                if (strpos($itm['alternate'], '/posts/') !== false) {
                    $username = substr($itm['alternate'], (strpos($itm['alternate'], 'http://www.facebook.com/') + 24));
                    $username = substr($username, 0, strpos($username, '/'));
                }
            }
            if (null !== $username) {
                $json = json_decode(file_get_contents('http://graph.facebook.com/' . $username), true);
                foreach ($json as $key => $value) {
                    $this->feed[$key] = $value;
                }
            } else if (isset($this->options['name'])) {
                $this->feed['username'] = $this->options['name'];
            }
        }

        if (strpos($this->feed['url'], $this->feed['username']) === false) {
            $this->feed['url'] .= $this->feed['username'];
        }
        if (null === $this->feed['author']) {
            $this->feed['author'] = (isset($this->obj['entries'][0]['author']['name'])) ?
                (string)$this->obj['entries'][0]['author']['name'] : $this->feed['username'];
        }
        if (null === $this->feed['date']) {
            $this->feed['date'] = (string)$this->obj['updated'];
        }
        if (null === $this->feed['generator']) {
            $this->feed['generator'] = 'Facebook Syndication';
        }
    }

}
