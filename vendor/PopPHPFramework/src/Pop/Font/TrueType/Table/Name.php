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
 * This is the Name class for the Font component.
 *
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0
 */
class Name
{

    /**
     * Font info
     * @var array
     */
    protected $fontInfo = array();

    /**
     * TrueType font info names
     * @var array
     */
    protected $names = array(
        0  => 'copyright',
        1  => 'fontFamily',
        2  => 'fontSubFamily',
        3  => 'uniqueId',
        4  => 'fullName',
        5  => 'version',
        6  => 'postscriptName',
        7  => 'trademark',
        8  => 'manufacturer',
        9  => 'designer',
        10 => 'description',
        11 => 'vendorUrl',
        12 => 'designerUrl',
        13 => 'license',
        14 => 'licenseUrl',
        16 => 'preferredFamily',
        17 => 'preferredSubFamily',
        18 => 'compatibleFull',
        19 => 'sampleText'
    );

    /**
     * Constructor
     *
     * Instantiate a TTF 'name' table object.
     *
     * @param  Pop_Font $font
     * @return void
     */
    public function __construct($font)
    {
        $font->tableInfo['name']->header = new \ArrayObject(
            unpack(
                'nformatSelector/' .
                'nnameRecordsCount/' .
                'nstorageOffset', $font->read($font->tableInfo['name']->offset, 6)
            ), \ArrayObject::ARRAY_AS_PROPS
        );

        $bytePos = $font->tableInfo['name']->offset + 6;

        for ($j = 0; $j < $font->tableInfo['name']->header->nameRecordsCount; $j++) {
            $ttfRecord = unpack(
                'nplatformId/' .
                'nencodingId/' .
                'nlanguageId/' .
                'nnameId/' .
                'nlength/' .
                'noffset', $font->read($bytePos, 12)
            );

            $ttfRecordOffset = $bytePos + 12;
            $nextBytePos = $font->tableInfo['name']->offset + $font->tableInfo['name']->header->storageOffset + $ttfRecord['offset'];

            $ttfValue = $font->read($nextBytePos, $ttfRecord['length']);

            if ($ttfRecord['platformId'] != 1) {
                $ttfValue = @iconv('UTF-16be', 'UTF-8//TRANSLIT', $ttfValue);
            }
            if ($ttfValue != '') {
                $this->fontInfo[$this->names[$ttfRecord['nameId']]] = $ttfValue;
            }

            $bytePos = $ttfRecordOffset;
        }

    }

    /**
     * Set method to set the property to the value of _fontInfo[$name].
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->fontInfo[$name] = $value;
    }

    /**
     * Get method to return the value of _fontInfo[$name].
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (array_key_exists($name, $this->fontInfo)) ? $this->fontInfo[$name] : null;
    }

    /**
     * Return the isset value of _fontInfo[$name].
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->fontInfo[$name]);
    }

    /**
     * Unset _fontInfo[$name].
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        $this->fontInfo[$name] = null;
    }

}
