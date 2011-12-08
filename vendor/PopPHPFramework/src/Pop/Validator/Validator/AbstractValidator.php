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
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Validator\Validator;

use Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
abstract class AbstractValidator implements ValidatorInterface
{

    /**
     * Validator value to test against
     * @var mixed
     */
    protected $_value = null;

    /**
     * Validator condition
     * @var boolean
     */
    protected $_condition = true;

    /**
     * Input value to test
     * @var mixed
     */
    protected $_input = null;

    /**
     * Validator test result
     * @var boolean
     */
    protected $_result = false;

    /**
     * Validator default message
     * @var string
     */
    protected $_defaultMessage = null;

    /**
     * Constructor
     *
     * Instantiate the validator object
     *
     * @param  mixed   $value
     * @param  boolean $condition
     * @return void
     */
    public function __construct($value = null, $condition = true)
    {
        $this->_value = $value;
        $this->_condition = (boolean)$condition;
    }

    /**
     * Method to get the validator value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Method to get the validator condition
     *
     * @return boolean
     */
    public function getCondition()
    {
        return $this->_condition;
    }

    /**
     * Method to get the validator default message
     *
     * @return boolean
     */
    public function getDefaultMessage()
    {
        return $this->_defaultMessage;
    }

    /**
     * Method to get the validator input
     *
     * @return mixed
     */
    public function getInput()
    {
        return $this->_input;
    }

    /**
     * Method to set the validator value
     *
     * @param  mixed $value
     * @return Pop\Validator\Validator
     */
    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }

    /**
     * Method to set the validator condition
     *
     * @param  boolean $condition
     * @return Pop\Validator\Validator
     */
    public function setCondition($condition)
    {
        $this->_condition = (boolean)$condition;
        return $this;
    }

    /**
     * Method to set the validator input
     *
     * @param  mixed $input
     * @return Pop\Validator\Validator
     */
    public function setInput($input)
    {
        $this->_input = $input;
        return $this;
    }

    /**
     * Method to evaluate the validator
     *
     * @param  mixed $input
     * @return boolean
     */
    abstract public function evaluate($input = null);

}
