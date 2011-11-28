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
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */

/**
 * @namespace
 */
namespace Pop\Archive;
use Pop\Dir\Dir,
    Pop\Filter\StringFilter;

class Zip
{

    /**
     * Method to extract an archived file using Zip
     *
     * @param  Pop_Archive $archive
     * @param  string        $to
     * @return int
     */
    public function extract($archive, $to = null)
    {
        $zip = new \ZipArchive();

        if ($zip->open($archive->fullpath) === true) {
            $zip->extractTo((null !== $to) ? $to : './');
            $zip->close();
        }

        return -1;
    }

    /**
     * Method to create an archived and/or compressed file using Zip
     *
     * @param  Pop_Archive $archive
     * @param  string|array $files
     * @return mixed
     */
    public function add($archive, $files)
    {
        if (!is_array($files)) {
            $files = array($files);
        }

        $zip = new \ZipArchive();

        if ($zip->open($archive->fullpath, \ZipArchive::CREATE) === true) {
            foreach ($files as $file) {
                // If file is a directory, loop through and add the files.
                if (file_exists($file) && is_dir($file)) {
                    $dir = new Dir($file, true, true);
                    $zip->addEmptyDir((string)StringFilter::factory($dir->path)->replace('\\', '/')->replace('./', ''));
                    foreach ($dir->files as $fle) {
                        if (file_exists($fle) && is_dir($fle)) {
                            $zip->addEmptyDir((string)StringFilter::factory($fle)->replace('\\', '/')->replace('./', ''));
                        } else if (file_exists($fle)) {
                            $zip->addFile($fle, (string)StringFilter::factory($fle)->replace('\\', '/')->replace('./', ''));
                        }
                    }
                // Else, just add the file.
                } else if (file_exists($file)) {
                    $zip->addFile($file, str_replace('\\', '/', $file));
                }
            }
            $zip->close();
        }
    }

    /**
     * Method to list contents of a Zip archive
     *
     * @param  Pop_Archive $archive
     * @param  boolean       $all
     * @return array
     */
    public function listFiles($archive, $all = false)
    {
        $files = array();
        $list = array();
        $zip = new \ZipArchive();

        if ($zip->open($archive->fullpath) === true) {
            $i = 0;
            while ($zip->statIndex($i)) {
                $list[] = $zip->statIndex($i);
                $i++;
            }
        }

        if (!$all) {
            foreach ($list as $file) {
                $files[] = $file['name'];
            }
        } else {
            $files = $list;
        }

        return $files;
    }

}
