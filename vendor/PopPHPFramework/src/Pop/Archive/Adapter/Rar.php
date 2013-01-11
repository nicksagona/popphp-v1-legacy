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

/**
 * This is the Rar class for the Archive component.
 *
 * @category   Pop
 * @package    Pop_Archive
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.2
 */
class Rar implements \Pop\Archive\ArchiveInterface
{

    /**
     * RarArchive object
     * @var \RarArchive
     */
    public $archive = null;

    /**
     * Archive path
     * @var string
     */
    protected $path = null;

    /**
     * Archive password
     * @var string
     */
    protected $password = null;

    /**
     * Method to instantiate an archive adapter object
     *
     * @param  \Pop\Archive\Archive $archive
     * @param  string              $password
     * @throws Exception
     * @return \Pop\Archive\Adapter\Rar
     */
    public function __construct($archive, $password = null)
    {
        $this->path = $archive->getFullpath();
        $this->password = $password;

        if (file_exists($this->path)) {
            $this->archive = \RarArchive::open($this->path, $this->password);
        } else {
            throw new Exception('Due to licensing restrictions, RAR files cannot be created and can only be decompressed.');
        }
    }

    /**
     * Method to extract an archived and/or compressed file
     *
     * @param  string $to
     * @return void
     */
    public function extract($to = null)
    {
        $entries = $this->archive->getEntries();
        if (!empty($entries)) {
            foreach ($entries as $entry) {
                $entry->extract((null !== $to) ? $to : './');
            }
        }
    }

    /**
     * Method to create an archive file
     *
     * @param  string|array $files
     * @throws Exception
     * @return void
     */
    public function addFiles($files)
    {
        throw new Exception('Due to licensing restrictions, RAR files cannot be created and can only be decompressed.');
    }

    /**
     * Method to return a listing of the contents of an archived file
     *
     * @param  boolean $full
     * @return array
     */
    public function listFiles($full = false)
    {
        $list = array();
        $entries = $this->archive->getEntries();

        if (!empty($entries)) {
            foreach ($entries as $entry) {
                if (!$full) {
                    $list[] = $entry->getName();
                } else {
                    $list[] = array(
                        'name'          => $entry->getName(),
                        'unpacked_size' => $entry->getUnpackedSize(),
                        'packed_size'   => $entry->getPackedSize(),
                        'host_os'       => $entry->getHostOs(),
                        'file_time'     => $entry->getFileTime(),
                        'crc'           => $entry->getCrc(),
                        'attr'          => $entry->getAttr(),
                        'version'       => $entry->getVersion(),
                        'method'        => $entry->getMethod()
                    );
                }
            }
        }

        return $list;
    }

}
