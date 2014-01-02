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
 * MD5 Crypt class
 *
 * @category   Pop
 * @package    Pop_Crypt
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Md5 implements CryptInterface
{

    /**
     * Salt
     * @var string
     */
    protected $salt = null;

    /**
     * Constructor
     *
     * Instantiate the md5 object.
     *
     * @throws Exception
     * @return self
     */
    public function __construct()
    {
        if (CRYPT_MD5 == 0) {
            throw new Exception('Error: MD5 hashing is not supported on this system.');
        }
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
     * @return string
     */
    public function create($string)
    {
        $hash = null;

        $this->salt = (null === $this->salt) ?
            substr(str_replace('+', '.', base64_encode(String::random(32))), 0, 9) :
            substr(str_replace('+', '.', base64_encode($this->salt)), 0, 9);

        $hash = crypt($string, '$1$' . $this->salt);

        return $hash;
    }

    /**
     * Method to verify the hashed value
     *
     * @param  string $string
     * @param  string $hash
     * @return boolean
     */
    public function verify($string, $hash)
    {
        $result = crypt($string, $hash);
        return ($result === $hash);
    }

}
