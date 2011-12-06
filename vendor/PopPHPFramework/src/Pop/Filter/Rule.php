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
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Filter;

use Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Auth
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Rule
{

    /**
     * Rule type
     * @var string
     */
    protected $_type = null;

    /**
     * Rule condition
     * @var boolean
     */
    protected $_condition = true;

    /**
     * Rule value to test against
     * @var mixed
     */
    protected $_value = null;

    /**
     * Input value to test
     * @var mixed
     */
    protected $_input = null;

    /**
     * Rule test result message
     * @var string
     */
    protected $_message = null;

    /**
     * Rule test result
     * @var boolean
     */
    protected $_result = false;

    /**
     * Allowed rule types
     * @var array
     */
    protected $_allowedTypes = array(
                                   'AlphaNum',
                                   'Alpha',
                                   'Between',
                                   'BetweenInclude',
                                   'Email',
                                   'Equal',
                                   'Excluded',
                                   'GreaterThan',
                                   'GreaterThanEqual',
                                   'Included',
                                   'LengthEquals',
                                   'LengthBetween',
                                   'LengthBetweenInclude',
                                   'LengthGT',
                                   'LengthGTE',
                                   'LengthLT',
                                   'LengthLTE',
                                   'LessThan',
                                   'LessThanEqual',
                                   'NotEmpty',
                                   'NotEqual',
                                   'Num',
                                   'RegEx'
                               );

    /**
     * Constructor
     *
     * Instantiate the rule object
     *
     * @param  string  $type
     * @param  mixed   $value
     * @param  boolean $condition
     * @param  string  $message
     * @throws Exception
     * @return void
     */
    public function __construct($type, $value = null, $condition = true, $message = null)
    {
        if (!in_array($type, $this->_allowedTypes)) {
            throw new Exception($this->_lang->__('Error: That type validator is not allowed.'));
        } else {
            $this->_type = $type;
            $this->_value = $value;
            $this->_condition = (boolean)$condition;
            $this->_message = $message;
        }
    }

    /**
     * Static method to instantiate the rule object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string  $type
     * @param  mixed   $value
     * @param  boolean $condition
     * @param  string  $message
     * @return Pop\Filter\Rule
     */
    public static function factory($type, $value = null, $condition = true, $message = null)
    {
        return new self($type, $value, $condition, $message);
    }

    /**
     * Method to get the rule type
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Method to get the rule value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Method to get the rule condition
     *
     * @return boolean
     */
    public function getCondition()
    {
        return $this->_condition;
    }

    /**
     * Method to get the rule result message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * Method to get the rule input
     *
     * @return mixed
     */
    public function getInput()
    {
        return $this->_input;
    }

    /**
     * Method to set the rule type
     *
     * @param  string $type
     * @return Pop\Filter\Rule
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    /**
     * Method to set the rule value
     *
     * @param  mixed $value
     * @return Pop\Filter\Rule
     */
    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }

    /**
     * Method to set the rule condition
     *
     * @param  boolean $condition
     * @return Pop\Filter\Rule
     */
    public function setCondition($condition)
    {
        $this->_condition = (boolean)$condition;
        return $this;
    }

    /**
     * Method to set the rule result message
     *
     * @param  string $message
     * @return Pop\Filter\Rule
     */
    public function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }

    /**
     * Method to set the rule input
     *
     * @param  mixed $input
     * @return Pop\Filter\Rule
     */
    public function setInput($input)
    {
        $this->_input = $input;
        return $this;
    }

    /**
     * Method to evaluate the rule
     *
     * @param  mixed $input
     * @return boolean
     */
    public function evaluate($input = null)
    {
        if (null !== $input) {
            $this->_input = $input;
        }

        switch ($this->_type) {
            case 'AlphaNum':
                if (preg_match('/^\w+$/', $this->_input) == $this->_condition) {
                    $this->_result = true;
                } else {
                    if (null === $this->_message) {
                        $this->_message = 'AlphaNum failed.';
                    }
                }
                break;
            case 'Alpha':
                if (preg_match('/^[a-zA-Z]+$/', $this->_input) == $this->_condition) {
                    $this->_result = true;
                } else {
                    if (null === $this->_message) {
                        $this->_message = 'Alpha failed.';
                    }
                }
                break;
            case 'Between':
                break;
            case 'BetweenInclude':
                break;
            case 'Email':
                if (preg_match('/[a-zA-Z0-9\.\-\_+%]+@[a-zA-Z0-9\-\_\.]+\.[a-zA-Z]{2,4}/', $this->_input) == $this->_condition) {
                    $this->_result = true;
                } else {
                    if (null === $this->_message) {
                        $this->_message = 'Email failed.';
                    }
                }
                break;
            case 'Equal':
                break;
            case 'Excluded':
                break;
            case 'GreaterThan':
                break;
            case 'GreaterThanEqual':
                break;
            case 'Included':
                break;
            case 'LengthEquals':
                break;
            case 'LengthBetween':
                break;
            case 'LengthBetweenInclude':
                break;
            case 'LengthGT':
                break;
            case 'LengthGTE':
                break;
            case 'LengthLT':
                break;
            case 'LengthLTE':
                break;
            case 'LessThan':
                break;
            case 'LessThanEqual':
                break;
            case 'NotEmpty':
                break;
            case 'NotEqual':
                break;
            case 'Num':
                break;
            case 'RegEx':
                break;
        }

        return $this->_result;

    }

}
