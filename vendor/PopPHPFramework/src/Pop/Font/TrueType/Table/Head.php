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
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Font\TrueType\Table;

/**
 * This is the Head class for the Font component.
 *
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
 */
class Head
{

    /**
     * Header info
     * @var array
     */
    protected $headerInfo = array();

    /**
     * Constructor
     *
     * Instantiate a TTF 'head' table object.
     *
     * @param  Pop_Font $font
     * @return void
     */
    public function __construct($font)
    {
        $bytePos = $font->tableInfo['head']->offset;

        $tableVersionNumberBytes = $font->read($bytePos, 4);
        $tableVersionNumber = $font->readFixed(16, 16, $tableVersionNumberBytes);

        $bytePos += 4;

        $fontRevisionBytes = $font->read($bytePos, 4);
        $fontRevision = $font->readFixed(16, 16, $fontRevisionBytes);

        $versionArray = array(
            'tableVersionNumber' => $tableVersionNumber,
            'fontRevision'       => $fontRevision
        );

        $bytePos += 4;

        $headerArray = unpack(
            'NcheckSumAdjustment/' .
            'NmagicNumber/' .
            'nflags/' .
            'nunitsPerEm', $font->read($bytePos, 12)
        );

        $bytePos += 28;
        $bBox = unpack(
            'nxMin/' .
            'nyMin/' .
            'nxMax/' .
            'nyMax', $font->read($bytePos, 8)
        );
        $bBox = $font->shiftToSigned($bBox);

        $bytePos += 14;
        $indexToLocFormat = unpack('nindexToLocFormat', $font->read($bytePos, 2));
        $headerArray['indexToLocFormat'] = $font->shiftToSigned($indexToLocFormat['indexToLocFormat']);

        $this->headerInfo = array_merge($versionArray, $headerArray, $bBox);
    }

    /**
     * Set method to set the property to the value of _headerInfo[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->headerInfo[$name] = $value;
    }

    /**
     * Get method to return the value of _headerInfo[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (array_key_exists($name, $this->headerInfo)) ? $this->headerInfo[$name] : null;
    }

    /**
     * Return the isset value of _headerInfo[$name].
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->headerInfo[$name]);
    }

    /**
     * Unset _headerInfo[$name].
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        $this->headerInfo[$name] = null;
    }

}
