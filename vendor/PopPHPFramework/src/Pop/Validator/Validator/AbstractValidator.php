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
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Validator\Validator;

use Pop\Locale\Locale;

/**
 * This is the abstract Validator class for the Validator component.
 *
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
abstract class AbstractValidator implements ValidatorInterface
{

    /**
     * Validator value to test against
     * @var mixed
     */
    protected $value = null;

    /**
     * Validator condition
     * @var boolean
     */
    protected $condition = true;

    /**
     * Input value to test
     * @var mixed
     */
    protected $input = null;

    /**
     * Validator test result
     * @var boolean
     */
    protected $result = false;

    /**
     * Validator default message
     * @var string
     */
    protected $defaultMessage = null;

    /**
     * Constructor
     *
     * Instantiate the validator object
     *
     * @param  mixed   $value
     * @param  boolean $condition
     * @param  string  $msg
     * @return \Pop\Validator\Validator\AbstractValidator
     */
    public function __construct($value = null, $condition = true, $msg = null)
    {
        $this->value = $value;
        $this->condition = (boolean)$condition;

        if (null !== $msg) {
            $this->defaultMessage = $msg;
        }
    }

    /**
     * Method to get the validator value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Method to get the validator condition
     *
     * @return boolean
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * Method to get the validator default message
     *
     * @return boolean
     */
    public function getDefaultMessage()
    {
        return $this->defaultMessage;
    }

    /**
     * Method to get the validator input
     *
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Method to set the validator value
     *
     * @param  mixed $value
     * @return \Pop\Validator\Validator
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Method to set the validator condition
     *
     * @param  boolean $condition
     * @return \Pop\Validator\Validator
     */
    public function setCondition($condition)
    {
        $this->condition = (boolean)$condition;
        return $this;
    }

    /**
     * Method to set the validator condition
     *
     * @param  string $message
     * @return \Pop\Validator\Validator
     */
    public function setDefaultMessage($message)
    {
        $this->defaultMessage = $message;
        return $this;
    }

    /**
     * Method to set the validator input
     *
     * @param  mixed $input
     * @return \Pop\Validator\Validator
     */
    public function setInput($input)
    {
        $this->input = $input;
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
