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
class PayPal extends AbstractAdapter
{

    /**
     * API username
     * @var string
     */
    protected $_apiUsername = null;

    /**
     * API password
     * @var string
     */
    protected $_apiPassword = null;

    /**
     * API signature
     * @var string
     */
    protected $_signature = null;

    /**
     * Test URL
     * @var string
     */
    protected $_testUrl = 'https://api-3t.sandbox.paypal.com/nvp';

    /**
     * Live URL
     * @var string
     */
    protected $_liveUrl = 'https://api-3t.paypal.com/nvp';

    /**
     * Transaction data
     * @var array
     */
    protected $_transaction = array(
        'USER'             => null,
        'PWD'              => null,
        'SIGNATURE'        => null,
        'METHOD'           => 'DoDirectPayment',
        'VERSION'          => '84.0',
        'PAYMENTACTION'    => 'Sale',
        'CREDITCARDTYPE'   => null,
        'RECURRING'        => null,
        'AMT'              => null,
        'CURRENCYCODE'     => 'USD',
        'ACCT'             => null,
        'EXPDATE'          => null,
        'CVV2'             => null,
        'INVNUM'           => null,
        'DESC'             => null,
        'FIRSTNAME'        => null,
        'LASTNAME'         => null,
        'COMPANY'          => null,
        'STREET'           => null,
        'CITY'             => null,
        'STATE'            => null,
        'ZIP'              => null,
        'COUNTRYCODE'      => 'US',
        'SHIPTOPHONENUM'   => null,
        'FAX'              => null,
        'EMAIL'            => null,
        'IPADDRESS'        => null,
        'SHIPTOFNAME'      => null,
        'SHIPTOLNAME'      => null,
        'SHIPTOCOMPANY'    => null,
        'SHIPTOSTREET'     => null,
        'SHIPTOCITY'       => null,
        'SHIPTOSTATE'      => null,
        'SHIPTOZIP'        => null,
        'SHIPTOCOUNTRY'    => null,
        'TAXAMT'           => null,
        'SHIPPINGAMT'      => null,
        'RETURNFMFDETAILS' => 1
    );

    /**
     * Transaction fields for normalization purposes
     * @var array
     */
    protected $_fields = array(
        'amount'          => 'AMT',
        'cardNum'         => 'ACCT',
        'expDate'         => 'EXPDATE',
        'ccv'             => 'CVV2',
        'firstName'       => 'FIRSTNAME',
        'lastName'        => 'LASTNAME',
        'company'         => 'COMPANY',
        'address'         => 'STREET',
        'city'            => 'CITY',
        'state'           => 'STATE',
        'zip'             => 'ZIP',
        'country'         => 'COUNTRYCODE',
        'phone'           => 'SHIPTOPHONENUM',
        'fax'             => 'FAX',
        'email'           => 'EMAIL',
        'shipToFirstName' => 'SHIPTOFNAME',
        'shipToLastName'  => 'SHIPTOLNAME',
        'shipToCompany'   => 'SHIPTOCOMPANY',
        'shipToAddress'   => 'SHIPTOSTREET',
        'shipToCity'      => 'SHIPTOCITY',
        'shipToState'     => 'SHIPTOSTATE',
        'shipToZip'       => 'SHIPTOZIP',
        'shipToCountry'   => 'SHIPTOCOUNTRY'
    );

    /**
     * Required fields
     * @var array
     */
    protected $_requiredFields = array(
        'USER',
        'PWD',
        'SIGNATURE',
        'METHOD',
        'ACCT',
        'EXPDATE',
        'CVV2',
        'AMT',
        'FIRSTNAME',
        'LASTNAME',
        'STREET',
        'CITY',
        'STATE',
        'ZIP',
        'COUNTRYCODE',
        'IPADDRESS'
    );

    /**
     * Constructor
     *
     * Method to instantiate an PayPal payment adapter object
     *
     * @param  string  $apiUser
     * @param  string  $apiPass
     * @param  string  $sign
     * @param  boolean $test
     * @return void
     */
    public function __construct($apiUser, $apiPass, $sign, $test = false)
    {
        $this->_apiUsername = $apiUser;
        $this->_apiPassword = $apiPass;
        $this->_signature = $sign;
        $this->_transaction['USER'] = $apiUser;
        $this->_transaction['PWD'] = $apiPass;
        $this->_transaction['SIGNATURE'] = $sign;
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
        //print_r($this->_transaction);
        //echo $this->_buildPostString();
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
        $this->_responseCodes = $this->_parseResponseCodes();

        if (stripos($this->_responseCodes['ACK'], 'Success') !== false) {
            $this->_approved = true;
            $this->_message = 'The transaction has been approved.';
        } else {
            if (isset($this->_responseCodes['L_SHORTMESSAGE0']) && (stripos($this->_responseCodes['L_SHORTMESSAGE0'], 'Decline') !== false)) {
                $this->_declined = true;
            }
            if (isset($this->_responseCodes['L_SHORTMESSAGE0']) && (stripos($this->_responseCodes['L_SEVERITYCODE0'], 'Error') !== false)) {
                $this->_error = true;
            }
            if (isset($this->_responseCodes['L_LONGMESSAGE0'])) {
                $this->_message = $this->_responseCodes['L_LONGMESSAGE0'];
            }
        }
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

        if ((null !== $this->_transaction['SHIPTOFNAME']) || (null !== $this->_transaction['SHIPTOLNAME'])) {
            $this->_transaction['SHIPTONAME'] = $this->_transaction['SHIPTOFNAME'] . ' ' . $this->_transaction['SHIPTOLNAME'];
            $this->_transaction['SHIPTOFNAME'] = null;
            $this->_transaction['SHIPTOLNAME'] = null;
        }

        if (null === $this->_transaction['IPADDRESS']) {
            $this->_transaction['IPADDRESS'] = $_SERVER['REMOTE_ADDR'];
        }

        foreach ($this->_transaction as $key => $value) {
            if (null !== $value) {
                if ($key == 'ACCT') {
                    $value = $this->_filterCardNum($value);
                }
                if ($key == 'EXPDATE') {
                    $value = $this->_filterExpDate($value);
                }
                $post[] = $key . '=' . urlencode($value);
            }
        }

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

    /**
     * Filter the exp date
     *
     * @param  string $date
     * @return string
     */
    protected function _filterExpDate($date)
    {
        $filtered = $date;

        if (preg_match('/^\d\d\d\d\d\d$/', $filtered) == 0) {
            $delim = null;
            if (strpos($filtered, '/') !== false) {
                $delim = '/';
            } else if (strpos($filtered, '-') !== false) {
                $delim = '-';
            }
            if (null !== $delim) {
                $dateAry = explode($delim, $filtered);
                $month = $dateAry[0];
                $year = (strlen($dateAry[1]) == 2) ? '20' . $dateAry[1] : $dateAry[1];
                $filtered = $month . $year;
            } else {
                if (strlen($filtered) == 4) {
                    $filtered = substr($filtered, 0, 2) . '20' . substr($filtered, -2);
                }
            }
        }

        return $filtered;
    }

    /**
     * Parse the response codes
     *
     * @return void
     */
    protected function _parseResponseCodes()
    {
        $responseCodes = explode('&', $this->_response);
        $codes = array();

        foreach ($responseCodes as $key => $value) {
            $value = urldecode($value);
            $valueAry = explode('=', $value);
            $codes[$valueAry[0]] = (!empty($valueAry[1])) ? $valueAry[1] : null;
        }

        return $codes;
    }

}
