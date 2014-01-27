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
 * File class
 *
 * @category   Pop
 * @package    Pop_File
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class File
{
    /**
     * Full path and name of the file, i.e. '/some/dir/file.ext'
     * @var string
     */
    protected $fullpath = null;

    /**
     * Full, absolute directory of file, i.e. '/some/dir/'
     * @var string
     */
    protected $dir = null;

    /**
     * Full basename of file, i.e. 'file.ext'
     * @var string
     */
    protected $basename = null;

    /**
     * Full filename of file, i.e. 'file'
     * @var string
     */
    protected $filename = null;

    /**
     * File extension, i.e. 'ext'
     * @var string
     */
    protected $ext = null;

    /**
     * File size in bytes
     * @var int
     */
    protected $size = 0;

    /**
     * File mime type
     * @var string
     */
    protected $mime = null;

    /**
     * File output data.
     * @var string
     */
    protected $output = null;

    /**
     * Array of allowed file types.
     * @var array
     */
    protected $allowed = array(
        'afm'    => 'application/x-font-afm',
        'ai'     => 'application/postscript',
        'aif'    => 'audio/x-aiff',
        'aiff'   => 'audio/x-aiff',
        'avi'    => 'video/x-msvideo',
        'bmp'    => 'image/x-ms-bmp',
        'bz2'    => 'application/bzip2',
        'css'    => 'text/css',
        'csv'    => 'text/csv',
        'doc'    => 'application/msword',
        'docx'   => 'application/msword',
        'eps'    => 'application/octet-stream',
        'fla'    => 'application/octet-stream',
        'flv'    => 'application/octet-stream',
        'gif'    => 'image/gif',
        'gz'     => 'application/x-gzip',
        'html'   => 'text/html',
        'htm'    => 'text/html',
        'jpe'    => 'image/jpeg',
        'jpg'    => 'image/jpeg',
        'jpeg'   => 'image/jpeg',
        'js'     => 'text/plain',
        'json'   => 'text/plain',
        'log'    => 'text/plain',
        'md'     => 'text/plain',
        'mov'    => 'video/quicktime',
        'mp2'    => 'audio/mpeg',
        'mp3'    => 'audio/mpeg',
        'mp4'    => 'video/mp4',
        'mpg'    => 'video/mpeg',
        'mpeg'   => 'video/mpeg',
        'otf'    => 'application/x-font-otf',
        'pdf'    => 'application/pdf',
        'pfb'    => 'application/x-font-pfb',
        'pfm'    => 'application/x-font-pfm',
        'pgsql'  => 'text/plain',
        'phar'   => 'application/x-phar',
        'php'    => 'text/plain',
        'php3'   => 'text/plain',
        'phtml'  => 'text/plain',
        'png'    => 'image/png',
        'ppt'    => 'application/msword',
        'pptx'   => 'application/msword',
        'psb'    => 'image/x-photoshop',
        'psd'    => 'image/x-photoshop',
        'rar'    => 'application/x-rar-compressed',
        'shtml'  => 'text/html',
        'shtm'   => 'text/html',
        'sit'    => 'application/x-stuffit',
        'sitx'   => 'application/x-stuffit',
        'sql'    => 'text/plain',
        'sqlite' => 'application/octet-stream',
        'svg'    => 'image/svg+xml',
        'swf'    => 'application/x-shockwave-flash',
        'tar'    => 'application/x-tar',
        'tbz'    => 'application/bzip2',
        'tbz2'   => 'application/bzip2',
        'tgz'    => 'application/x-gzip',
        'tif'    => 'image/tiff',
        'tiff'   => 'image/tiff',
        'tsv'    => 'text/tsv',
        'ttf'    => 'application/x-font-ttf',
        'txt'    => 'text/plain',
        'wav'    => 'audio/x-wav',
        'wma'    => 'audio/x-ms-wma',
        'wmv'    => 'audio/x-ms-wmv',
        'xls'    => 'application/msword',
        'xlsx'   => 'application/msword',
        'xhtml'  => 'application/xhtml+xml',
        'xml'    => 'application/xml',
        'yaml'   => 'text/plain',
        'yml'    => 'text/plain',
        'zip'    => 'application/x-zip'
    );

    /**
     * Constructor
     *
     * Instantiate the file object, either from a file on disk or as a new file.
     *
     * @param  string $file
     * @param  array  $types
     * @return \Pop\File\File
     */
    public function __construct($file, $types = null)
    {
        $this->setFile($file, $types);
    }

    /**
     * Static method to upload a file and return a file object.
     *
     * @param  string $upload
     * @param  string $file
     * @param  int    $size
     * @param  array  $types
     * @throws Exception
     * @return \Pop\File\File
     */
    public static function upload($upload, $file, $size = 0, $types = null)
    {
        // Check to see if the upload directory exists.
        if (!file_exists(dirname($file))) {
            throw new Exception('Error: The upload directory does not exist.');
        }

        // Check to see if the permissions are set correctly.
        if (!is_writable(dirname($file))) {
            throw new Exception('Error: Permission denied. The upload directory is not writable.');
        }

        // Move the uploaded file, creating a file object with it.
        if (move_uploaded_file($upload, $file)) {
            $fileSize = filesize($file);

            // Check the file size requirement.
            if (((int)$size > 0) && ($fileSize > $size)) {
                unlink($file);
                throw new Exception('Error: The file uploaded is too big.');
            }

            try {
                $fileObj = new static($file, $types);
                return $fileObj;
            } catch (Exception $e) {
                unlink($file);
                throw $e;
            }
        } else {
            throw new Exception('Error: There was an error in uploading the file.');
        }
    }

    /**
     * Static method to check for a duplicate file, returning
     * the next incremented filename, i.e. filename_1.txt
     *
     * @param  string $file
     * @param  string $dir
     * @return string
     */
    public static function checkDupe($file, $dir = null)
    {
        if (null === $dir) {
            $dir = getcwd();
        }

        $newFilename = $file;
        $parts = pathinfo($file);
        $origFilename = $parts['filename'];
        $ext = (isset($parts['extension']) && ($parts['extension'] != '')) ? '.' . $parts['extension'] : null;

        $i = 1;

        while (file_exists($dir . DIRECTORY_SEPARATOR . $newFilename)) {
            $newFilename = $origFilename . '_' . $i . $ext;
            $i++;
        }

        return $newFilename;
    }

    /**
     * Is dir object.
     *
     * @return boolean
     */
    public function isDir()
    {
        return false;
    }

    /**
     * Is file object.
     *
     * @return boolean
     */
    public function isFile()
    {
        return true;
    }

    /**
     * Test if a certain file type is allowed.
     *
     * @param  string $type
     * @return boolean
     */
    public function isAllowed($type)
    {
        return (array_key_exists(strtolower($type), $this->allowed));
    }

    /**
     * Get the fullpath.
     *
     * @return string
     */
    public function getFullpath()
    {
        return $this->fullpath;
    }

    /**
     * Get the directory.
     *
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * Get the basename.
     *
     * @return string
     */
    public function getBasename()
    {
        return $this->basename;
    }

    /**
     * Get the filename.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Get the extension.
     *
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * Get the current file size.
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Get the current file mime type.
     *
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * Set the file mime type.
     *
     * @param  string $mime
     * @throws Exception
     * @return \Pop\File\File
     */
    public function setMime($mime)
    {
        if ((count($this->allowed) > 0) && !in_array($mime, $this->allowed)) {
            throw new Exception('Error: The file mime type ' . $mime . ' is not an accepted file mime type.');
        }
        $this->mime = $mime;
        return $this;
    }

    /**
     * Get the current allowed files types.
     *
     * @return array
     */
    public function getAllowedTypes()
    {
        return $this->allowed;
    }

    /**
     * Set the allowed files types, overriding any previously allowed types.
     *
     * @param  array $types
     * @return void
     */
    public function setAllowedTypes($types = null)
    {
        $this->allowed = array();
        $ary = ((null === $types) || !is_array($types)) ? array() : $types;
        $this->addAllowedTypes($ary);
    }

    /**
     * Set the allowed files types.
     *
     * @param  array $types
     * @return void
     */
    public function addAllowedTypes(array $types)
    {
        foreach ($types as $key => $value) {
            $this->allowed[$key] = $value;
        }
    }

    /**
     * Change the permissions of the file.
     *
     * @param  mixed    $mode
     * @return \Pop\File\File
     */
    public function setPermissions($mode)
    {
        if (file_exists($this->fullpath)) {
            chmod($this->fullpath, $mode);
            clearstatcache();
        }
        return $this;
    }

    /**
     * Change the permissions of the directory the file is in.
     *
     * @param  mixed    $mode
     * @return \Pop\File\File
     */
    public function setDirPermissions($mode)
    {
        if (file_exists($this->dir)) {
            chmod($this->dir, $mode);
            clearstatcache();
        }
        return $this;
    }

    /**
     * Get the permissions of the file.
     *
     * @return string
     */
    public function getPermissions()
    {
        return (DIRECTORY_SEPARATOR == '/') ?
            substr(sprintf('%o', fileperms($this->fullpath)), -3) :
            null;
    }

    /**
     * Get the permissions of the directory the file is in.
     *
     * @return string
     */
    public function getDirPermissions()
    {
        return (DIRECTORY_SEPARATOR == '/') ?
            substr(sprintf('%o', fileperms($this->dir)), -3) :
            null;
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
            $owner = (file_exists($this->fullpath)) ?
                posix_getpwuid(fileowner($this->fullpath)) :
                $this->getUser();
        }

        return $owner;
    }

    /**
     * Get the owner of the file. Works on POSIX file systems only
     *
     * @return array
     */
    public function getDirOwner()
    {
        $owner = array();
        if (DIRECTORY_SEPARATOR == '/') {
            $owner = (file_exists($this->dir)) ?
                posix_getpwuid(fileowner($this->dir)) :
                $this->getUser();
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
            if (file_exists($this->fullpath)) {
                $group = posix_getgrgid(filegroup($this->fullpath));
            }
        }

        return $group;
    }

    /**
     * Get the owner of the file. Works on POSIX file systems only
     *
     * @return array
     */
    public function getDirGroup()
    {
        $group = array();
        if (DIRECTORY_SEPARATOR == '/') {
            if (file_exists($this->dir)) {
                $group = posix_getgrgid(filegroup($this->dir));
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
     * Read data from a file.
     *
     * @param  int|string $off
     * @param  int|string $len
     * @return string
     */
    public function read($off = null, $len = null)
    {
        $data = null;

        // Read from the output buffer
        if (null !== $this->output) {
            if (null !== $off) {
                $data = (null !== $len) ? substr($this->output, $off, $len) : substr($this->output, $off);
            } else {
                $data = $this->output;
            }
        // Else, if the file exists, then read the data from the actual file
        } else if (file_exists($this->fullpath)) {
            if (null !== $off) {
                $data = (null !== $len) ?
                    file_get_contents($this->fullpath, null, null, $off, $len) :
                    $this->output = file_get_contents($this->fullpath, null, null, $off);
            } else {
                $data = file_get_contents($this->fullpath);
            }
        }

        return $data;
    }

    /**
     * Write data to a file.
     *
     * @param  string  $data
     * @param  boolean $append
     * @return \Pop\File\File
     */
    public function write($data, $append = false)
    {
        // If the file is to be appended.
        if ($append) {
            if ((null === $this->output) && file_exists($this->fullpath)) {
                $this->output = file_get_contents($this->fullpath);
            }
            $this->output .= $data;
        //Else, overwrite the file contents.
        } else {
            $this->output = $data;
        }

        return $this;
    }

    /**
     * Append data to a file.
     *
     * @param  string  $data
     * @return \Pop\File\File
     */
    public function append($data)
    {
        return $this->write($data, true);
    }

    /**
     * Copy the file object directly to another file on disk.
     *
     * @param  string  $new
     * @param  boolean $overwrite
     * @throws Exception
     * @return \Pop\File\File
     */
    public function copy($new, $overwrite = false)
    {
        // Check to see if the new file already exists.
        if (file_exists($new) && (!$overwrite)) {
            throw new Exception('Error: The file already exists.');
        }

        if (file_exists($this->fullpath)) {
            copy($this->fullpath, $new);
        } else {
            file_put_contents($new, $this->output);
        }
        $this->setFile($new);

        return $this;
    }

    /**
     * Move the file object directly to another location on disk.
     *
     * @param  string $new
     * @param  boolean $overwrite
     * @throws Exception
     * @return \Pop\File\File
     */
    public function move($new, $overwrite = false)
    {
        // Check to see if the new file already exists.
        if (file_exists($new) && (!$overwrite)) {
            throw new Exception('Error: The file already exists.');
        }

        if (file_exists($this->fullpath)) {
            rename($this->fullpath, $new);
        } else {
            file_put_contents($new, $this->output);
        }
        $this->setFile($new);

        return $this;
    }

    /**
     * Output the file object directly.
     *
     * @param  boolean $download
     * @return \Pop\File\File
     */
    public function output($download = false)
    {
        // Determine if the force download argument has been passed.
        $attach = ($download) ? 'attachment; ' : null;
        $headers = array(
            'Content-type' => $this->mime,
            'Content-disposition' => $attach . 'filename=' . $this->basename
        );

        $response = new \Pop\Http\Response(200, $headers, $this->read());

        if (isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] == 443)) {
            $response->setSslHeaders();
        }

        $response->send();

        return $this;
    }

    /**
     * Save the file object to disk.
     *
     * @param  string $to
     * @param  boolean $append
     * @return \Pop\File\File
     */
    public function save($to = null, $append = false)
    {
        $file = (null === $to) ? $this->fullpath : $to;

        if ($append) {
            file_put_contents($file, $this->read(), FILE_APPEND);
        } else {
            file_put_contents($file, $this->read());
        }

        $this->setFile($this->fullpath, $this->allowed);
        return $this;
    }

    /**
     * Delete the file object directly from disk.
     *
     * @throws Exception
     * @return void
     */
    public function delete()
    {
        // Check to make sure the file exists.
        if (file_exists($this->fullpath)) {
            unlink($this->fullpath);

            // Reset file object properties.
            $props = get_class_vars(get_class($this));

            foreach (array_keys($props) as $key) {
                $this->{$key} = null;
            }
        }
    }

    /**
     * Set the file and its properties.
     *
     * @param  string $file
     * @param  array  $types
     * @throws Exception
     * @return void
     */
    protected function setFile($file, $types = null)
    {
        // Set file object properties.
        $file_parts = pathinfo($file);

        if (null !== $types) {
            $this->allowed = $types;
        }

        $this->fullpath = $file;
        $this->dir = $file_parts['dirname'];
        $this->basename = $file_parts['basename'];
        $this->filename = $file_parts['filename'];
        $this->ext = (isset($file_parts['extension'])) ? $file_parts['extension'] : null;

        // Check if the file exists, and set the size and permissions accordingly.
        if (file_exists($file)) {
            if (is_dir($file)) {
                throw new Exception('The file passed is a directory.');
            }
            $this->size = filesize($file);
        } else {
            $this->size = 0;
        }

        // Check to see if the file is an accepted file format.
        if ((null !== $this->allowed) && (null !== $this->ext) && (count($this->allowed) > 0) && (!array_key_exists(strtolower($this->ext), $this->allowed))) {
            throw new Exception('Error: The file type ' . strtoupper($this->ext) . ' is not an accepted file format.');
        }

        // Set the mime type of the file.
        $this->mime = ((null !== $this->ext) && (count($this->allowed) > 0) && (null !== $this->allowed)) ?
            $this->allowed[strtolower($this->ext)] :
            'text/plain';
    }

}
