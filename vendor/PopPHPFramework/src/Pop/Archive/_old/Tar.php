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

use Pop\Dir\Dir;

/**
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Tar
{

    /**
     * Method to extract an archived file using Tar
     *
     * @param  Pop_Archive $archive
     * @param  string        $to
     * @return int
     */
    public function extract($archive, $to = null)
    {
        $tar = new \Archive_Tar($archive->fullpath);
        $tar->extract((null !== $to) ? $to : './');

        return -1;
    }

    /**
     * Method to create an archived file using Tar
     *
     * @param  Pop_Archive $archive
     * @param  string|array $files
     * @return void
     */
    public function add($archive, $files)
    {
        if (!is_array($files)) {
            $files = array($files);
        }

        $tar = new \Archive_Tar($archive->fullpath);

        foreach ($files as $file) {
            // If file is a directory, loop through and add the files.
            if (file_exists($file) && is_dir($file)) {
                $dir = new Dir($file, true, true);
                foreach ($dir->files as $fle) {
                    if (file_exists($fle) && !is_dir($fle)) {
                        $tar->add($fle);
                    }
                }
            // Else, just add the file.
            } else if (file_exists($file)) {
                $tar->add($file);
            }
        }
    }

    /**
     * Method to list contents of a Tar archive
     *
     * @param  Pop_Archive $archive
     * @param  boolean       $all
     * @return array
     */
    public function listFiles($archive, $all = false)
    {
        $files = array();

        $tar = new \Archive_Tar($archive->fullpath);
        $list = $tar->listContent();

        if (!$all) {
            foreach ($list as $file) {
                $files[] = $file['filename'];
            }
        } else {
            $files = $list;
        }

        return $files;
    }

}
