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
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Archive\Adapter;

use Pop\File\Dir;

/**
 * This is the Phar class for the Archive component.
 *
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
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
    public function __construct($archive)
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
