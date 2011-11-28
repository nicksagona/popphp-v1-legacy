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
class ArrayFilter extends \ArrayObject
{

    /**
     * Constant for regular sort
     * @var int
     */
    const SORT = 0;

    /**
     * Constant for regular reverse sort
     * @var int
     */
    const SORT_R = 1;

    /**
     * Constant for regular sort, maintaining index association
     * @var int
     */
    const SORT_A = 2;

    /**
     * Constant for regular reverse sort, maintaining index association
     * @var int
     */
    const SORT_AR = 3;

    /**
     * Constant for regular sort, by array key
     * @var int
     */
    const SORT_K = 4;

    /**
     * Constant for regular reverse sort, by array key
     * @var int
     */
    const SORT_KR = 5;

    /**
     * Array flags property
     * @var mixed
     */
    protected $_flags = null;

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
    protected $_pattern = 'all';

    /**
     * Constructor
     *
     * Instantiate the array object.
     *
     * @param  array $arr
     * @param  mixed $flags
     * @return void
     */
    public function __construct($arr = array(), $flags = null)
    {
        $this->_flags = $flags;

        if (null !== $this->_flags) {
            parent::__construct((!is_array($arr) ? array($arr) : $arr), $this->_flags);
        } else {
            parent::__construct((!is_array($arr) ? array($arr) : $arr));
        }
    }

    /**
     * Static method to instantiate the array object and return itself
     * to facilitate chaining methods together.
     *
     * @param  array $arr
     * @param  boolean $props
     * @return Pop_Array
     */
    public static function factory($arr = null, $props = false)
    {
        return new self($arr, $props);
    }

    /**
     * Static method to calculate the percent values of an array of numbers
     *
     * @param  array $arr
     * @param  int   $prec
     * @param  int   $mode
     * @return array
     */
    public static function calcPercentages($arr, $prec = 2, $mode = PHP_ROUND_HALF_UP)
    {
        $percentages = array();
        $total = array_sum($arr);

        foreach ($arr as $key => $value) {
            $percentages[$value] = round((($value / $total) * 100), $prec, $mode);
        }

        $percentages['total'] = $total;

        return new self($percentages);
    }

    /**
     * Method to check if a key exists in the array
     *
     * @param  string|int $key
     * @return boolean
     */
    public function keyExists($key)
    {
        return array_key_exists($key, (array)$this);
    }

    /**
     * Method to return the key in the array of the value passed.
     *
     * @param  mixed $value
     * @return boolean
     */
    public function keySearch($value)
    {
        return array_search($value, (array)$this);
    }

    /**
     * Method to return the keys of the array
     *
     * @return array
     */
    public function getKeys()
    {
        return array_keys((array)$this);
    }

    /**
     * Method to return the keys of the array
     *
     * @param  mixed $value
     * @return array
     */
    public function inArray($value)
    {
        return in_array($value, (array)$this);
    }

    /**
     * Method to return the keys of the array
     *
     * @param  int   $type
     * @param  mixed $flags
     * @return Pop_Array
     */
    public function sort($type = ArrayFilter::SORT, $flags = null)
    {
        $ary = (array)$this;
        $flags = (null !== $flags) ? $flags : SORT_REGULAR;

        switch ($type) {
            case self::SORT:
                sort($ary, $flags);
                break;

            case self::SORT_R:
                rsort($ary, $flags);
                break;

            case self::SORT_A:
                asort($ary, $flags);
                break;

            case self::SORT_AR:
                arsort($ary, $flags);
                break;

            case self::SORT_K:
                ksort($ary, $flags);
                break;

            case self::SORT_KR:
                krsort($ary, $flags);
                break;

        }

        self::__construct($ary, $this->_flags);

        return $this;
    }

    /**
     * Method to perform a search over the array and return an array of the results.
     *
     * @param  string  $search
     * @param  boolean $case
     * @param  string $preserve
     * @return mixed
     */
    public function search($search, $case = false, $preserve = 'ARRAY')
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
        $found = array_filter((array)$this, array($this, '_searchArray'));

        switch ($preserve) {
            // Return as an array.
            case 'ARRAY':
                return $found;
                break;

            // Return as an array object.
            case 'ARRAY_OBJECT':
                return ($this->_props) ? new \ArrayObject($found, \ArrayObject::ARRAY_AS_PROPS) : new \ArrayObject($found);
                break;

            // Return as itself, overwriting the values of the array with the new results.
            case 'SELF':
                return new self($found, $this->_props);
                break;
        }
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
