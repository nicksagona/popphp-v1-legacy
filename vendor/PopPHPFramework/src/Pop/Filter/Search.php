<?php
/**
 * Pop PHP Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.TXT.
 * It is also available through the world-wide-web at this URL:
 * http://www.popphp.org/LICENSE.TXT
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@popphp.org so we can send you a copy immediately.
 *
 * @category   Pop
 * @package    Pop_Filter
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Filter;

/**
 * @category   Pop
 * @package    Pop_Filter
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Search
{

    /**
     * Data to search
     * @var array
     */
    protected $_data = null;

    /**
     * Delimiter
     * @var string
     */
    protected $_delim = null;

    /**
     * Search property
     * @var string
     */
    protected $_search = null;

    /**
     * Case search property
     * @var boolean
     */
    protected $_case = false;

    /**
     * Search pattern property
     * @var string
     */
    protected $_pattern = null;

    /**
     * Constructor
     *
     * Instantiate the search object.
     *
     * @param  mixed  $data
     * @param  string $delim
     * @return void
     */
    public function __construct($data, $delim = "\n")
    {
        if (is_array($data)) {
            $this->_data = $data;
        } else {
            $this->_data = explode($delim, trim($data));
        }
    }

    /**
     * Static method to instantiate the array object and return itself
     * to facilitate chaining methods together.
     *
     * @param  mixed  $data
     * @param  string $des
     * @return Pop\Filter\Search
     */
    public static function factory($data, $delim = "\n")
    {
        return new self($data, $delim);
    }

    /**
     * Method to perform a search over the array and return an array of the results.
     * Wildcards (*) are supported, such as:
     *
     *   string* (beginning with 'string')
     *
     *   - or -
     *
     *   *string (ending with 'string')
     *
     * @param  string  $search
     * @param  boolean $case
     * @return array
     */
    public function search($search, $case = false)
    {
       $this->_case = $case;

        if (substr($search, 0, 1) == '*') {
            $this->_pattern = 'back';
            $this->_search = substr($search, 1);
        } else if (substr($search, -1) == '*') {
            $this->_pattern = 'front';
            $this->_search = substr($search, 0, -1);
        } else {
            $this->_pattern = 'all';
            $this->_search = $search;
        }

        // Execute the array filter to search the array.
        return array_filter($this->_data, array($this, '_searchArray'));
    }

    /**
     * Method to search an array for a string, non-inclusive.
     *
     * @param  string $val
     * @return string
     */
    protected function _searchArray($val)
    {
        // If case sensitive.
        if ($this->_case) {
            switch ($this->_pattern) {
                // For 'string*'
                case 'front':
                    if (substr($val, 0, strlen($this->_search)) == $this->_search) {
                        return $val;
                    }
                    break;

                // For '*string'
                case 'back':
                    if (substr($val, (0 - strlen($this->_search)), strlen($this->_search)) == $this->_search) {
                        return $val;
                    }
                    break;

                // For 'string' (all-inclusive)
                case 'all':
                    if (strpos($val, $this->_search) !== false) {
                        return $val;
                    }
                    break;
            }
        // Else, case insensitive.
        } else {
            switch ($this->_pattern) {
                // For 'string*'
                case 'front':
                    if (substr(strtolower($val), 0, strlen($this->_search)) == strtolower($this->_search)) {
                        return $val;
                    }
                    break;

                // For '*string'
                case 'back':
                    if (substr(strtolower($val), (0 - strlen($this->_search)), strlen($this->_search)) == strtolower($this->_search)) {
                        return $val;
                    }
                    break;

                // For 'string' (all-inclusive)
                case 'all':
                    if (stripos($val, $this->_search) !== false) {
                        return $val;
                    }
                    break;
            }
        }
    }

}
