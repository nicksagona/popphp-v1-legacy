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
 * Shipping adapter interface
 *
 * @category   Pop
 * @package    Pop_Shipping
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.6.0
 */
interface AdapterInterface
{

    /**
     * Set ship to
     *
     * @param  array  $shipTo
     * @return mixed
     */
    public function shipTo(array $shipTo);

    /**
     * Set ship from
     *
     * @param  array  $shipFrom
     * @return mixed
     */
    public function shipFrom(array $shipFrom);

    /**
     * Set dimensions
     *
     * @param  array  $dimensions
     * @param  string $unit
     * @return mixed
     */
    public function setDimensions(array $dimensions, $unit = null);

    /**
     * Set dimensions
     *
     * @param  string $weight
     * @param  string $unit
     * @return mixed
     */
    public function setWeight($weight, $unit = null);

    /**
     * Send transaction
     *
     * @param  boolean $verifyPeer
     * @throws Exception
     * @return mixed
     */
    public function send($verifyPeer = true);

}
