<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Shipping
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Shipping\Adapter;

/**
 * Shipping adapter abstract class
 *
 * @category   Pop
 * @package    Pop_Shipping
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.6.0
 */


abstract class AbstractAdapter implements AdapterInterface
{

    /**
     * Response XML
     * @var \SimpleXmlElement
     */
    protected $response = null;

    /**
     * Response code
     * @var int
     */
    protected $responseCode = null;

    /**
     * Response message
     * @var string
     */
    protected $responseMessage = null;

    /**
     * Service rates
     * @var string
     */
    protected $rates = array();

    /**
     * Send transaction
     *
     * @param  boolean $verifyPeer
     * @return mixed
     */
    abstract public function send($verifyPeer = true);

    /**
     * Return whether the transaction is a success
     *
     * @return boolean
     */
    abstract public function isSuccess();

    /**
     * Return whether the transaction is an error
     *
     * @return boolean
     */
    abstract public function isError();

    /**
     * Get response
     *
     * @return object
     */
    abstract public function getResponse();

    /**
     * Get response code
     *
     * @return int
     */
    abstract public function getResponseCode();

    /**
     * Get response message
     *
     * @return string
     */
    abstract public function getResponseMessage();

    /**
     * Get service rates
     *
     * @return array
     */
    abstract public function getRates();

}
