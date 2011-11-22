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
 * Pop_Archive_Bzip2
 *
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Archive_Bzip2
{

    /**
     * Method to extract a compressed file using Bzip2
     *
     * @param  Pop_Archive $archive
     * @param  string        $to
     * @return mixed
     */
    public function extract($archive, $to = null)
    {
        // Create the new, uncompressed file and open the Bzip2 compressed file.
        $new = new Pop_File(str_replace('.bz2', '', $archive->fullpath));
        $bz = bzopen($archive->fullpath, 'r');
        $decompressed = '';

        // Read the uncompressed data.
        while (!feof($bz)) {
            $decompressed .= bzread($bz, 4096);
        }

        // Close the Bzip2 compressed file and write the data to the uncompressed file.
        bzclose($bz);
        $new->write($decompressed);

        // If it was a Tar/Bzip2 combo, extract the newly uncompressed Tar file as well.
        if ($archive->ext == 'tbz2') {
            $tar = new Pop_Archive_Tar();
            return $tar->extract($archive, $to);
        } else {
            return $new->fullpath;
        }
    }

    /**
     * Static method to compress an archive file using Bzip2.
     *
     * @param  Pop_Archive $archive
     * @return string
     */
    public static function compress($archive)
    {
        // Read the file data.
        $data = $archive->read();

        // Create the new Bzip2 file and resource.
        $bzFile = new Pop_File($archive->fullpath . '.bz2');
        $bzResource = bzopen($bzFile->fullpath, 'w');

        // Write the data to the new Bzip2 file and close the resource.
        bzwrite($bzResource, $data, strlen($data));
        bzclose($bzResource);

        return $bzFile->fullpath;
    }

}
