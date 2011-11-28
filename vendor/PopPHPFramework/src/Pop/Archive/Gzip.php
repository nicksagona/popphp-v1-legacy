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
use Pop\File\File;

class Gzip
{

    /**
     * Static method to compress an archive file using Gzip.
     *
     * @param  Pop_Archive $archive
     * @param  int           $level
     * @return string
     */
    public static function compress($archive, $level = 4)
    {
        // Read the file data.
        $data = $archive->read();

        // Create the new Gzip file and resource.
        $gzFile = new File($archive->fullpath . '.gz');
        $gzResource = fopen($gzFile->fullpath, 'w');

        // Write the data to the new Gzip file and close the resource.
        fwrite($gzResource, gzencode($data, $level));
        fclose($gzResource);

        return $gzFile->fullpath;
    }

    /**
     * Method to extract a compressed file using Gzip
     *
     * @param  Pop_Archive $archive
     * @param  string        $to
     * @return mixed
     */
    public function extract($archive, $to = null)
    {
        // Create the new, uncompressed file and open the Gzip compressed file.
        $new = new File(str_replace('.gz', '', $archive->fullpath));
        $gz = gzopen($archive->fullpath, 'r');
        $decompressed = '';

        // Read the uncompressed data.
        while (!feof($gz)) {
            $decompressed .= gzread($gz, 4096);
        }

        // Close the Gzip compressed file and write the data to the uncompressed file.
        gzclose($gz);
        $new->write($decompressed);

        // If it was a Tar/Gzip combo, extract the newly uncompressed Tar file as well.
        if ($archive->ext == 'tgz') {
            $tar = new Tar();
            return $tar->extract($archive, $to);
        } else {
            return $new->fullpath;
        }
    }

}
