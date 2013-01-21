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
namespace Pop\Feed;

use Pop\Locale\Locale;

/**
 * Feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Reader
{

    /**
     * Constant for ATOM feed-type
     * @var boolean
     */
    const ATOM = true;

    /**
     * Feed URL
     * @var string
     */
    protected $feedUrl = null;

    /**
     * Feed prefix
     * @var string
     */
    protected $feedPrefix = 'Pop\\Feed\\Type\\';

    /**
     * Feed type
     * @var string
     */
    protected $feedType = null;

    /**
     * XML Object
     * @var \SimpleXMLElement
     */
    protected $xml = null;

    /**
     * Feed limit
     * @var int
     */
    protected $limit = 0;

    /**
     * Feed content
     * @var array
     */
    protected $feed = array();

    /**
     * Feed item template
     * @var string
     */
    protected $template = null;

    /**
     * Feed date format
     * @var string
     */
    protected $dateFormat = 'm/d/Y g:ia';

    /**
     * Constructor
     *
     * Instantiate the feed object.
     *
     * @param  string  $url
     * @param  int     $limit
     * @param  boolean $atom
     * @param  string  $prefix
     * @throws Exception
     * @return \Pop\Feed\Reader
     */
    public function __construct($url, $limit = 0, $atom = false, $prefix = 'Pop\\Feed\\Type\\')
    {
        if (stripos($url, 'graph.facebook.com') !== false) {
            $this->feed = json_decode(file_get_contents($url), true);
            $this->feedUrl = 'http://www.facebook.com/feeds/page.php?id=' . $this->feed['id'] . '&format=' . (($atom) ? 'atom10' : 'rss20');
        } else {
            $this->feedUrl = $url;
        }

        $this->limit = $limit;

        // Create the SimpleXMLElement object and parse it.
        try {
            $ua = (isset($_SERVER['HTTP_USER_AGENT'])) ?
                $_SERVER['HTTP_USER_AGENT'] :
                'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:16.0) Gecko/20100101 Firefox/16.0';

            $opts = array(
                'http'=>array(
                    'method'     => 'GET',
                    'user_agent' => $ua
                )
            );

            $xmlSource = file_get_contents($this->feedUrl, false, stream_context_create($opts));
            if (($this->xml = simplexml_load_string($xmlSource, 'SimpleXMLElement', LIBXML_NOWARNING)) !== false) {
                $this->feedType = (isset($this->xml->entry)) ? 'atom' : 'rss';
                $this->limit = $limit;
                $this->parseFeed();
            } else {
                throw new Exception('That feed URL cannot be read at this time. Please try again later.');
            }
        // Else, throw an exception if there are any failures.
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Method to parse a feed by url
     *
     * @param  string $url
     * @param  int    $limit
     * @param  boolean $atom
     * @param  string  $prefix
     * @return void
     */
    public static function parseByUrl($url, $limit = 0, $atom = false, $prefix = 'Pop\\Feed\\Type\\')
    {
        return new self($url, $limit, $atom, $prefix);
    }

    /**
     * Method to parse a feed by name via the account:
     *     'facebook'
     *     'twitter'
     *     'youtube'
     *     'vimeo'
     *
     * @param  string $name
     * @param  string $account
     * @param  int    $limit
     * @param  boolean $atom
     * @param  string  $prefix
     * @throws Exception
     * @return \Pop\Feed\Reader
     */
    public static function parseByName($name, $account, $limit = 0, $atom = false, $prefix = 'Pop\\Feed\\Type\\')
    {
        $accounts = array('facebook', 'twitter', 'youtube', 'vimeo');
        $account = strtolower($account);
        $url = null;

        if (!in_array($account, $accounts)) {
            throw new Exception('Error: Only Facebook, Twitter, YouTube and Vimeo account types support access by name.');
        }

        switch ($account) {
            case 'facebook':
                $url = 'http://graph.facebook.com/' . $name;
                break;

            case 'twitter':
                $url = 'http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=' . $name;
                break;

            case 'youtube':
                $url = 'http://gdata.youtube.com/feeds/base/users/' . $name . '/uploads?v=2' . (($atom) ? null : '&alt=rss');
                break;

            case 'vimeo':
                $url = 'http://vimeo.com/channels/' . $name . '/videos/rss';
                break;
        }

        return new self($url, $limit, $atom, $prefix);
    }

    /**
     * Method to parse a feed by id via the account:
     *     'facebook'
     *     'youtube'
     *     'vimeo'
     *
     * @param  string $id
     * @param  string $account
     * @param  int    $limit
     * @param  boolean $atom
     * @param  string  $prefix
     * @throws Exception
     * @return \Pop\Feed\Reader
     */
    public static function parseById($id, $account, $limit = 0, $atom = false, $prefix = 'Pop\\Feed\\Type\\')
    {
        $accounts = array('facebook', 'youtube', 'vimeo');
        $account = strtolower($account);
        $url = null;

        if (!in_array($account, $accounts)) {
            throw new Exception('Error: Only Facebook and YouTube account types support access by ID.');
        }

        switch ($account) {
            case 'facebook':
                $url = 'http://www.facebook.com/feeds/page.php?id=' . $id . '&format=' . (($atom) ? 'atom10' : 'rss20');
                break;

            case 'youtube':
                $url = 'http://gdata.youtube.com/feeds/api/playlists/' . $id . '?v=2' . (($atom) ? null : '&alt=rss');
                break;

            case 'vimeo':
                $url = 'http://vimeo.com/album/' . $id . '/rss';
                break;
        }

        return new self($url, $limit, $atom, $prefix);
    }

    /**
     * Method to calculate the elapsed time between the date passed and now.
     *
     * @param  string $time
     * @return void
     */
    public static function calculateTime($time)
    {
        // Calculate the difference.
        $timeDiff = time() - strtotime($time);
        $timePhrase = null;

        // If less than an hour.
        if ($timeDiff < 3600) {
            $elapsedTime = round($timeDiff / 60);
            if ($elapsedTime <= 0) {
                $timePhrase = Locale::factory()->__('A few seconds ago');
            } else if ($elapsedTime == 1) {
                $timePhrase = Locale::factory()->__('1 minute ago');
            } else {
                $timePhrase = Locale::factory()->__('%1 minutes ago', $elapsedTime);
            }
        // If less than a day.
        } else if (($timeDiff >= 3600) && ($timeDiff < 86400)) {
            $elapsedTime = round(($timeDiff / 60) / 60);
            $timePhrase = ($elapsedTime == 1) ? Locale::factory()->__('1 hour ago') : Locale::factory()->__('%1 hours ago', $elapsedTime);
        // If less than a month.
        } else if (($timeDiff >= 86400) && ($timeDiff < 2592000)) {
            $elapsedTime = round(((($timeDiff / 60) / 60) / 24));
            $timePhrase = ($elapsedTime == 1) ? Locale::factory()->__('1 day ago') : Locale::factory()->__('%1 days ago', $elapsedTime);
        // If more than a month, less than 2 years
        } else if (($timeDiff >= 2592000) && ($timeDiff < 63072000)) {
            $elapsedTime = round((((($timeDiff / 60) / 60) / 24) / 30));
            $timePhrase = ($elapsedTime == 1) ? Locale::factory()->__('1 month ago') : Locale::factory()->__('%1 months ago', $elapsedTime);
        // If more than 2 years ago
        } else {
            $elapsedTime = round((((($timeDiff / 60) / 60) / 24 / 30) / 12));
            $timePhrase = Locale::factory()->__('%1 years ago', $elapsedTime);
        }

        // Return the calculated elapsed time.
        return $timePhrase;
    }

    /**
     * Method to set the feed
     *
     * @param  array $feed
     * @return \Pop\Feed\Reader
     */
    public function setFeed(array $feed = array())
    {
        $this->feed = $feed;
        return $this;
    }

    /**
     * Method to set item template
     *
     * @param  string $tmpl
     * @return \Pop\Feed\Reader
     */
    public function setTemplate($tmpl)
    {
        if (file_exists($tmpl)) {
            $this->template = file_get_contents($tmpl);
        } else {
            $this->template = $tmpl;
        }
        return $this;
    }

    /**
     * Method to set date format
     *
     * @param  string $date
     * @return \Pop\Feed\Reader
     */
    public function setDateFormat($date)
    {
        $this->dateFormat = $date;
        return $this;
    }

    /**
     * Method to set prefix
     *
     * @param  string $prefix
     * @return \Pop\Feed\Reader
     */
    public function setPrefix($prefix = 'Pop\\Feed\\Type\\')
    {
        $this->feedPrefix = $prefix;
        return $this;
    }

    /**
     * Method to set limit
     *
     * @param  int $limit
     * @return \Pop\Feed\Reader
     */
    public function setLimit($limit = 0)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Method to get the XML object
     *
     * @return \SimpleXMLElement
     */
    public function xml()
    {
        return $this->xml;
    }

    /**
     * Method to get the feed URL
     *
     * @return \SimpleXMLElement
     */
    public function url()
    {
        return $this->feedUrl;
    }

    /**
     * Method to get the feed
     *
     * @return array
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * Method to get feed template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Method to get feed date format
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * Method to get the prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->feedPrefix;
    }

    /**
     * Method to get feed limit
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Method to get feed type
     *
     * @return string
     */
    public function getType()
    {
        return $this->feedType;
    }

    /**
     * Method to determine if the feed type is RSS
     *
     * @return boolean
     */
    public function isRss()
    {
        return ($this->feedType == 'rss');
    }

    /**
     * Method to determine if the feed type is Atom
     *
     * @return boolean
     */
    public function isAtom()
    {
        return ($this->feedType == 'atom');
    }

    /**
     * Method to determine if the feed type is YouTube
     *
     * @return boolean
     */
    public function isYouTube()
    {
        return (strpos($this->feedUrl, 'youtube') !== false);
    }

    /**
     * Method to determine if the feed type is Twitter
     *
     * @return boolean
     */
    public function isVimeo()
    {
        return (strpos($this->feedUrl, 'vimeo') !== false);
    }

    /**
     * Method to determine if the feed type is Facebook
     *
     * @return boolean
     */
    public function isFacebook()
    {
        return (strpos($this->feedUrl, 'facebook') !== false);
    }

    /**
     * Method to determine if the feed type is Twitter
     *
     * @return boolean
     */
    public function isTwitter()
    {
        return (strpos($this->feedUrl, 'twitter') !== false);
    }

    /**
     * Method to determine if the feed type is a playlist
     *
     * @return boolean
     */
    public function isPlaylist()
    {
        $search = ($this->isVimeo()) ? 'album' : 'playlist';
        return (strpos($this->feedUrl, $search) !== false);
    }

    /**
     * Method to render the feed
     *
     * @param  boolean $ret
     * @throws Exception
     * @return mixed
     */
    public function render($ret = false)
    {
        if (null === $this->template) {
            throw new Exception('Error: The feed item template is not set.');
        }
        if (!isset($this->feed['items'])) {
            throw new Exception('Error: The feed currently has no content.');
        }

        $output = null;

        // Loop through the items, formatting them into the template as needed, using the proper date format if appropriate.
        foreach ($this->feed['items'] as $item) {
            $tmpl = $this->template;
            foreach ($item as $key => $value) {
                if (strpos($tmpl, '[{' . $key . '}]') !== false) {
                    if ((null !== $this->dateFormat) && ((stripos($key, 'date') !== false) || ((stripos($key, 'published') !== false)))) {
                        $value =  date($this->dateFormat, strtotime($value));
                    }
                    $tmpl = str_replace('[{' . $key . '}]', $value, $tmpl);
                }
            }
            $output .= $tmpl;
        }

        // Return the final output.
        if ($ret) {
            return $output;
        } else {
            echo $output;
        }
    }

    /**
     * Set method to set the property to the value of feed[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        if ($name == 'entry') {
            $name = 'item';
        }
        if ($name == 'entries') {
            $name = 'items';
        }
        $this->feed[$name] = $value;
    }

    /**
     * Get method to return the value of feed[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        if ($name == 'entry') {
            $name = 'item';
        }
        if ($name == 'entries') {
            $name = 'items';
        }
        return (isset($this->feed[$name])) ? $this->feed[$name] : null;
    }

    /**
     * Return the isset value of feed[$name].
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        if ($name == 'entry') {
            $name = 'item';
        }
        if ($name == 'entries') {
            $name = 'items';
        }
        return isset($this->feed[$name]);
    }

    /**
     * Unset feed[$name].
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        if ($name == 'entry') {
            $name = 'item';
        }
        if ($name == 'entries') {
            $name = 'items';
        }
        $this->feed[$name] = null;
    }

    /**
     * Render feed reader object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render(true);
    }

    /**
     * Method to parse the feed
     *
     * @return void
     */
    protected function parseFeed()
    {
        if ($this->isYouTube()) {
            $class = $this->feedPrefix . ucfirst($this->feedType) . '\YouTube';
        } else if ($this->isVimeo()) {
            $class = $this->feedPrefix . 'Rss\Vimeo';
        } else if ($this->isFacebook()) {
            $class = $this->feedPrefix . ucfirst($this->feedType) . '\Facebook';
        } else if ($this->isTwitter()) {
            $class = $this->feedPrefix . 'Rss\Twitter';
        } else {
            $class = $this->feedPrefix . ucfirst($this->feedType);
        }

        $feedObject = new $class($this);
        $feedObject->parse();
    }

}
