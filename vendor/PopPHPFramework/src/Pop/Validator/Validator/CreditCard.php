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
 * This is the CreditCard class for the Validator component.
 *
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
 */
class CreditCard extends AbstractValidator
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
                $this->defaultMessage = Locale::factory()->__('The value must be a valid credit card number.');
            } else {
                $this->defaultMessage = Locale::factory()->__('The value must not be a valid credit card number.');
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
