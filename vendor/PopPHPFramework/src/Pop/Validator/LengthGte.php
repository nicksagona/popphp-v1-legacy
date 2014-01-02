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

use Pop\I18n\I18n;

/**
 * Length greater than or equal validator class
 *
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class LengthGte extends Validator
{

    /**
     * Method to evaluate the validator
     *
     * @param  mixed $input
     * @return boolean
     */
    public function evaluate($input = null)
    {
        // Set the input, if passed
        if (null !== $input) {
            $this->input = $input;
        }

        // Set the default message
        if (null === $this->defaultMessage) {
            if ($this->condition) {
                $this->defaultMessage = I18n::factory()->__('The value length must be greater than or equal to %1.', $this->value);
            } else {
                $this->defaultMessage = I18n::factory()->__('The value length must not be greater than or equal to %1.', $this->value);
            }
        }

        // Evaluate the input against the validator
        if ((strlen($this->input) >= $this->value) == $this->condition) {
            $this->result = true;
        } else {
            $this->result = false;
        }

        return $this->result;
    }

}
