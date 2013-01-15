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
namespace Pop\Validator;

use Pop\Locale\Locale;

/**
 * This is the Included class for the Validator component.
 *
 * @category   Pop
 * @package    Pop_Validator
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
class Included extends Validator
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
                $this->defaultMessage = Locale::factory()->__('The value must be included.');
            } else {
                $this->defaultMessage = Locale::factory()->__('The value must not be included.');
            }
        }

        // If input check is an array
        if (is_array($this->input)) {
            if (!is_array($this->value)) {
                $this->value = array($this->value);
            }
            $this->result = true;
            foreach ($this->value as $value) {
                if ((in_array($value, $this->input)) != $this->condition) {
                    $this->result = false;
                }
            }
        // Else, if input check is a string
        } else {
            if (is_array($this->value)) {
                $this->value = implode('', $this->value);
            }
            if ((strpos($this->input, $this->value) !== false) == $this->condition) {
                $this->result = true;
            } else {
                $this->result = false;
            }
        }

        return $this->result;
    }

}
