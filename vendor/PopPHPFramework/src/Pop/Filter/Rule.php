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
 * @package    Pop_Filter
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Filter;

use Pop\Filter\Rule,
    Pop\Filter\Rule\RuleInterface;

/**
 * @category   Pop
 * @package    Pop_Filter
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Rule
{

    /**
     * Rule object
     * @var mixed
     */
    protected $_rule = null;

    /**
     * Rule test result message
     * @var string
     */
    protected $_message = null;

    /**
     * Constructor
     *
     * Instantiate the rule object
     *
     * @param  mixed   $rule
     * @param  string  $message
     * @return void
     */
    public function __construct(RuleInterface $rule, $message = null)
    {
        $this->_rule = $rule;
        $this->_message = $message;
    }

    /**
     * Static method to instantiate the rule object and return itself
     * to facilitate chaining methods together.
     *
     * @param  mixed   $rule
     * @param  string  $message
     * @return Pop\Filter\Rule
     */
    public static function factory(RuleInterface $rule, $message = null)
    {
        return new self($rule, $message);
    }

    /**
     * Method to get the rule type
     *
     * @return string
     */
    public function getRule()
    {
        return $this->_rule;
    }

    /**
     * Method to get the rule result message
     *
     * @return string
     */
    public function getMessage()
    {
        $msg = null;
        if (null !== $this->_message) {
            $msg = $this->_message;
        } else {
            $msg = $this->_rule->getDefaultMessage();
        }
        return $msg;
    }

    /**
     * Method to set the rule result message
     *
     * @param  string $message
     * @return Pop\Filter\Rule
     */
    public function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }

    /**
     * Method to evaluate the rule
     *
     * @param  mixed $input
     * @return boolean
     */
    public function evaluate($input = null)
    {
        return $this->_rule->evaluate($input);
    }

}
