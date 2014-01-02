<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Archive\Adapter;

/**
 * Archive adapter interface
 *
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
interface ArchiveInterface
{

    /**
     * Method to instantiate an archive adapter object
     *
     * @param  \Pop\Archive\Archive $archive
     * @return \Pop\Archive\Adapter\ArchiveInterface
     */
    public function __construct(\Pop\Archive\Archive $archive);

    /**
     * Method to return the archive object
     *
     * @return mixed
     */
    public function archive();

    /**
     * Method to extract an archived and/or compressed file
     *
     * @param  string $to
     * @return void
     */
    public function extract($to = null);

    /**
     * Method to create an archive file
     *
     * @param  string|array $files
     * @return void
     */
    public function addFiles($files);

    /**
     * Method to return a listing of the contents of an archived file
     *
     * @param  boolean $full
     * @return array
     */
    public function listFiles($full = false);

}
