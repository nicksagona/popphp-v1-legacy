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

use Pop\File\File,
    Pop\Locale\Locale;

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

        // Create the archive interface.
        if (stripos($this->ext, 'bz2') !== false) {
            $this->_interface = new Bzip2();
        } else if (stripos($this->ext, 'gz') !== false) {
            $this->_interface = new Gzip();
        } else if ($this->ext == 'tar') {
            $this->_interface = new Tar();
        } else if ($this->ext == 'zip') {
            $this->_interface = new Zip();
        }
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
     * Static method to compress a string of data
     *
     * @param  string $data
     * @param  int    $type
     * @param  int    $level
     * @return string
     */
    public static function compress($data, $type = Archive::GZIP, $level = 4)
    {
        $compress = null;

        switch ($type) {
            // Gzip
            case 1:
                $compress = gzcompress($data, $level);
                break;

            // Bzip2
            case 2:
                $compress = bzcompress($data, $level);
                break;

            // Deflate
            case 3:
                $compress = gzdeflate($data, $level);
                break;

            // LZF
            case 4:
                $compress = lzf_compress($data);
                break;
        }

        return $compress;
    }

    /**
     * Static method to decompress a string of data
     *
     * @param  string $data
     * @param  int    $type
     * @return string
     */
    public static function decompress($data, $type = Archive::GZIP)
    {
        $decompress = null;

        switch ($type) {
            // Gzip
            case 1:
                $decompress = gzuncompress($data);
                break;

            // Bzip2
            case 2:
                $decompress = bzdecompress($data);
                break;

            // Deflate
            case 3:
                $decompress = gzinflate($data);
                break;

            // LZF
            case 4:
                $decompress = lzf_decompress($data);
                break;
        }

        return $decompress;
    }

    /**
     * Method to extract an archived and/or compressed file
     *
     * @param  string $to
     * @return Pop_Archive
     */
    public function extract($to = null)
    {
        $new = $this->_interface->extract($this, $to);
        if ($new != -1) {
            self::__construct($new);
        }

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
        if ((stripos($this->ext, 'bz2') !== false) || (stripos($this->ext, 'gz') !== false)) {
            throw new Exception(Locale::factory()->__('The archive file must be either a TAR or ZIP archive file.'));
        } else {
            $this->_interface->add($this, $files);
        }

        return $this;
    }

    /**
     * Method to compress an archive file
     *
     * @param  int     $type
     * @param  boolean $replace
     * @param  int     $level
     * @return Pop_Archive
     */
    public function compressArchive($type = Archive::GZIP, $replace = false, $level = 4)
    {
        $origArchive = $this->fullpath;

        switch ($type) {
            // Gzip
            case 1:
                self::__construct(Gzip::compress($this, $level));
                break;

            // Bzip2
            case 2:
                self::__construct(Bzip2::compress($this));
                break;
        }

        // If $replace flag is passed, remove the original archive.
        if (($replace) && file_exists($origArchive)) {
            unlink($origArchive);
        }
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
        if ((stripos($this->ext, 'bz2') !== false) || (stripos($this->ext, 'gz') !== false)) {
            throw new Exception(Locale::factory()->__('The archive file is compressed. It must only be either a TAR or ZIP archive file to list the contents.'));
        } else {
            return $this->_interface->listFiles($this, $all);
        }
    }

}
