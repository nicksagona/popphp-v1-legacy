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

use Pop\Filter\String;

/**
 * SHA Crypt class
 *
 * @category   Pop
 * @package    Pop_Crypt
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Sha implements CryptInterface
{

    /**
     * Bits
     * @var int
     */
    protected $bits = 512;

    /**
     * Rounds
     * @var int
     */
    protected $rounds = 5000;

    /**
     * Salt
     * @var string
     */
    protected $salt = null;

    /**
     * Constructor
     *
     * Instantiate the sha object.
     *
     * @param  int $bits
     * @param  int $rounds
     * @throws Exception
     * @return self
     */
    public function __construct($bits = 512, $rounds = 5000)
    {

        $this->setBits($bits);
        $this->setRounds($rounds);
    }

    /**
     * Method to set the cost
     *
     * @param  int $bits
     * @throws Exception
     * @return self
     */
    public function setBits($bits = 512)
    {
        $bits = (int)$bits;

        if (($bits != 256) && ($bits != 512)) {
            throw new Exception('Error: The bit setting must be 256 or 512');
        }
        if (($bits == 256) && (CRYPT_SHA256 == 0)) {
            throw new Exception('Error: SHA 256 hashing is not supported on this system.');
        }
        if (($bits == 512) && (CRYPT_SHA512 == 0)) {
            throw new Exception('Error: SHA 512 hashing is not supported on this system.');
        }

        $this->bits = $bits;
        return $this;
    }

    /**
     * Method to get the bits
     *
     * @return int
     */
    public function getBits()
    {
        return $this->bits;
    }

    /**
     * Method to set the rounds
     *
     * @param  int $rounds
     * @return self
     */
    public function setRounds($rounds = 5000)
    {
        $rounds = (int)$rounds;

        if ($rounds < 1000) {
            $rounds = 1000;
        } else if ($rounds > 999999999) {
            $rounds = 999999999;
        }

        $this->rounds = $rounds;
        return $this;
    }

    /**
     * Method to get the rounds
     *
     * @return int
     */
    public function getRounds()
    {
        return $this->rounds;
    }

    /**
     * Method to set the salt
     *
     * @param  string $salt
     * @return self
     */
    public function setSalt($salt = null)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * Method to get the salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Method to create the hashed value
     *
     * @param  string $string
     * @throws Exception
     * @return string
     */
    public function create($string)
    {
        $hash = null;
        $prefix = ($this->bits == 512) ? '$6$' : '$5$';
        $prefix .= 'rounds=' . $this->rounds . '$';

        $this->salt = (null === $this->salt) ?
            substr(str_replace('+', '.', base64_encode(String::random(32))), 0, 16) :
            substr(str_replace('+', '.', base64_encode($this->salt)), 0, 16);

        $hash = crypt($string, $prefix . $this->salt);

        return $hash;
    }

    /**
     * Method to verify the hashed value
     *
     * @param  string $string
     * @param  string $hash
     * @throws Exception
     * @return boolean
     */
    public function verify($string, $hash)
    {
        $result = crypt($string, $hash);
        return ($result === $hash);
    }

}
