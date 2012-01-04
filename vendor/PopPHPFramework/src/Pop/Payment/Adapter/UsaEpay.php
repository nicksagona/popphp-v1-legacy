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
        $post = $this->_transaction;

        $post['UMcard'] = $this->_filterCardNum($post['UMcard']);
        $post['UMexpir'] = $this->_filterExpDate($post['UMexpir']);

        if ((null !== $post['UMbillfname']) && (null !== $post['UMbilllname'])) {
            $post['UMname'] =  $post['UMbillfname'] . ' ' . $post['UMbilllname'];
            unset($post['UMbillfname']);
            unset($post['UMbilllname']);
        }
        if (null !== $post['UMbillstreet']) {
            $post['UMstreet'] = $post['UMbillstreet'];
            unset($post['UMbillstreet']);
        }
        if (null !== $this->_transaction['UMbillzip']) {
            $post['UMzip'] = $post['UMbillzip'];
            unset($post['UMbillzip']);
        }

        return http_build_query($post);
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
