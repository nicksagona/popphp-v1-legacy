<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Crypt
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Crypt;

/**
 * Crypt interface
 *
 * @category   Pop
 * @package    Pop_Crypt
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
interface CryptInterface
{

    /**
     * Method to set the salt
     *
     * @param  string $salt
     * @return self
     */
    public function setSalt($salt = null);

    /**
     * Method to get the salt
     *
     * @return string
     */
    public function getSalt();

    /**
     * Method to create the hashed value
     *
     * @param  string $string
     * @return string
     */
    public function create($string);

    /**
     * Method to create the hashed value
     *
     * @param  string $string
     * @param  string $hash
     * @return boolean
     */
    public function verify($string, $hash);

}
