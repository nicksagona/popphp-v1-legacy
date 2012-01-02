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
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Payment
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Authorize extends AbstractAdapter
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
     * Transaction data
     * @var array
     */
    protected $_transaction = array(
        'x_login'                           => null,
        'x_tran_key'                        => null,
        'x_allow_partial_Auth'              => null,
        'x_version'                         => '3.1',
        'x_type'                            => 'AUTH_CAPTURE',
        'x_method'                          => 'CC',
        'x_recurring_billing'               => null,
        'x_amount'                          => null,
        'x_card_num'                        => null,
        'x_exp_date'                        => null,
        'x_card_code'                       => null,
        'x_trans_id'                        => null,
        'x_split_tender_id'                 => null,
        'x_auth_code'                       => null,
        'x_test_request'                    => null,
        'x_duplicate_window'                => null,
        'x_merchant_descriptor'             => null,
        'x_invoice_num'                     => null,
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
     * Transaction fields for normalization purposes
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
     * Constructor
     *
     * Method to instantiate an Authorize.net payment adapter object
     *
     * @param  string  $apiLoginId
     * @param  string  $transKey
     * @param  boolean $test
     * @return void
     */
    public function __construct($apiLoginId, $transKey, $test = false)
    {
        $this->_apiLoginId = $apiLoginId;
        $this->_transKey = $transKey;
        $this->_transaction['x_login'] = $apiLoginId;
        $this->_transaction['x_tran_key'] = $transKey;
        $this->_test = $test;
    }

    /**
     * Send transaction
     *
     * @param  boolean $verifyPeer
     * @throws Exception
     * @return Pop\Payment\Adapter\Authorize
     */
    public function send($verifyPeer = true)
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

        if (!$verifyPeer) {
            $options[CURLOPT_SSL_VERIFYPEER] = false;
        }

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
                if ($key == 'x_card_num') {
                    $value = $this->_filterCardNum($value);
                }
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

    /**
     * Filter the card num to remove dashes or spaces
     *
     * @param  string $ccNum
     * @return string
     */
    protected function _filterCardNum($ccNum)
    {
        $filtered = $ccNum;

        if (strpos($filtered, '-') !== false) {
            $filtered = str_replace('-', '', $filtered);
        }
        if (strpos($filtered, ' ') !== false) {
            $filtered = str_replace(' ', '', $filtered);
        }

        return $filtered;
    }

}
