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
namespace Pop\Archive\Adapter;

use Pop\Archive\ArchiveInterface,
    Pop\Dir\Dir,
    Pop\File\File,
    Pop\Filter\String;

/**
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Zip implements ArchiveInterface
{

    /**
     * ZipArchive object
     * @var ZipArchive
     */
    public $archive = null;

    /**
     * Archive path
     * @var string
     */
    protected $path = null;

    /**
     * Method to instantiate an archive adapter object
     *
     * @param  Pop\Archive\Archive $archive
     * @return void
     */
    public function __construct($archive)
    {
        $this->path = $archive->fullpath;
        $this->archive = new \ZipArchive();
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
        if (!is_array($files)) {
            $files = array($files);
        }

        if (!file_exists($this->path)) {
            $result = $this->archive->open($this->path, \ZipArchive::CREATE);
        } else {
            $result = $this->archive->open($this->path);
        }

        if ($result === true) {
            // Directory separator clean up
            $seps = array(
                array('\\', '/'),
                array('../', ''),
                array('./', '')
            );

            foreach ($files as $file) {
                // If file is a directory, loop through and add the files.
                if (file_exists($file) && is_dir($file)) {
                    $dir = new Dir($file, true, true);
                    $this->archive->addEmptyDir((string)String::factory($dir->path)->replace($seps));
                    foreach ($dir->files as $fle) {
                        if (file_exists($fle) && is_dir($fle)) {
                            $this->archive->addEmptyDir((string)String::factory($fle)->replace($seps));
                        } else if (file_exists($fle)) {
                            $this->archive->addFile($fle, (string)String::factory($fle)->replace($seps));
                        }
                    }
                // Else, just add the file.
                } else if (file_exists($file)) {
                    $this->archive->addFile($file, str_replace('\\', '/', $file));
                }
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

}
