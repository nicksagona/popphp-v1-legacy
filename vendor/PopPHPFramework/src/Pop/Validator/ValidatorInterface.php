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
 * Validator interface
 *
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
interface ValidatorInterface
{

    /**
     * Method to get the validator value
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Method to get the validator condition
     *
     * @return boolean
     */
    public function getCondition();

    /**
     * Method to get the validator default message
     *
     * @return boolean
     */
    public function getMessage();

    /**
     * Method to get the validator input
     *
     * @return mixed
     */
    public function getInput();

    /**
     * Method to set the validator value
     *
     * @param  mixed $value
     * @return \Pop\Validator\Validator
     */
    public function setValue($value);

    /**
     * Method to set the validator condition
     *
     * @param  boolean $condition
     * @return \Pop\Validator\Validator
     */
    public function setCondition($condition);

    /**
     * Method to set the validator default message
     *
     * @param  string $message
     * @return \Pop\Validator\Validator
     */
    public function setMessage($message);

    /**
     * Method to set the validator input
     *
     * @param  mixed $input
     * @return \Pop\Validator\Validator
     */
    public function setInput($input);

}
