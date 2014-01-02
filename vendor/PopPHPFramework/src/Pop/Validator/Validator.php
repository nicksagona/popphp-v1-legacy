<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Validator;

/**
 * Validator class
 *
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Validator implements ValidatorInterface
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
     * @param  string  $msg
     * @param  boolean $condition
     * @return \Pop\Validator\Validator
     */
    public function __construct($value = null, $msg = null, $condition = true)
    {
        $this->value = $value;
        $this->condition = (boolean)$condition;

        if (null !== $msg) {
            $this->defaultMessage = $msg;
        }
    }

    /**
     * Static method to instantiate the validator object and return itself
     * to facilitate chaining methods together.
     *
     * @param  mixed   $value
     * @param  string  $msg
     * @param  boolean $condition
     * @return \Pop\Validator\Validator
     */
    public static function factory($value = null, $msg = null, $condition = true)
    {
        return new static($value, $msg, $condition);
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
    public function getMessage()
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
     * @return \Pop\Validator\ValidatorInterface
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
     * @return \Pop\Validator\ValidatorInterface
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
     * @return \Pop\Validator\ValidatorInterface
     */
    public function setMessage($message)
    {
        $this->defaultMessage = $message;
        return $this;
    }

    /**
     * Method to set the validator input
     *
     * @param  mixed $input
     * @return \Pop\Validator\ValidatorInterface
     */
    public function setInput($input)
    {
        $this->input = $input;
        return $this;
    }

}
