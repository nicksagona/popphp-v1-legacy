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
 * PHP feed reader class
 *
 * @category   Pop
 * @package    Pop_Feed
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Php extends AbstractFormat
{

    /**
     * Method to create a PHP feed object
     *
     * @param  mixed $options
     * @param  int   $limit
     * @throws Exception
     * @return \Pop\Feed\Format\Php
     */
    public function __construct($options, $limit = 0)
    {
        parent::__construct($options, $limit);

        if (!($this->obj = unserialize($this->source))) {
            throw new Exception('That feed URL cannot be read at this time. Please try again later.');
        }
    }

    /**
     * Method to parse a PHP feed object
     *
     * @return void
     */
    public function parse()
    {
        if (is_array($this->obj)) {
            foreach ($this->obj as $key => $value) {
                $this->feed[$key] = $value;
            }
        } else {
            $this->feed = $this->obj;
        }
    }

}
