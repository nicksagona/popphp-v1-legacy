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
namespace Pop\Filter\Rule;

/**
 * @category   Pop
 * @package    Pop_Filter
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
interface RuleInterface
{

    /**
     * Method to get the rule value
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Method to get the rule condition
     *
     * @return boolean
     */
    public function getCondition();

    /**
     * Method to get the rule input
     *
     * @return mixed
     */
    public function getInput();

    /**
     * Method to set the rule value
     *
     * @param  mixed $value
     * @return Pop\Filter\Rule
     */
    public function setValue($value);

    /**
     * Method to set the rule condition
     *
     * @param  boolean $condition
     * @return Pop\Filter\Rule
     */
    public function setCondition($condition);

    /**
     * Method to set the rule input
     *
     * @param  mixed $input
     * @return Pop\Filter\Rule
     */
    public function setInput($input);

}
