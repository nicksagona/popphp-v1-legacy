<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_File
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\File;

/**
 * File directory class
 *
 * @category   Pop
 * @package    Pop_File
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Dir
{

    /**
     * The directory path
     * @var string
     */
    protected $path = null;

    /**
     * The files within the directory
     * @var array
     */
    protected $files = array();

    /**
     * The files within the directory as objects
     * @var array
     */
    protected $objects = array();

    /**
     * The nested tree map of the directory and its files
     * @var array
     */
    protected $tree = array();

    /**
     * Flag to store the full path.
     * @var boolean
     */
    protected $full = false;

    /**
     * Flag to dig recursively.
     * @var boolean
     */
    protected $rec = false;

    /**
     * Flag to include base sub directory listings or just the files.
     * @var boolean
     */
    protected $dirs = true;

    /**
     * Constructor
     *
     * Instantiate a directory object
     *
     * @param  string $dir
     * @param  boolean $full
     * @param  boolean $rec
     * @param  boolean $dirs
     * @throws \Pop\File\Exception
     * @return \Pop\File\Dir
     */
    public function __construct($dir, $full = false, $rec = false, $dirs = true)
    {
        // Check to see if the directory exists.
        if (!file_exists(dirname($dir))) {
            throw new Exception('Error: The directory does not exist.');
        }
        $this->tree[realpath($dir)] = $this->buildTree(new \DirectoryIterator($dir));
        $this->full = $full;
        $this->rec = $rec;
        $this->dirs = $dirs;

        // Set the directory path.
        if ((strpos($dir, '/') !== false) && (DIRECTORY_SEPARATOR != '/')) {
            $this->path = str_replace('/', "\\", $dir);
        } else if ((strpos($dir, "\\") !== false) && (DIRECTORY_SEPARATOR != "\\")) {
            $this->path = str_replace("\\", '/', $dir);
        } else {
            $this->path = $dir;
        }

        // Trim the trailing slash.
        if (strrpos($this->path, DIRECTORY_SEPARATOR) == (strlen($this->path) - 1)) {
            $this->path = substr($this->path, 0, -1);
        }

        // If the recursive flag is passed, traverse recursively.
        if ($this->rec) {
            $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path), \RecursiveIteratorIterator::SELF_FIRST);
            foreach ($objects as $fileInfo) {
                if (($fileInfo->getFilename() != '.') && ($fileInfo->getFilename() != '..')) {
                    // If full path flag was passed, store the full path.
                    if ($this->full) {
                        $f = null;
                        if ($this->dirs) {
                            $f = ($fileInfo->isDir()) ? (realpath($fileInfo->getPathname())) : realpath($fileInfo->getPathname());
                        } else if (!$fileInfo->isDir()) {
                            $f = realpath($fileInfo->getPathname());
                        }
                        if (null !== $f) {
                            $this->files[] = $f;
                            $this->objects[] = $f;
                        }
                    // Else, store only the directory or file name.
                    } else {
                        if ($this->dirs) {
                            $this->files[] = ($fileInfo->isDir()) ? ($fileInfo->getFilename()) : $fileInfo->getFilename();
                            $this->objects[] = ($fileInfo->isDir()) ? (realpath($fileInfo->getPathname())) : realpath($fileInfo->getPathname());
                        } else if (!$fileInfo->isDir()) {
                            $this->files[] = $fileInfo->getFilename();
                            $this->objects[] = realpath($fileInfo->getPathname());
                        }
                    }
                }
            }
        // Else, only traverse the single directory that was passed.
        } else {
            foreach (new \DirectoryIterator($this->path) as $fileInfo) {
                if(!$fileInfo->isDot()) {
                    // If full path flag was passed, store the full path.
                    if ($this->full) {
                        if ($this->dirs) {
                            $f = ($fileInfo->isDir()) ? ($this->path . DIRECTORY_SEPARATOR . $fileInfo->getFilename() . DIRECTORY_SEPARATOR) : ($this->path . DIRECTORY_SEPARATOR . $fileInfo->getFilename());
                        } else if (!$fileInfo->isDir()) {
                            $f = $this->path . DIRECTORY_SEPARATOR . $fileInfo->getFilename();
                        }
                        $this->files[] = $f;
                        $this->objects[] = $f;
                    // Else, store only the directory or file name.
                    } else {
                        if ($this->dirs) {
                            $this->files[] = ($fileInfo->isDir()) ? ($fileInfo->getFilename()) : $fileInfo->getFilename();
                            $this->objects[] = ($fileInfo->isDir()) ? ($this->path . DIRECTORY_SEPARATOR . $fileInfo->getFilename() . DIRECTORY_SEPARATOR) : ($this->path . DIRECTORY_SEPARATOR . $fileInfo->getFilename());
                        } else if (!$fileInfo->isDir()) {
                            $this->files[] = $fileInfo->getFilename();
                            $this->objects[] = $this->path . DIRECTORY_SEPARATOR . $fileInfo->getFilename();
                        }
                    }
                }
            }
        }
    }

    /**
     * Is dir object.
     *
     * @return boolean
     */
    public function isDir()
    {
        return true;
    }

    /**
     * Is file object.
     *
     * @return boolean
     */
    public function isFile()
    {
        return false;
    }

    /**
     * Static method to return the system temp directory.
     *
     * @return string
     */
    public static function getSystemTemp()
    {
        $sysTemp = null;

        if (isset($_ENV['TMP']) && !empty($_ENV['TMP'])) {
            $sysTemp = $_ENV['TMP'];
        } else if (isset($_ENV['TEMP']) && !empty($_ENV['TEMP'])) {
            $sysTemp = $_ENV['TEMP'];
        } else if (isset($_ENV['TMPDIR']) && !empty($_ENV['TMPDIR'])) {
            $sysTemp = $_ENV['TMPDIR'];
        } else {
            $sysTemp = sys_get_temp_dir();
        }

        return realpath($sysTemp);
    }

    /**
     * Static method to return the upload temp directory.
     *
     * @return string
     */
    public static function getUploadTemp()
    {
        return (ini_get('upload_tmp_dir') == '') ? self::getSystemTemp() : realpath(ini_get('upload_tmp_dir'));
    }

    /**
     * Get the path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the files.
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Get the files as objects.
     *
     * @return array
     */
    public function getObjects()
    {
        if (isset($this->objects[0]) && is_string($this->objects[0])) {
            $objects = array();

            foreach ($this->objects as $object) {
                $objects[] = (is_dir($object)) ? new self($object, true, true) : new File($object, array());
            }

            $this->objects = $objects;
        }

        return $this->objects;
    }

    /**
     * Get the tree.
     *
     * @return array
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * Get the permissions of the directory.
     *
     * @return string
     */
    public function getPermissions()
    {
        return (DIRECTORY_SEPARATOR == '/') ?
            substr(sprintf('%o', fileperms($this->path)), -3) :
            null;
    }

    /**
     * Change the permissions of the directory.
     *
     * @param  int $mode
     * @return \Pop\File\Dir
     */
    public function setPermissions($mode)
    {
        if (file_exists($this->path)) {
            if (is_numeric($mode) && (strlen($mode) == 3)) {
                $mode = '0' . $mode;
            }
            chmod($this->path, $mode);
            clearstatcache();
            self::__construct($this->path, $this->full, $this->rec);
        }

        return $this;
    }

    /**
     * Get the owner of the file. Works on POSIX file systems only
     *
     * @return array
     */
    public function getOwner()
    {
        $owner = array();
        if (DIRECTORY_SEPARATOR == '/') {
            if (file_exists($this->path)) {
                $owner = posix_getpwuid(fileowner($this->path));
            }
        }

        return $owner;
    }

    /**
     * Get the owner of the file. Works on POSIX file systems only
     *
     * @return array
     */
    public function getGroup()
    {
        $group = array();
        if (DIRECTORY_SEPARATOR == '/') {
            if (file_exists($this->path)) {
                $group = posix_getgrgid(filegroup($this->path));
            }
        }

        return $group;
    }

    /**
     * Get current user. Works on POSIX file systems only
     *
     * @return array
     */
    public function getUser()
    {
        $me = array();
        if (DIRECTORY_SEPARATOR == '/') {
            $me = posix_getpwuid(posix_geteuid());
        }

        return $me;
    }

    /**
     * Empty an entire directory.
     *
     * @param  string  $path
     * @param  boolean $del
     * @return void
     */
    public function emptyDir($path = null, $del = false)
    {
        if (null === $path) {
            $path = $this->path;
        }

        // Get a directory handle.
        if (!$dh = @opendir($path)) {
            return;
        }

        // Recursively dig through the directory, deleting files where applicable.
        while (false !== ($obj = readdir($dh))) {
            if ($obj == '.' || $obj == '..') {
                continue;
            }
            if (!@unlink($path . '/' . $obj)) {
                $this->emptyDir($path . '/' . $obj, true);
            }
        }

        // Close the directory handle.
        closedir($dh);

        // If the delete flag was passed, remove the top level directory.
        if ($del) {
            @rmdir($path);
        }
    }

    /**
     * Empty an entire directory.
     *
     * @param  \DirectoryIterator  $it
     * @return array
     */
    protected function buildTree(\DirectoryIterator $it)
    {
        $result = array();

        foreach ($it as $key => $child) {
            if ($child->isDot()) {
                continue;
            }

            $name = $child->getBasename();

            if ($child->isDir()) {
                $subit = new \DirectoryIterator($child->getPathname());
                $result[DIRECTORY_SEPARATOR . $name] = $this->buildTree($subit);
            } else {
                $result[] = $name;
            }
        }

        return $result;
    }

}
