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

/**
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
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
    public function getDefaultMessage();

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
     * @return Pop\Validator\Validator
     */
    public function setValue($value);

    /**
     * Method to set the validator condition
     *
     * @param  boolean $condition
     * @return Pop\Validator\Validator
     */
    public function setCondition($condition);

    /**
     * Method to set the validator input
     *
     * @param  mixed $input
     * @return Pop\Validator\Validator
     */
    public function setInput($input);

}
