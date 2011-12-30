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

use Pop\Curl\Curl,
    Pop\Locale\Locale,
    Pop\Payment\Adapter\AdapterInterface;

/**
 * @category   Pop
 * @package    Pop_Payment
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Authorize implements AdapterInterface
{

    /**
     * API Login ID
     * @var string
     */
    protected $_apiLoginId = null;

    /**
     * Transaction Key
     * @var string
     */
    protected $_transKey = null;

    /**
     * Transaction data
     * @var array
     */
    protected $_transaction = array(
        'x_login'                           => null,
        'x_tran_key'                        => null,
        'x_allow_partial_Auth'              => null,
        'x_version'                         => '3.1',
        'x_type'			                => 'AUTH_CAPTURE',
        'x_method'                          => 'CC',
        'x_recurring_billing'               => null,
        'x_amount'	                        => null,
        'x_card_num'                        => null,
        'x_exp_date'                        => null,
        'x_card_code'                       => null,
        'x_trans_id'                        => null,
        'x_split_tender_id'                 => null,
        'x_auth_code'                       => null,
        'x_test_request'                    => null,
        'x_duplicate_window'                => null,
        'x_merchant_descriptor'             => null,
        'x_invoice_num'			            => null,
        'x_description'                     => null,
        'x_line_item'                       => null,
        'x_first_name'                      => null,
        'x_last_name'                       => null,
        'x_company'                         => null,
        'x_address'                         => null,
        'x_city'                            => null,
        'x_state'                           => null,
        'x_zip'                             => null,
        'x_country'                         => null,
        'x_phone'                           => null,
        'x_fax'                             => null,
        'x_email'                           => null,
        'x_cust_id'                         => null,
        'x_customer_ip'                     => null,
        'x_ship_to_first_name'              => null,
        'x_ship_to_last_name'               => null,
        'x_ship_to_company'                 => null,
        'x_ship_to_address'                 => null,
        'x_ship_to_city'                    => null,
        'x_ship_to_state'                   => null,
        'x_ship_to_zip'                     => null,
        'x_ship_to_country'                 => null,
        'x_tax'                             => null,
        'x_freight'                         => null,
        'x_duty'                            => null,
        'x_tax_exempt'                      => null,
        'x_po_num'                          => null,
        'x_authentication_indicator'        => null,
        'x_cardholder_authentication_value' => null
    );

    /**
     * Transaction fields
     * @var array
     */
    protected $_fields = array(
        'amount'          => 'x_amount',
        'cardNum'         => 'x_card_num',
        'expDate'         => 'x_exp_date',
        'ccv'             => 'x_card_code',
        'firstName'       => 'x_first_name',
        'lastName'        => 'x_last_name',
        'company'         => 'x_company',
        'address'         => 'x_address',
        'city'            => 'x_city',
        'state'           => 'x_state',
        'zip'             => 'x_zip',
        'country'         => 'x_country',
        'phone'           => 'x_phone',
        'fax'             => 'x_fax',
        'email'           => 'x_email',
        'shipToFirstName' => 'x_ship_to_first_name',
        'shipToLastName'  => 'x_ship_to_last_name',
        'shipToCompany'   => 'x_ship_to_company',
        'shipToAddress'   => 'x_ship_to_address',
        'shipToCity'      => 'x_ship_to_city',
        'shipToState'     => 'x_ship_to_state',
        'shipToZip'       => 'x_ship_to_zip',
        'shipToCountry'   => 'x_ship_to_country'
    );

    /**
     * Required fields
     * @var array
     */
    protected $_requiredFields = array(
        'x_login',
        'x_tran_key',
        'x_version',
        'x_amount',
        'x_card_num',
        'x_exp_date'
    );

    /**
     * Test URL
     * @var string
     */
    protected $_testUrl = 'https://test.authorize.net/gateway/transact.dll';

    /**
     * Live URL
     * @var string
     */
    protected $_liveUrl = 'https://secure.authorize.net/gateway/transact.dll';

    /**
     * Boolean flag to use test environment or not
     * @var boolean
     */
    protected $_test = true;

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
     * @var int
     */
    protected $_responseCode = 0;

    /**
     * Response subcode
     * @var int
     */
    protected $_responseSubcode = 0;

    /**
     * Reason code
     * @var int
     */
    protected $_reasonCode = 0;

    /**
     * Response message
     * @var string
     */
    protected $_message = null;

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
     * Response message
     * @var string
     */
    protected $_responseMessage = null;

    /**
     * Constructor
     *
     * Method to instantiate a payment adapter object
     *
     * @param  string $apiLoginId
     * @param  string $transKey
     * @param  int    $state
     * @return void
     */
    public function __construct($apiLoginId, $transKey, $test = true)
    {
        $this->_apiLoginId = $apiLoginId;
        $this->_transKey = $transKey;
        $this->_transaction['x_login'] = $apiLoginId;
        $this->_transaction['x_tran_key'] = $transKey;
        $this->_test = $test;
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
     * Send transaction
     *
     * @throws Exception
     * @return Pop\Payment\Adapter\Authorize
     */
    public function send()
    {
        if (!$this->_validate()) {
            throw new Exception(Locale::factory()->__('The required transaction data has not been set.'));
        }

        $url = ($this->_test) ? $this->_testUrl : $this->_liveUrl;
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $this->_buildPostString(),
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true
        );

        $curl = new Curl($options);
        $this->_response = $curl->execute();
        $this->_responseCodes = explode('|', $this->_response);
        $this->_responseCode = $this->_responseCodes[0];
        $this->_responseSubcode = $this->_responseCodes[1];
        $this->_reasonCode = $this->_responseCodes[2];
        $this->_message = $this->_responseCodes[3];

        switch ($this->_responseCode) {
            case 1:
                $this->_approved = true;
                break;
            case 2:
                $this->_declined = true;
                break;
            case 3:
                $this->_error = true;
                break;
        }
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
     * Get response
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
     * Get response code
     *
     * @return int
     */
    public function getResponseCode()
    {
        return $this->_responseCode;
    }

    /**
     * Get response subcode
     *
     * @return int
     */
    public function getResponseSubcode()
    {
        return $this->_responseSubcode;
    }

    /**
     * Get reason code
     *
     * @return int
     */
    public function getReasonCode()
    {
        return $this->_reasonCode;
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
     * Validate that the required transaction data is set
     *
     * @return boolean
     */
    protected function _validate()
    {
        $valid = true;

        foreach ($this->_requiredFields as $field) {
            if (null === $field) {
                $valid = false;
            }
        }

        return $valid;
    }

    /**
     * Build the POST string
     *
     * @return string
     */
    protected function _buildPostString()
    {
        $post = array();
        $postString = null;

        foreach ($this->_transaction as $key => $value) {
            if (null !== $value) {
                $post[] = $key . '=' . urlencode($value);
            }
        }

        $post[] = 'x_delim_data=' . urlencode('TRUE');
        $post[] = 'x_delim_char=' . urlencode('|');

        foreach ($post as $key => $value) {
            $postString = implode('&', $post);
        }

        return $postString;
    }

}
