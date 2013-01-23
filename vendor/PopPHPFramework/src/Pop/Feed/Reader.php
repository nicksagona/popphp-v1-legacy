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
     * Feed adapter
     * @var \Pop\Feed\Format\AbstractFormat
     */
    protected $adapter = null;

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
     * @param \Pop\Feed\Format\AbstractFormat $adapter
     * @return \Pop\Feed\Reader
     */
    public function __construct(Format\AbstractFormat $adapter)
    {
        $this->adapter = $adapter;
        $this->adapter->parse();
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
     * Method to get the adapter object
     *
     * @return \Pop\Feed\Format\AbstractFormat
     */
    public function adapter()
    {
        return $this->adapter;
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
        $feed = $this->adapter()->getFeed();

        if (!isset($feed['items'])) {
            throw new Exception('Error: The feed currently has no content.');
        }

        $output = null;

        // Loop through the items, formatting them into the template as needed, using the proper date format if appropriate.
        foreach ($feed['items'] as $item) {
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
     * Render feed reader object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render(true);
    }

}
