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
 * @package    Pop_Payment
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Payment\Adapter;

/**
 * This is the adapter interface for the Payment component.
 *
 * @category   Pop
 * @package    Pop_Payment
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
interface AdapterInterface
{

    /**
     * Get raw response
     *
     * @return string
     */
    public function getResponse();

    /**
     * Get response codes
     *
     * @return array
     */
    public function getResponseCodes();

    /**
     * Get specific response code from a field in the array
     *
     * @param string $key
     * @return string
     */
    public function getCode($key);

    /**
     * Get response code
     *
     * @return string
     */
    public function getResponseCode();

    /**
     * Get response message
     *
     * @return int
     */
    public function getMessage();

    /**
     * Return whether transaction data is valid
     *
     * @return boolean
     */
    public function isValid();

    /**
     * Return whether currently set to test environment
     *
     * @return boolean
     */
    public function isTest();

    /**
     * Return whether the transaction is approved
     *
     * @return boolean
     */
    public function isApproved();

    /**
     * Return whether the transaction is declined
     *
     * @return boolean
     */
    public function isDeclined();

    /**
     * Return whether the transaction is an error
     *
     * @return boolean
     */
    public function isError();

}
