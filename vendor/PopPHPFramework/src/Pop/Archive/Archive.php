<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Archive;

use Pop\Compress;

/**
 * Archive class
 *
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Archive extends \Pop\File\File
{

    /**
     * Array of allowed file types.
     * @var array
     */
    protected $allowed = array(
        'bz2'  => 'application/bzip2',
        'gz'   => 'application/x-gzip',
        'phar' => 'application/x-phar',
        'rar'  => 'application/x-rar-compressed',
        'tar'  => 'application/x-tar',
        'tbz'  => 'application/bzip2',
        'tbz2' => 'application/bzip2',
        'tgz'  => 'application/x-gzip',
        'zip'  => 'application/x-zip'
    );

    /**
     * Archive adapter
     * @var mixed
     */
    protected $adapter = null;

    /**
     * Constructor
     *
     * Instantiate the archive object
     *
     * @param  string $archive
     * @param  string $password
     * @param  string $prefix
     * @return \Pop\Archive\Archive
     */
    public function __construct($archive, $password = null, $prefix = 'Pop\\Archive\\Adapter\\')
    {
        $this->allowed = self::formats();
        parent::__construct($archive);
        $this->setAdapter($password, $prefix);
    }

    /**
     * Static method to instantiate the archive object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $archive
     * @param  string $password
     * @return \Pop\Archive\Archive
     */
    public static function factory($archive, $password = null)
    {
        return new self($archive, $password);
    }

    /**
     * Get formats
     *
     * @return array
     */
    public static function formats()
    {
        $allowed = array(
            'bz2'  => 'application/bzip2',
            'gz'   => 'application/x-gzip',
            'phar' => 'application/x-phar',
            'rar'  => 'application/x-rar-compressed',
            'tar'  => 'application/x-tar',
            'tbz'  => 'application/bzip2',
            'tbz2' => 'application/bzip2',
            'tgz'  => 'application/x-gzip',
            'zip'  => 'application/x-zip'
        );

        // Check if Bzip2 is available.
        if (!function_exists('bzcompress')) {
            unset($allowed['bz2']);
            unset($allowed['tbz']);
            unset($allowed['tbz2']);
        }
        // Check if Gzip is available.
        if (!function_exists('gzcompress')) {
            unset($allowed['gz']);
            unset($allowed['tgz']);
        }
        // Check if Phar is available.
        if (!class_exists('Phar', false)) {
            unset($allowed['phar']);
        }
        // Check if Rar is available.
        if (!class_exists('RarArchive', false)) {
            unset($allowed['rar']);
        }

        $tar = false;
        $includePath = explode(PATH_SEPARATOR, get_include_path());
        foreach ($includePath as $path) {
            if (file_exists($path . DIRECTORY_SEPARATOR . 'Archive' . DIRECTORY_SEPARATOR . 'Tar.php')) {
                $tar = true;
            }
        }

        // Check if Tar is available.
        if (!$tar) {
            unset($allowed['bz']);
            unset($allowed['bz2']);
            unset($allowed['gz']);
            unset($allowed['tar']);
            unset($allowed['tgz']);
            unset($allowed['tbz']);
            unset($allowed['tbz2']);
        }

        // Check if Zip is available.
        if (!class_exists('ZipArchive', false)) {
            unset($allowed['zip']);
        }

        return $allowed;
    }

    /**
     * Method to return the adapter object
     *
     * @return mixed
     */
    public function adapter()
    {
        return $this->adapter;
    }

    /**
     * Method to return the archive object within the adapter object
     *
     * @return mixed
     */
    public function archive()
    {
        return $this->adapter->archive();
    }

    /**
     * Method to extract an archived and/or compressed file
     *
     * @param  string $to
     * @return \Pop\Archive\Archive
     */
    public function extract($to = null)
    {
        $this->adapter->extract($to);
        return $this;
    }

    /**
     * Method to create an archive file
     *
     * @param  string|array $files
     * @return \Pop\Archive\Archive
     */
    public function addFiles($files)
    {
        $this->adapter->addFiles($files);
        self::__construct($this->fullpath);
        return $this;
    }

    /**
     * Method to return a listing of the contents of an archived file
     *
     * @param  boolean $full
     * @return array
     */
    public function listFiles($full = false)
    {
        return $this->adapter->listFiles($full);
    }

    /**
     * Method to compress an archive file with Gzip or Bzip2
     *
     * @param  string $ext
     * @return \Pop\Archive\Archive
     */
    public function compress($ext = 'gz')
    {
        if ($ext == 'bz') {
            $ext .= '2';
        }
        switch ($ext) {
            case 'gz':
                $newArchive = Compress\Gzip::compress($this->fullpath);
                break;
            case 'tgz':
                $tmpArchive = Compress\Gzip::compress($this->fullpath);
                $newArchive = str_replace('.tar.gz', '.tgz', $tmpArchive);
                rename($tmpArchive, $newArchive);
                break;
            case 'bz2':
                $newArchive = Compress\Bzip2::compress($this->fullpath);
                break;
            case 'tbz':
                $tmpArchive = Compress\Bzip2::compress($this->fullpath);
                $newArchive = str_replace('.tar.bz2', '.tbz', $tmpArchive);
                rename($tmpArchive, $newArchive);
                break;
            case 'tbz2':
                $tmpArchive = Compress\Bzip2::compress($this->fullpath);
                $newArchive = str_replace('.tar.bz2', '.tbz2', $tmpArchive);
                rename($tmpArchive, $newArchive);
                break;
            default:
                $newArchive = $this->fullpath;
        }

        if (file_exists($this->fullpath)) {
            unlink($this->fullpath);
        }

        self::__construct($newArchive);
        return $this;
    }

    /**
     * Method to set the adapter based on the file name
     *
     * @param  string $password
     * @param  string $prefix
     * @return void
     */
    protected function setAdapter($password = null, $prefix)
    {
        $ext = strtolower($this->ext);

        if (($ext == 'tar') || (stripos($ext, 'bz') !== false) || (stripos($ext, 'gz') !== false)) {
            $class = $prefix . 'Tar';
        } else {
            $class = $prefix . ucfirst($ext);
        }

        $this->adapter = (null !== $password) ? new $class($this, $password) : new $class($this);
    }

}
