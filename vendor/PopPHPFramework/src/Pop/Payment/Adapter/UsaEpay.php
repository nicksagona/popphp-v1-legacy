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
class UsaEpay extends AbstractAdapter
{

    /**
     * Source Key
     * @var string
     */
    protected $_sourceKey = null;

    /**
     * Test URL
     * @var string
     */
    protected $_testUrl = 'https://sandbox.usaepay.com/gate';

    /**
     * Live URL
     * @var string
     */
    protected $_liveUrl = 'https://www.usaepay.com/gate';

    /**
     * Transaction data
     * @var array
     */
    protected $_transaction = array(
        'UMkey'              => null,
        'UMallowPartialAuth' => null,
        'UMversion'          => '2.9',
        'UMcommand'          => 'cc:sale',
        'UMamount'           => null,
        'UMcurrency'         => 840,  // USD by default, http://wiki.usaepay.com/developer/currencycode
        'UMcard'             => null, // No spaces or dashes
        'UMexpir'            => null, // MMYY format only
        'UMcvv2'             => null,
        'UMorderid'          => null,
        'UMauthCode'         => null,
        'UMtestmode'         => null,
        'UMinvoice'          => null,
        'UMdescription'      => null,
        'UMbillfname'        => null,
        'UMbilllname'        => null,
        'UMbillcompany'      => null,
        'UMbillstreet'       => null,
        'UMbillcity'         => null,
        'UMbillstate'        => null,
        'UMbillzip'          => null,
        'UMbillcountry'      => null,
        'UMbillphone'        => null,
        'UMtestmode '        => null,
        'UMemail'            => null,
        'UMcustid'           => null,
        'UMip'               => null,
        'UMshipfname'        => null,
        'UMshiplname'        => null,
        'UMshipcompany'      => null,
        'UMshipstreet'       => null,
        'UMshipcity'         => null,
        'UMshipstate'        => null,
        'UMshipzip'          => null,
        'UMshipcountry'      => null,
        'UMtax'              => null,
        'UMshipping'         => null,
        'UMponum'            => null
    );

    /**
     * Transaction fields for normalization purposes
     * @var array
     */
    protected $_fields = array(
        'amount'          => 'UMamount',
        'cardNum'         => 'UMcard',
        'expDate'         => 'UMexpir',
        'ccv'             => 'UMcvv2',
        'firstName'       => 'UMbillfname',
        'lastName'        => 'UMbilllname',
        'company'         => 'UMbillcompany',
        'address'         => 'UMbillstreet',
        'city'            => 'UMbillcity',
        'state'           => 'UMbillstate',
        'zip'             => 'UMbillzip',
        'country'         => 'UMbillcountry',
        'phone'           => 'UMbillphone',
        'fax'             => 'UMfax',
        'email'           => 'UMemail',
        'shipToFirstName' => 'UMshipfname',
        'shipToLastName'  => 'UMshiplname',
        'shipToCompany'   => 'UMshipcompany',
        'shipToAddress'   => 'UMshipstreet',
        'shipToCity'      => 'UMshipcity',
        'shipToState'     => 'UMshipstate',
        'shipToZip'       => 'UMshipzip',
        'shipToCountry'   => 'UMshipcountry'
    );

    /**
     * Required fields
     * @var array
     */
    protected $_requiredFields = array(
        'UMkey',
        'UMamount',
        'UMcard',
        'UMexpir'
    );

    /**
     * Constructor
     *
     * Method to instantiate an USAEpay payment adapter object
     *
     * @param  string  $sourceKey
     * @param  boolean $test
     * @return void
     */
    public function __construct($sourceKey, $test = false)
    {
        $this->_sourceKey = $sourceKey;
        $this->_transaction['UMkey'] = $sourceKey;
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
        $this->_responseCodes = $this->_parseResponseCodes();
        $this->_responseCode = $this->_responseCodes['UMerrorcode'];
        $this->_message = $this->_responseCodes['UMerror'];

        switch ($this->_responseCodes['UMstatus']) {
            case 'Approved':
                $this->_approved = true;
                break;
            case 'Declined':
                $this->_declined = true;
                break;
            case 'Error':
                $this->_error = true;
                break;
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

        foreach ($this->_transaction as $key => $value) {
            if (null !== $value) {
                if ($key == 'UMcard') {
                    $value = $this->_filterCardNum($value);
                }
                if ($key == 'UMexpir') {
                    $value = $this->_filterExpDate($value);
                }
                $post[] = $key . '=' . urlencode($value);
            }
        }

        if ((null !== $this->_transaction['UMbillfname']) && (null !== $this->_transaction['UMbilllname'])) {
            $post[] = 'UMname=' . urlencode($this->_transaction['UMbillfname'] . ' ' . $this->_transaction['UMbilllname']);
        }
        if (null !== $this->_transaction['UMbillstreet']) {
            $post[] = 'UMstreet=' . urlencode($this->_transaction['UMbillstreet']);
        }
        if (null !== $this->_transaction['UMbillzip']) {
            $post[] = 'UMzip=' . urlencode($this->_transaction['UMbillzip']);
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

        if (preg_match('/^\d\d\d\d$/', $filtered) == 0) {
            $delim = null;
            if (strpos($filtered, '/') !== false) {
                $delim = '/';
            } else if (strpos($filtered, '-') !== false) {
                $delim = '-';
            }
            if (null !== $delim) {
                $dateAry = explode($delim, $filtered);
                $month = $dateAry[0];
                $year = (strlen($dateAry[1]) == 4) ? substr($dateAry[1], -2) : $dateAry[1];
                $filtered = $month . $year;
            } else {
                if (strlen($filtered) == 6) {
                    $filtered = substr($filtered, 0, 2) . substr($filtered, -2);
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
