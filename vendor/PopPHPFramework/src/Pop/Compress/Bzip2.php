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
 * @package    Pop_Compress
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Compress;

/**
 * This is the Bzip2 class for the Compress component.
 *
 * @category   Pop
 * @package    Pop_Compress
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.3
 */
class Bzip2 implements CompressInterface
{

    /**
     * Static method to compress data
     *
     * @param  string $data
     * @param  int    $block
     * @return mixed
     */
    public static function compress($data, $block = 5)
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
        if (file_exists($data)) {
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
