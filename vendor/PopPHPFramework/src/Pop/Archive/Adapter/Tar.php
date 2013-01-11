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

use Pop\Compress,
    Pop\File\Dir;

/**
 * This is the Tar class for the Archive component.
 *
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
class Tar implements \Pop\Archive\ArchiveInterface
{

    /**
     * Archive_Tar object
     * @var \Archive_Tar
     */
    public $archive = null;

    /**
     * Archive path
     * @var string
     */
    protected $path = null;

    /**
     * Archive compression
     * @var string
     */
    protected $compression = null;

    /**
     * Method to instantiate an archive adapter object
     *
     * @param  \Pop\Archive\Archive $archive
     * @return \Pop\Archive\Adapter\Tar
     */
    public function __construct($archive)
    {
        if (stripos($archive->getExt(), 'bz') !== false) {
            $this->compression = 'bz';
        } else if (stripos($archive->getExt(), 'gz') !== false) {
            $this->compression = 'gz';
        }
        $this->path = $archive->getFullpath();
        $this->archive = new \Archive_Tar($this->path);
    }

    /**
     * Method to extract an archived and/or compressed file
     *
     * @param  string $to
     * @return void
     */
    public function extract($to = null)
    {
        if ($this->compression == 'bz') {
            $this->path = Compress\Bzip2::decompress($this->path);
            $this->archive = new \Archive_Tar($this->path);
        } else if ($this->compression == 'gz') {
            $this->path = Compress\Gzip::decompress($this->path);
            $this->archive = new \Archive_Tar($this->path);
        }
        $this->archive->extract((null !== $to) ? $to : './');
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

        foreach ($files as $file) {
            // If file is a directory, loop through and add the files.
            if (file_exists($file) && is_dir($file)) {
                $dir = new Dir($file, true, true);
                $dirFiles = $dir->getFiles();
                foreach ($dirFiles as $fle) {
                    if (file_exists($fle) && !is_dir($fle)) {
                        $this->archive->add($fle);
                    }
                }
            // Else, just add the file.
            } else if (file_exists($file)) {
                $this->archive->add($file);
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
        $files = array();
        $list = $this->archive->listContent();

        if (!$full) {
            foreach ($list as $file) {
                $files[] = $file['filename'];
            }
        } else {
            $files = $list;
        }

        return $files;
    }

}
