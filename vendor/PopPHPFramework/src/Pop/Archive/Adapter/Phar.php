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
namespace Pop\Archive\Adapter;

use Pop\File\Dir;

/**
 * Phar archive adapter class
 *
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Phar implements ArchiveInterface
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
     * Method to instantiate an archive adapter object
     *
     * @param  \Pop\Archive\Archive $archive
     * @return \Pop\Archive\Adapter\Phar
     */
    public function __construct(\Pop\Archive\Archive $archive)
    {
        $this->path = $archive->getFullpath();
        $this->archive = new \Phar($this->path);
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
        $this->archive->extractTo((null !== $to) ? $to : './');
    }

    /**
     * Method to create an archive file
     *
     * @param  string|array $files
     * @return void
     */
    public function addFiles($files)
    {
        if (!is_array($files)) {
            $files = array($files);
        }

        // Directory separator clean up
        $search = array('\\', '../', './');
        $replace = array('/', '', '');

        foreach ($files as $file) {
            // If file is a directory, loop through and add the files.
            if (file_exists($file) && is_dir($file)) {
                $dir = new Dir($file, true, true);
                $this->archive->addEmptyDir(str_replace($search, $replace, $dir->getPath()));
                $dirFiles = $dir->getFiles();
                foreach ($dirFiles as $fle) {
                    if (file_exists($fle) && is_dir($fle)) {
                        $this->archive->addEmptyDir(str_replace($search, $replace, $fle));
                    } else if (file_exists($fle)) {
                        $this->archive->addFile($fle, str_replace($search, $replace, $fle));
                    }
                }
            // Else, just add the file.
            } else if (file_exists($file)) {
                $this->archive->addFile($file, str_replace('\\', '/', $file));
            }
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
        $list = array();

        foreach ($this->archive as $file) {
            if ($file->isDir()) {
                $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator((string)$file), \RecursiveIteratorIterator::SELF_FIRST);
                foreach ($objects as $fileInfo) {
                    if (($fileInfo->getFilename() != '.') && ($fileInfo->getFilename() != '..')) {
                        $f = ($fileInfo->isDir()) ? ($fileInfo->getPathname() . DIRECTORY_SEPARATOR) : $fileInfo->getPathname();
                        if (!$full) {
                            $list[] = substr($f, (stripos($f, '.phar') + 6));
                        } else {
                            $f = $fileInfo->getPath() . DIRECTORY_SEPARATOR . $fileInfo->getFilename();
                            $list[] = array(
                                'name'  => substr($f, (stripos($f, '.phar') + 6)),
                                'mtime' => $fileInfo->getMTime(),
                                'size'  => $fileInfo->getSize()
                            );
                        }
                    }
                }
            } else {
                $f = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
                if (!$full) {
                    $list[] = substr($f, (stripos($f, '.phar') + 6));
                } else {
                    $list[] = array(
                        'name'  => substr($f, (stripos($f, '.phar') + 6)),
                        'mtime' => $file->getMTime(),
                        'size'  => $file->getSize()
                    );
                }
            }
        }

        return $list;
    }

}
