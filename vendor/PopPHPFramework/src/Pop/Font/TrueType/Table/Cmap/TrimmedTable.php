<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Font\TrueType\Table\Cmap;

/**
 * CMAP trimmed-table class
 *
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class TrimmedTable
{

    /**
     * Method to parse the Trimmed Table (Format 6) CMAP data
     *
     * @param  string $data
     * @return array
     */
    public static function parseData($data)
    {
        $ary = unpack(
            'nfirstCode/' .
            'nentryCount', substr($data, 0, 4)
        );

        $ary['glyphId'] = array();

        $bytePos = 4;
        for ($i = 0; $i < $ary['entryCount']; $i++) {
            $ar = unpack('nglyphIndex', substr($data, $bytePos, 2));
            $ary['glyphId'][$i] = $ar['glyphIndex'];
            $bytePos += 2;
        }

        return $ary;
    }

}