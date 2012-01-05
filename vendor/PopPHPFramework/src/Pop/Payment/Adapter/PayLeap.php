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
class PayLeap extends AbstractAdapter
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
    protected $_testUrl = 'https://uat.payleap.com/TransactServices.svc/ProcessCreditCard';

    /**
     * Live URL
     * @var string
     */
    protected $_liveUrl = 'https://secure1.payleap.com/TransactServices.svc/ProcessCreditCard';

    /**
     * Transaction data
     * @var array
     */
    protected $_transaction = array(
        'UserName'    => null,
        'Password'    => null,
        'TransType'   => 'Sale',
        'CardNum'     => null,
        'ExpDate'     => null,
        'CVNum'       => null,
        'Amount'      => null,
        'FNameOnCard' => null,
        'LNameOnCard' => null,
        'InvNum'      => null,
        'Street'      => null,
        'City'        => null,
        'State'       => null,
        'Zip'         => null,
        'Country'     => null,
        'Email'       => null,
        'Phone'       => null,
        'Fax'         => null,
        'TaxAmt'      => null,
        'CustomerID'  => null,
        'PONum'       => null
    );

    /**
     * Transaction fields for normalization purposes
     * @var array
     */
    protected $_fields = array(
        'amount'          => 'Amount',
        'cardNum'         => 'CardNum',
        'expDate'         => 'ExpDate',
        'ccv'             => 'CVNum',
        'firstName'       => 'FNameOnCard',
        'lastName'        => 'LNameOnCard',
        'address'         => 'Street',
        'city'            => 'City',
        'state'           => 'State',
        'zip'             => 'Zip',
        'country'         => 'Country',
        'phone'           => 'Phone',
        'fax'             => 'Fax',
        'email'           => 'Email',
    );

    /**
     * Required fields
     * @var array
     */
    protected $_requiredFields = array(
        'UserName',
        'Password',
        'TransType',
        'CardNum',
        'ExpDate',
        'Amount'
    );

    /**
     * Constructor
     *
     * Method to instantiate an Payleap payment adapter object
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
        $this->_transaction['UserName'] = $apiLoginId;
        $this->_transaction['Password'] = $transKey;
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
        $url .= '?' . $this->_buildQueryString();

        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true
        );

        if (!$verifyPeer) {
            $options[CURLOPT_SSL_VERIFYPEER] = false;
        }

        $curl = new Curl($options);
        $this->_response = $curl->execute();

    }

    /**
     * Build the query string
     *
     * @return string
     */
    protected function _buildQueryString()
    {
        $query = $this->_transaction;
        $query['CardNum'] = $this->_filterCardNum($query['CardNum']);
        $query['ExpDate'] = $this->_filterExpDate($query['ExpDate']);

        if ((null !== $query['FNameOnCard']) || (null !== $query['LNameOnCard'])) {
            $query['NameOnCard'] = $query['FNameOnCard'] . ' ' . $query['LNameOnCard'];
        } else {
            $query['NameOnCard'] = null;
        }

        $query['MagData'] = null;
        $query['ExtData'] = $this->_buildExtData();
        $query['PNRef'] = null;

        unset($query['FNameOnCard']);
        unset($query['LNameOnCard']);
        unset($query['City']);
        unset($query['State']);
        unset($query['Country']);
        unset($query['Email']);
        unset($query['Phone']);
        unset($query['Fax']);
        unset($query['TaxAmt']);
        unset($query['CustomerID']);
        unset($query['PONum']);

        $queryString = null;
        foreach ($query as $key => $value) {
            $queryString .= '&' . $key . '=' . urlencode($value);
        }

        return substr($queryString, 1);
    }

    /**
     * Build the ExtData XML string
     *
     * @return string
     */
    protected function _buildExtData()
    {
        $ext = null;

        if (null !== $this->_transaction['TaxAmt']) {
            $ext .= '<TaxAmt>' . $this->_transaction['TaxAmt'] . '</TaxAmt>';
        }
        if (null !== $this->_transaction['CustomerID']) {
            $ext .= '<CustomerID>' . $this->_transaction['CustomerID'] . '</CustomerID>';
        }
        if (null !== $this->_transaction['PONum']) {
            $ext .= '<PONum>' . $this->_transaction['PONum'] . '</PONum>';
        }
        if ((null !== $this->_transaction['FNameOnCard']) ||
            (null !== $this->_transaction['LNameOnCard']) ||
            (null !== $this->_transaction['Street']) ||
            (null !== $this->_transaction['City']) ||
            (null !== $this->_transaction['State']) ||
            (null !== $this->_transaction['Zip']) ||
            (null !== $this->_transaction['Country']) ||
            (null !== $this->_transaction['Email']) ||
            (null !== $this->_transaction['Phone']) ||
            (null !== $this->_transaction['Fax'])) {
            $ext .= '<Invoice><BillTo>';
            if (null !== $this->_transaction['CustomerID']) {
                $ext .= '<CustomerID>' . $this->_transaction['CustomerID'] . '</CustomerID>';
            }
            if ((null !== $this->_transaction['FNameOnCard']) || (null !== $this->_transaction['LNameOnCard'])) {
                $ext .= '<Name>' . $this->_transaction['FNameOnCard'] . ' ' . $this->_transaction['LNameOnCard'] . '</Name>';
            }
            $ext .= '<Address>';
            $ext .= '<Street>' . $this->_transaction['Street'] . '</Street>';
            $ext .= '<City>' . $this->_transaction['City'] . '</City>';
            $ext .= '<State>' . $this->_transaction['State'] . '</State>';
            $ext .= '<Zip>' . $this->_transaction['Zip'] . '</Zip>';
            $ext .= '<Country>' . $this->_transaction['Country'] . '</Country>';
            $ext .= '</Address>';
            if (null !== $this->_transaction['Email']) {
                $ext .= '<Email>' . $this->_transaction['Email'] . '</Email>';
            }
            if (null !== $this->_transaction['Phone']) {
                $ext .= '<Phone>' . $this->_transaction['Phone'] . '</Phone>';
            }
            if (null !== $this->_transaction['Fax']) {
                $ext .= '<Fax>' . $this->_transaction['Fax'] . '</Fax>';
            }
            if (null !== $this->_transaction['PONum']) {
                $ext .= '<PONum>' . $this->_transaction['PONum'] . '</PONum>';
            }
            $ext .= '</BillTo></Invoice>';
        }
        return $ext;
    }

}





