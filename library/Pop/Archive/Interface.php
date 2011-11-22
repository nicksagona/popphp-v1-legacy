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
 * Pop_Archive_Interface
 *
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

interface Pop_Archive_Interface
{

    /**
     * Constructor
     *
     * Instantiate the archive object
     *
     * @param  string $archive
     * @return void
     */
    public function __construct($archive);

    /**
     * Static method to instantiate the archive object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $archive
     * @return Pop_Archive
     */
    public static function factory($archive);

    /**
     * Method to extract an archived and/or compressed file
     *
     * @param  string $to
     * @return Pop_Archive
     */
    public function extract($to = null);

    /**
     * Method to create an archive file
     *
     * @param  string|array $files
     * @return Pop_Archive
     */
    public function addFiles($files);

    /**
     * Method to compress an archive file
     *
     * @param  int     $type
     * @param  boolean $replace
     * @param  int     $level
     * @return Pop_Archive
     */
    public function compressArchive($type = Pop_Archive::GZIP, $replace = false, $level = 4);

    /**
     * Method to return a listing of the contents of an archived file
     *
     * @param  boolean $all
     * @throws Exception
     * @return array
     */
    public function listFiles($all = false);

    /**
     * Static method to compress a string of data
     *
     * @param  string $data
     * @param  int    $type
     * @param  int    $level
     * @return string
     */
    public static function compress($data, $type = Pop_Archive::GZIP, $level = 4);

    /**
     * Static method to decompress a string of data
     *
     * @param  string $data
     * @param  int    $type
     * @return string
     */
    public static function decompress($data, $type = Pop_Archive::GZIP);

}
