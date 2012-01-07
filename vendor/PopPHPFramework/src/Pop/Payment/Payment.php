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
namespace Pop\Payment;

use Pop\Payment\Adapter\AbstractAdapter;

/**
 * @category   Pop
 * @package    Pop_Payment
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Payment
{

    /**
     * Constant for test mode only
     * @var int
     */
    const TEST = true;

    /**
     * Payment adapter
     * @var mixed
     */
    protected $_adapter = null;

    /**
     * Common transaction fields.
     *
     * These are the common transaction fields that will be normalized to the
     * proper field names by the adapter. You can also add direct adapter-specific
     * fields to the payment transaction object that won't be affected by
     * the field normalization, for example:
     *
     * (Authorize.net)
     * $payment->x_invoice_num = '12345';
     *
     * (UsaEPay)
     * $payment->UMinvoice = '12345';
     *
     * @var array
     */
    protected $_fields = array(
        'amount'          => null,
        'cardNum'         => null,
        'expDate'         => null,
        'ccv'             => null,
        'firstName'       => null,
        'lastName'        => null,
        'company'         => null,
        'address'         => null,
        'city'            => null,
        'state'           => null,
        'zip'             => null,
        'country'         => null,
        'phone'           => null,
        'fax'             => null,
        'email'           => null,
        'shipToFirstName' => null,
        'shipToLastName'  => null,
        'shipToCompany'   => null,
        'shipToAddress'   => null,
        'shipToCity'      => null,
        'shipToState'     => null,
        'shipToZip'       => null,
        'shipToCountry'   => null
    );

    /**
     * Constructor
     *
     * Instantiate the payment object
     *
     * @param Pop\Payment\Adapter\AbstractAdapter $adapter
     * @return void
     */
    public function __construct(AbstractAdapter $adapter)
    {
        $this->_adapter = $adapter;
    }

    /**
     * Access the adapter
     *
     * @return Pop\Payment\Adapter\AbstractAdapter
     */
    public function adapter()
    {
        return $this->_adapter;
    }

    /**
     * Send transaction data
     *
     * @param  boolean $verifyPeer
     * @return Pop\Payment\Payment
     */
    public function send($verifyPeer = true)
    {
        $this->_adapter->set($this->_fields);
        $this->_adapter->send();
    }

    /**
     * Validate transaction data
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->_adapter->isValid();
    }

    /**
     * Return whether the transaction is in test mode
     *
     * @return boolean
     */
    public function isTest()
    {
        return $this->_adapter->isTest();
    }

    /**
     * Return whether the transaction is approved
     *
     * @return boolean
     */
    public function isApproved()
    {
        return $this->_adapter->isApproved();
    }

    /**
     * Return whether the transaction is declined
     *
     * @return boolean
     */
    public function isDeclined()
    {
        return $this->_adapter->isDeclined();
    }

    /**
     * Return whether the transaction is an error
     *
     * @return boolean
     */
    public function isError()
    {
        return $this->_adapter->isError();
    }

    /**
     * Get raw response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->_adapter->getResponse();
    }

    /**
     * Get response codes
     *
     * @return array
     */
    public function getResponseCodes()
    {
        return $this->_adapter->getResponseCodes();
    }

    /**
     * Get specific response code from a field in the array
     *
     * @return string
     */
    public function getCode($key)
    {
        return $this->_adapter->getCode($key);
    }

    /**
     * Get response code
     *
     * @return string
     */
    public function getResponseCode()
    {
        return $this->_adapter->getResponseCode();
    }

    /**
     * Get response message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->_adapter->getMessage();
    }

    /**
     * Set the shipping data fields to the same as billing data fields
     *
     * @return Pop\Payment\Payment
     */
    public function billingSameAsShipping()
    {
        $this->_fields['shipToFirstName'] = $this->_fields['firstName'];
        $this->_fields['shipToLastName'] = $this->_fields['lastName'];
        $this->_fields['shipToCompany'] = $this->_fields['company'];
        $this->_fields['shipToAddress'] = $this->_fields['address'];
        $this->_fields['shipToCity'] = $this->_fields['city'];
        $this->_fields['shipToState'] = $this->_fields['state'];
        $this->_fields['shipToZip'] = $this->_fields['zip'];
        $this->_fields['shipToCountry'] = $this->_fields['country'];

        return $this;
    }

    /**
     * Set method to set the property to the value of _fields[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->_fields[$name] = $value;
    }

    /**
     * Get method to return the value of _fields[$name].
     *
     * @param  string $name
     * @throws Exception
     * @return mixed
     */
    public function __get($name)
    {
        return (isset($this->_fields[$name])) ? $this->_fields[$name] : null;
    }

    /**
     * Return the isset value of _fields[$name].
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->_fields[$name]);
    }

    /**
     * Unset _fields[$name].
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        $this->_fields[$name] = null;
    }

}
