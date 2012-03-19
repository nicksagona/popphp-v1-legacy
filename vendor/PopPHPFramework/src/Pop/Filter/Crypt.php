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
 * @package    Pop_Filter
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Filter;

/**
 * This is the Crypt class for the Filter component.
 *
 * @category   Pop
 * @package    Pop_Filter
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0
 */
class Crypt
{

    /**
     * Static method to encrypt a string with the key using mcrypt
     *
     * @param  string $string
     * @param  string $key
     * @throws Exception
     * @return string
     */
    public static function encrypt($string, $key)
    {
        $encrypted = null;

        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);

        if (strlen($key) > $ivSize) {
            throw new Exception('Error: The length of the key is too long. It must not be longer than ' . $ivSize . ' characters.');
        }

        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB, $iv);
        $encrypted = trim(base64_encode($encrypted));

        return $encrypted;
    }

    /**
     * Static method to decrypt an encrypted string with the key using mcrypt
     *
     * @param  string $string
     * @param  string $key
     * @throws Exception
     * @return string
     */
    public static function decrypt($string, $key)
    {
        $decrypted = null;

        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);

        if (strlen($key) > $ivSize) {
            throw new Exception('Error: The length of the key is too long. It must not be longer than ' . $ivSize . ' characters.');
        }

        $decrypted = base64_decode($string);
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decrypted, MCRYPT_MODE_ECB, $iv);
        $decrypted = trim($decrypted);

        return $decrypted;
    }

}
