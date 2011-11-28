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
 * @package    Pop_Ftp
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @category   Pop
 * @package    Pop_Ftp
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */

/**
 * @namespace
 */
namespace Pop\Ftp;
use Pop\Locale\Locale;

class Ftp
{

    /**
     * FTP resource
     * @var FTP resource
     */
    protected $_conn = null;

    /**
     * Language object
     * @var Pop_Locale
     */
    protected $_lang = null;

    /**
     * Constructor
     *
     * Instantiate the FTP object.
     *
     * @param  string  $ftp
     * @param  string  $user
     * @param  string  $pass
     * @param  boolean $ssl
     * @return void
     * @throws Exception
     */
    public function __construct($ftp, $user, $pass, $ssl = false)
    {
        $this->_lang = new Locale();

        if ($ssl) {
            if (!($this->_conn = ftp_ssl_connect($ftp))) {
                throw new Exception($this->_lang->__('Error: There was an error connecting to the FTP server %1.', $ftp));
            }
        } else {
            if (!($this->_conn = ftp_connect($ftp))) {
                throw new Exception($this->_lang->__('Error: There was an error connecting to the FTP server %1.', $ftp));
            }
        }

        if (!@ftp_login($this->_conn, $user, $pass)) {
            throw new Exception($this->_lang->__('Error: There was an error connecting to the FTP server %1 with those credentials.', $ftp));
        }
    }

    /**
     * Return current working directory.
     *
     * @return string
     */
    public function pwd()
    {
        return ftp_pwd($this->_conn);
    }

    /**
     * Change directories.
     *
     * @param  string $dir
     * @return void
     * @throws Exception
     */
    public function chdir($dir)
    {
        if (!@ftp_chdir($this->_conn, $dir)) {
            throw new Exception($this->_lang->__('Error: There was an error changing to the directory %1.', $dir));
        }
    }

    /**
     * Make directory.
     *
     * @param  string $dir
     * @return void
     * @throws Exception
     */
    public function mkdir($dir)
    {
        if (!@ftp_mkdir($this->_conn, $dir)) {
            throw new Exception($this->_lang->__('Error: There was an error making the directory %1.', $dir));
        }
    }

    /**
     * Remove directory.
     *
     * @param  string $dir
     * @return void
     * @throws Exception
     */
    public function rmdir($dir)
    {
        if (!@ftp_mkdir($this->_conn, $dir)) {
            throw new Exception($this->_lang->__('Error: There was an error removing the directory %1.', $dir));
        }
    }

    /**
     * Get file.
     *
     * @param  string $local
     * @param  string $remote
     * @param  string $mode
     * @return void
     * @throws Exception
     */
    public function get($local, $remote, $mode = FTP_BINARY)
    {
        if (!@ftp_get($this->_conn, $local, $remote, $mode)) {
            throw new Exception($this->_lang->__('Error: There was an error getting the file %1.', $remote));
        }
    }

    /**
     * Put file.
     *
     * @param  string $remote
     * @param  string $local
     * @param  string $mode
     * @return void
     * @throws Exception
     */
    public function put($remote, $local, $mode = FTP_BINARY)
    {
        if (!@ftp_put($this->_conn, $remote, $local, $mode)) {
            throw new Exception($this->_lang->__('Error: There was an error putting the file %1.', $local));
        }
    }

    /**
     * Rename file.
     *
     * @param  string $old
     * @param  string $new
     * @param  string $mode
     * @return void
     * @throws Exception
     */
    public function rename($old, $new)
    {
        if (!@ftp_rename($this->_conn, $old, $new)) {
            throw new Exception($this->_lang->__('Error: There was an error renaming the file %1.', $old));
        }
    }

    /**
     * Change permissions.
     *
     * @param  string $file
     * @param  string $mode
     * @return void
     * @throws Exception
     */
    public function chmod($file, $mode)
    {
        if (!@ftp_chmod($this->_conn, $mode, $file)) {
            throw new Exception($this->_lang->__('Error: There was an error changing the permission of %1.', $file));
        }
    }

    /**
     * Delete file.
     *
     * @param  string $file
     * @return void
     * @throws Exception
     */
    public function delete($file)
    {
        if (!@ftp_delete($this->_conn, $file)) {
            throw new Exception($this->_lang->__('Error: There was an error removing the file %1.', $file));
        }
    }

    /**
     * Switch the passive mode.
     *
     * @param  boolean $flag
     * @return void
     */
    public function pasv($flag = true)
    {
        ftp_pasv($this->_conn, $flag);
    }

    /**
     * Close the FTP connection.
     *
     * @return void
     */
    public function __destruct()
    {
        ftp_close($this->_conn);
    }

}
