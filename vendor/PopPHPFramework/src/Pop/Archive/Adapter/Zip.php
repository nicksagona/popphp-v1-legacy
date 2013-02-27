<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Archive\Adapter;

use Pop\File\Dir;

/**
 * Zip archive adapter class
 *
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.2
 */
class Zip implements ArchiveInterface
{

    /**
     * ZipArchive object
     * @var \ZipArchive
     */
    protected $archive = null;

    /**
     * Archive path
     * @var string
     */
    protected $path = null;

    /**
     * Working directory
     * @var string
     */
    protected $workingDir = null;

    /**
     * Method to instantiate an archive adapter object
     *
     * @param  \Pop\Archive\Archive $archive
     * @return \Pop\Archive\Adapter\Zip
     */
    public function __construct(\Pop\Archive\Archive $archive)
    {
        if (strpos($archive->getFullpath(), '/.') !== false) {
            $this->workingDir = substr($archive->getFullpath(), 0, strpos($archive->getFullpath(), '/.'));
        } else if (strpos($archive->getFullpath(), '\\.') !== false) {
            $this->workingDir = substr($archive->getFullpath(), 0, strpos($archive->getFullpath(), '\\.'));
        } else {
            $this->workingDir = getcwd();
        }

        if ((substr($archive->getFullpath(), 0, 1) != '/') && (substr($archive->getFullpath(), 1, 1) != ':')) {
            $this->path = $this->workingDir . DIRECTORY_SEPARATOR . $archive->getFullpath();
        } else {
            $this->path = realpath(dirname($archive->getFullpath())) . DIRECTORY_SEPARATOR . $archive->getBasename();
        }
        $this->archive = new \ZipArchive();
    }

    /**
     * Method to return the archive object
     *
     * @return mixed
     */
    public function archive()
    {
        return $this->archive;
    }

    /**
     * Method to extract an archived and/or compressed file
     *
     * @param  string $to
     * @return void
     */
    public function extract($to = null)
    {
        if ($this->archive->open($this->path) === true) {
            $path = (null !== $to) ? realpath($to) : './';
            $this->archive->extractTo($path);
            $this->archive->close();
        }
    }

    /**
     * Method to create an archive file
     *
     * @param  string|array $files
     * @return void
     */
    public function addFiles($files)
    {
        // Create a usable array of files
        if (!is_array($files)) {
            if (is_dir($files)) {
                $dir = new Dir($files, true, true, false);
                $files = $this->filterDirFiles($dir->getFiles(), $files);
            } else {
                $files = $this->filterDirFiles(array(realpath($files)), dirname($files));
            }
        } else {
            $allFiles = array();
            foreach ($files as $key => $value) {
                if (is_dir($value)) {
                    $dir = new Dir($value, true, true, false);
                    $allFiles = array_merge($allFiles, $this->filterDirFiles($dir->getFiles(), $value));
                    unset($files[$key]);
                } else {
                    $allFiles = array_merge($allFiles, $this->filterDirFiles(array(realpath($value)), dirname($value)));
                    unset($files[$key]);
                }
            }
            $files = array_merge($files, $allFiles);
        }

        if (!file_exists($this->path)) {
            $result = $this->archive->open($this->path, \ZipArchive::CREATE);
            $dirs = array();
        } else {
            $result = $this->archive->open($this->path);
            $dirs = $this->getDirs();
        }

        if ($result === true) {
            // Directory separator clean up
            $search = array('\\', '../', './');
            $replace = array('/', '', '');

            foreach ($files as $file) {
                if ((substr($file, 0, 1) == '/') || (substr($file, 1, 1) == ':')) {
                    $realfile = $file;
                } else {
                    $realfile = realpath($this->workingDir . DIRECTORY_SEPARATOR . $file);
                }
                $name = basename($file);
                $dir = str_replace($search, $replace, (str_replace($name, '', $file)));
                if (($dir != '') && (!in_array($dir, $dirs))) {
                    $newDirs = explode('/', substr($dir, 0, -1));
                    $curDir = null;
                    for ($i = 0; $i < count($newDirs); $i++) {
                        if ($i == 0) {
                            $this->archive->addEmptyDir($newDirs[$i]);
                        } else {
                            $this->archive->addEmptyDir($curDir . $newDirs[$i]);
                        }
                        $curDir .= $newDirs[$i] . '/';
                        $dirs[] = $curDir;
                    }
                    $name = $dir . $name;
                } else {
                    $name = $dir . $name;
                }
                $this->archive->addFile($realfile, $name);
            }

            $this->archive->close();
        }
    }

    /**
     * Method to return a listing of the contents of an archived file
     *
     * @param  boolean $full
     * @return array
     */
    public function listFiles($full = false)
    {
        $files = array();
        $list = array();

        if ($this->archive->open($this->path) === true) {
            $i = 0;
            while ($this->archive->statIndex($i)) {
                $list[] = $this->archive->statIndex($i);
                $i++;
            }
        }

        if (!$full) {
            foreach ($list as $file) {
                $files[] = $file['name'];
            }
        } else {
            $files = $list;
        }

        return $files;
    }

    /**
     * Method to return an array of all the directories in the archive
     *
     * @return array
     */
    protected function getDirs()
    {
        $dirs = array();

        $list = $this->listFiles(true);

        foreach ($list as $entry) {
            if ($entry['size'] == 0) {
                $dirs[] = $entry['name'];
            }
        }

        return $dirs;
    }

    /**
     * Method to return an array of all the directories in the archive
     *
     * @param  array  $dirFiles
     * @param  string $dir
     * @return array
     */
    protected function filterDirFiles($dirFiles, $dir)
    {
        if (strpos($dir, '../') !== false) {
            $origDir = substr($dir, strpos($dir, '../'));
            $dir = realpath($dir);
        } else if (strpos($dir, './') !== false) {
            $origDir = substr($dir, strpos($dir, './'));
            $dir = realpath($dir);
        } else {
            $origDir = $dir;
        }

        $search = array('\\', '../', './');
        $replace = array('/', '', '');

        $dir = str_replace($search, $replace, $dir);
        $files = array();

        foreach ($dirFiles as $file) {
            $f = str_replace('\\', '/', substr($file, strpos($file, $dir)));
            $files[] = str_replace($dir, $origDir, $f);
        }

        return $files;
    }

}
