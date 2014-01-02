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
 * Credit card validator class
 *
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class CreditCard extends Validator
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
            if (strpos($this->input, ' ') !== false) {
                $this->input = str_replace(' ', '', $this->input);
            }
            if (strpos($this->input, '-') !== false) {
                $this->input = str_replace('-', '', $this->input);
            }
        }

        // Set the default message
        if (null === $this->defaultMessage) {
            if ($this->condition) {
                $this->defaultMessage = I18n::factory()->__('The value must be a valid credit card number.');
            } else {
                $this->defaultMessage = I18n::factory()->__('The value must not be a valid credit card number.');
            }
        }

        // Evaluate the input against the validator
        $nums = str_split($this->input);
        $check = $nums[count($nums) - 1];
        $start = count($nums) - 2;
        $sum = 0;
        $double = true;

        for ($i = $start; $i >= 0; $i--) {
            if ($double) {
                $num = $nums[$i] * 2;
                if ($num > 9) {
                    $num = substr($num, 0, 1) + substr($num, 1, 1);
                }
                $sum += $num;
                $double = false;
            } else {
                $sum += $nums[$i];
                $double = true;
            }
        }

        $sum += $check;
        $rem = $sum % 10;

        if (($rem == 0) == $this->condition) {
            $this->result = true;
        } else {
            $this->result = false;
        }

        return $this->result;
    }

}
