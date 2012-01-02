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
 * @package    Pop_Locale
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Locale;

use Pop\Curl\Curl,
    Pop\Dir\Dir,
    Pop\Dom\Dom,
    Pop\Dom\Child,
    Pop\File\File;

/**
 * @category   Pop
 * @package    Pop_Locale
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Translate
{

    /**
     * Language target
     * @var string
     */
    protected $_target = null;

    /**
     * Language source
     * @var string
     */
    protected $_source = 'en';

    /**
     * Client ID
     * @var string
     */
    protected $_clientId = null;

    /**
     * Client ID
     * @var string
     */
    protected $_clientSecret = null;

    /**
     * API token
     * @var string
     */
    protected $_apiToken = null;

    /**
     * API token expiration
     * @var string
     */
    protected $_expiration = null;

    /**
     * Token service URL
     * @var string
     */
    protected $_tokenServiceUrl = 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13';

    /**
     * API URL
     * @var string
     */
    protected $_apiUrl = 'http://api.microsofttranslator.com/v2/Http.svc/Translate';

    /**
     * Constructor
     *
     * Instantiate the translate object.
     *
     * @return void
     */
    public function __construct($target, $source = 'en', $clientId = null, $clientSecret = null)
    {
        $this->_target = $target;
        $this->_source = $source;
        $this->_clientId = $clientId;
        $this->_clientSecret = $clientSecret;
        if ((null !== $clientId) && (null !== $clientSecret)) {
            $this->getToken();
        }
    }

    /**
     * Get current source language.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->_source;
    }

    /**
     * Get current target language.
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->_target;
    }

    /**
     * Method to get new API token
     *
     * @throws Exception
     * @return Pop\Locale\Translate
     */
    public function getToken($clientId = null, $clientSecret = null)
    {
        if ((null !== $clientId) && (null !== $clientSecret)) {
            $this->_clientId = $clientId;
            $this->_clientSecret = $clientSecret;
        }
        if ((null === $this->_clientId) && (null === $this->_clientSecret)) {
            throw new Exception('You must pass the client ID and client secret arguments.');
        }

        $postString = 'client_id=' . urlencode($this->_clientId) .
                      '&client_secret=' . urlencode($this->_clientSecret) .
                      '&scope=' . urlencode('http://api.microsofttranslator.com') .
                      '&grant_type=' . urlencode('client_credentials');

        $options = array(
            CURLOPT_URL => $this->_tokenServiceUrl,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postString,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true
        );

        $curl = new Curl($options);
        $data = json_decode($curl->execute());
        $token = urldecode($data->access_token);
        $this->_apiToken = substr($token, (stripos($token, 'HMACSHA256=') + 11));
        $this->_expiration = urldecode($data->expires_in);

        return $this;
    }

    /**
     * Get token expiration
     *
     * @return string
     */
    public function getExpiration()
    {
        return $this->_expiration;
    }

    /**
     * Set current source language.
     *
     * @param  string $source
     * @return Pop\Locale\Translate
     */
    public function setSource($source = 'en')
    {
        $this->_source = $source;
        return $this;
    }

    /**
     * Set current target language.
     *
     * @param  string $target
     * @return Pop\Locale\Translate
     */
    public function setTarget($target)
    {
        $this->_target = $target;
        return $this;
    }

    /**
     * Set the API token
     *
     * @param  string $token
     * @return Pop\Locale\Translate
     */
    public function setToken($token)
    {
        $this->_apiToken = $token;
        return $this;
    }

    /**
     * Set current target language.
     *
     * @param  string $text
     * @return string
     */
    public function translate($text)
    {
        $postString = 'appId=' . urlencode($this->_apiToken) .
            '&text=' . urlencode($text) .
            '&from=' . urlencode($this->_source) .
            '&to=' . urlencode($this->_target);

        $options = array(
            CURLOPT_URL => $this->_apiUrl,
            CURLOPT_HEADER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postString,
            CURLOPT_RETURNTRANSFER => true
        );

        $curl = new Curl($options);
        echo $curl->execute();
    }

}
