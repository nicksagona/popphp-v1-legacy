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
 * Is subnet of validator class
 *
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class IsSubnetOf extends Validator
{

    /**
     * Method to evaluate the validator
     *
     * @param  mixed $input
     * @throws Exception
     * @return boolean
     */
    public function evaluate($input = null)
    {
        // Check to make sure the input is a valid Ipv4 address.
        $ip = new Ipv4();
        if (!Ipv4::factory()->evaluate($input)) {
            throw new Exception('The IP address must be a valid IPv4 address.');
        }

        // Set the input, if passed
        if (null !== $input) {
            $this->input = $input;
        }

        // Set the default message
        if (null === $this->defaultMessage) {
            if ($this->condition) {
                $this->defaultMessage = I18n::factory()->__('The value must be part of the subnet %1.', $this->value);
            } else {
                $this->defaultMessage = I18n::factory()->__('The value must not be part of the subnet %1.', $this->value);
            }
        }

        // Evaluate the input against the validator
        if ((substr($this->input, 0, strrpos($this->input, '.')) == $this->value) == $this->condition) {
            $this->result = true;
        } else {
            $this->result = false;
        }

        return $this->result;
    }

}
