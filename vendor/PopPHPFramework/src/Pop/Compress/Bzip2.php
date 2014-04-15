<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Compress
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Compress;

/**
 * BZip2 class
 *
 * @category   Pop
 * @package    Pop_Compress
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Bzip2
{

    /**
     * Static method to compress data
     *
     * @param  string $data
     * @param  int    $block
     * @return mixed
     */
    public static function compress($data, $block = 9)
    {
        // Compress the file
        if (file_exists($data)) {
            $fullpath = realpath($data);
            $data = file_get_contents($data);

            // Create the new Bzip2 file resource, write data and close it
            $bzResource = bzopen($fullpath . '.bz2', 'w');
            bzwrite($bzResource, $data, strlen($data));
            bzclose($bzResource);

            return $fullpath . '.bz2';
        // Else, compress the string
        } else {
            return bzcompress($data, $block);
        }
    }

    /**
     * Static method to decompress data
     *
     * @param  string $data
     * @return mixed
     */
    public static function decompress($data)
    {
        // Decompress the file
        if (@file_exists($data)) {
            $bz = bzopen($data, 'r');
            $uncompressed = '';
            // Read the uncompressed data.
            while (!feof($bz)) {
                $uncompressed .= bzread($bz, 4096);
            }
            // Close the Bzip2 compressed file and write
            // the data to the uncompressed file.
            bzclose($bz);
            if (stripos($data, '.tbz2') !== false) {
                $newFile = str_replace('.tbz2', '.tar', $data);
            } else if (stripos($data, '.tbz') !== false) {
                $newFile = str_replace('.tbz', '.tar', $data);
            } else {
                $newFile = str_replace('.bz2', '', $data);
            }

            file_put_contents($newFile, $uncompressed);

            return $newFile;
        // Else, decompress the string
        } else {
            return bzdecompress($data);
        }
    }

}
