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

/**
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
interface ArchiveInterface
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
     * Method to create an archive file
     *
     * @param  string|array $files
     * @return Pop_Archive
     */
    public function removeFiles($files);

    /**
     * Method to return a listing of the contents of an archived file
     *
     * @param  boolean $all
     * @throws Exception
     * @return array
     */
    public function listFiles($all = false);

}
