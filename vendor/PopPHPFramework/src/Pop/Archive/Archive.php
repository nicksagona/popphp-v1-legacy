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
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Archive;

use Pop\Archive\Adapter\ArchiveInterface;

use Pop\File\File;

/**
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Archive extends File
{

    /**
     * Array of allowed file types.
     * @var array
     */
    protected $_allowed = array('bz2'  => 'application/bzip2',
                                'gz'   => 'application/x-gzip',
                                'phar' => 'application/x-phar',
                                'rar'  => 'application/x-rar-compressed',
                                'tar'  => 'application/x-tar',
                                'tbz2' => 'application/bzip2',
                                'tgz'  => 'application/x-gzip',
                                'zip'  => 'application/x-zip');

    /**
     * Archive adapter
     * @var mixed
     */
    protected $_adapter = null;

    /**
     * Constructor
     *
     * Instantiate the archive object
     *
     * @param  string $archive
     * @return void
     */
    public function __construct($archive)
    {
        // Check if Bzip2 is available.
        if (!function_exists('bzcompress')) {
            unset($this->_allowed['bz2']);
            unset($this->_allowed['tbz2']);
        }
        // Check if Gzip is available.
        if (!function_exists('gzcompress')) {
            unset($this->_allowed['gz']);
            unset($this->_allowed['tgz']);
        }
        // Check if Phar is available.
        if (!class_exists('Phar')) {
            unset($this->_allowed['phar']);
        }
        // Check if Rar is available.
        if (!class_exists('RarArchive')) {
            unset($this->_allowed['tar']);
        }
        // Check if Tar is available.
        if (!class_exists('Archive_Tar')) {
            unset($this->_allowed['tar']);
        }
        // Check if Zip is available.
        if (!class_exists('ZipArchive')) {
            unset($this->_allowed['zip']);
        }

        parent::__construct($archive);
    }

    /**
     * Static method to instantiate the archive object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $archive
     * @return Pop_Archive
     */
    public static function factory($archive)
    {
        return new self($archive);
    }

    /**
     * Method to extract an archived and/or compressed file
     *
     * @param  string $to
     * @return Pop_Archive
     */
    public function extract($to = null)
    {
        $this->_adapter->extract($to);
        return $this;
    }

    /**
     * Method to create an archive file
     *
     * @param  string|array $files
     * @return Pop_Archive
     */
    public function addFiles($files)
    {
        $this->_adapter->addFiles($files);
        return $this;
    }

    /**
     * Method to create an archive file
     *
     * @param  string|array $files
     * @return Pop_Archive
     */
    public function removeFiles($files)
    {
        $this->_adapter->removeFiles($files);
        return $this;
    }

    /**
     * Method to return a listing of the contents of an archived file
     *
     * @param  boolean $all
     * @throws Exception
     * @return array
     */
    public function listFiles($all = false)
    {
        $this->_adapter->listFiles($all);
        return $this;
    }

}
