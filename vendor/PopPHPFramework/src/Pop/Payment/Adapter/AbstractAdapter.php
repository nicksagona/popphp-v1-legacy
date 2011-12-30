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
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Payment\Adapter;

/**
 * @category   Pop
 * @package    Pop_Payment
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */


abstract class AbstractAdapter implements AdapterInterface
{

    /**
     * Transaction data
     * @var array
     */
    protected $_transaction = array();

    /**
     * Transaction fields for normalization purposes
     * @var array
     */
    protected $_fields = array();

    /**
     * Required fields
     * @var array
     */
    protected $_requiredFields = array();

    /**
     * Boolean flag to use test environment or not
     * @var boolean
     */
    protected $_test = true;

    /**
     * Boolean flag for approved transaction
     * @var boolean
     */
    protected $_approved = false;

    /**
     * Boolean flag for declined transaction
     * @var boolean
     */
    protected $_declined = false;

    /**
     * Boolean flag for error transaction
     * @var boolean
     */
    protected $_error = false;

    /**
     * Response string
     * @var string
     */
    protected $_response = null;

    /**
     * Response codes
     * @var array
     */
    protected $_responseCodes = array();

    /**
     * Response code
     * @var string
     */
    protected $_responseCode = null;

    /**
     * Response message
     * @var string
     */
    protected $_message = null;

    /**
     * Send transaction
     *
     * @param  boolean $verifyPeer
     * @throws Exception
     * @return mixed
     */
    abstract public function send($verifyPeer = true);

    /**
     * Get raw response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Get response codes
     *
     * @return array
     */
    public function getResponseCodes()
    {
        return $this->_responseCodes;
    }

    /**
     * Get specific response code from a field in the array
     *
     * @return string
     */
    public function getCode($key)
    {
        return (isset($this->_responseCodes[$key])) ? $this->_responseCodes[$key] : null;
    }

    /**
     * Get response code
     *
     * @return string
     */
    public function getResponseCode()
    {
        return $this->_responseCode;
    }

    /**
     * Get response message
     *
     * @return int
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * Return whether currently set to test environment
     *
     * @return boolean
     */
    public function isTest()
    {
        return $this->_test;
    }

    /**
     * Return whether the transaction is approved
     *
     * @return boolean
     */
    public function isApproved()
    {
        return $this->_approved;
    }

    /**
     * Return whether the transaction is declined
     *
     * @return boolean
     */
    public function isDeclined()
    {
        return $this->_declined;
    }

    /**
     * Return whether the transaction is an error
     *
     * @return boolean
     */
    public function isError()
    {
        return $this->_error;
    }

    /**
     * Set transaction data
     *
     * @param  array|string $data
     * @param  string       $value
     * @return Pop\Payment\Adapter\Authorize
     */
    public function set($data, $value = null)
    {
        if (!is_array($data)) {
            $data = array($data => $value);
        }

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->_fields)) {
                $this->_transaction[$this->_fields[$key]] = $value;
            } else {
                $this->_transaction[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Validate that the required transaction data is set
     *
     * @return boolean
     */
    protected function _validate()
    {
        $valid = true;

        if (count($this->_requiredFields) > 0) {
            foreach ($this->_requiredFields as $field) {
                if (null === $field) {
                    $valid = false;
                }
            }
        }

        return $valid;
    }

}
