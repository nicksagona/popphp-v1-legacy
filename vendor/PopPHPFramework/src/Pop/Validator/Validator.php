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
namespace Pop\Validator;

use Pop\Validator\Validator,
    Pop\Validator\Validator\ValidatorInterface;

/**
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Validator
{

    /**
     * Validator object
     * @var mixed
     */
    protected $validator = null;

    /**
     * Validator test result message
     * @var string
     */
    protected $message = null;

    /**
     * Constructor
     *
     * Instantiate the validator object
     *
     * @param  mixed   $validator
     * @param  string  $message
     * @return void
     */
    public function __construct(ValidatorInterface $validator, $message = null)
    {
        $this->validator = $validator;
        $this->message = $message;
    }

    /**
     * Static method to instantiate the validator object and return itself
     * to facilitate chaining methods together.
     *
     * @param  mixed   $validator
     * @param  string  $message
     * @return Pop\Validator\Validator
     */
    public static function factory(ValidatorInterface $validator, $message = null)
    {
        return new self($validator, $message);
    }

    /**
     * Method to get the validator type
     *
     * @return string
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Method to get the validator result message
     *
     * @return string
     */
    public function getMessage()
    {
        $msg = null;
        if (null !== $this->message) {
            $msg = $this->message;
        } else {
            $msg = $this->validator->getDefaultMessage();
        }
        return $msg;
    }

    /**
     * Method to set the validator result message
     *
     * @param  string $message
     * @return Pop\Validator\Validator
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Method to evaluate the validator
     *
     * @param  mixed $input
     * @return boolean
     */
    public function evaluate($input = null)
    {
        return $this->validator->evaluate($input);
    }

}
