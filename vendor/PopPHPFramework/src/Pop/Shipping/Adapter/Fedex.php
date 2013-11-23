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

use Pop\Curl\Curl;
use Pop\Dom\Dom;
use Pop\Dom\Child;

/**
 * PayLeap payment adapter class
 *
 * @category   Pop
 * @package    Pop_Shipping
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.6.0
 */
class Fedex extends AbstractAdapter
{


    /**
     * API URL
     * @var string
     */
    protected $url = '';

    /**
     * Constructor
     *
     * Method to instantiate an FedEx shipping adapter object
     *
     * @return \Pop\Shipping\Adapter\Fedex
     */
    public function __construct()
    {

    }

    /**
     * Set ship to
     *
     * @param  array  $shipTo
     * @return mixed
     */
    public function shipTo(array $shipTo)
    {

    }

    /**
     * Set ship from
     *
     * @param  array  $shipFrom
     * @return mixed
     */
    public function shipFrom(array $shipFrom)
    {

    }

    /**
     * Set dimensions
     *
     * @param  array  $dimensions
     * @param  string $unit
     * @return mixed
     */
    public function setDimensions(array $dimensions, $unit = null)
    {

    }

    /**
     * Set dimensions
     *
     * @param  string $weight
     * @param  string $unit
     * @return mixed
     */
    public function setWeight($weight, $unit = null)
    {

    }

    /**
     * Send transaction
     *
     * @param  boolean $verifyPeer
     * @return void
     */
    public function send($verifyPeer = true)
    {

    }

    /**
     * Return whether the transaction is a success
     *
     * @return boolean
     */
    public function isSuccess()
    {

    }

    /**
     * Return whether the transaction is an error
     *
     * @return boolean
     */
    public function isError()
    {

    }

    /**
     * Get response
     *
     * @return object
     */
    public function getResponse()
    {

    }

    /**
     * Get response code
     *
     * @return int
     */
    public function getResponseCode()
    {

    }

    /**
     * Get response message
     *
     * @return string
     */
    public function getResponseMessage()
    {

    }

    /**
     * Get service rates
     *
     * @return array
     */
    public function getRates()
    {

    }

}





