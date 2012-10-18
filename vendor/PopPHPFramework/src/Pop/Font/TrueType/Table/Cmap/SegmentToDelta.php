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
namespace Pop\Font\TrueType\Table\Cmap;

/**
 * This is the SegmentToDelta class for the Font component.
 *
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.1
 */
class SegmentToDelta
{

    /**
     * Method to parse the Segment to Delta (Format 4) CMAP data
     *
     * @param  string $data
     * @return array
     */
    public static function parseData($data)
    {
        $ary = unpack(
            'nsegCountx2/' .
            'nsearchRange/' .
            'nentrySelector/' .
            'nrangeShift', substr($data, 0, 8)
        );

        $ary['segCount'] = $ary['segCountx2'] / 2;
        $ary['endCount'] = array();

        $bytePos = 8;
        for ($i = 0; $i < $ary['segCount']; $i++) {
            $ar = unpack('nendCount', substr($data, $bytePos, 2));
            $ary['endCount'][$i] = $ar['endCount'];
            $bytePos += 2;
        }

        $ar = unpack('nreservedPad', substr($data, $bytePos, 2));
        $bytePos += 2;

        $ary['reservedPad'] = $ar['reservedPad'];

        $ary['startCount'] = array();

        for ($i = 0; $i < $ary['segCount']; $i++) {
            $ar = unpack('nstartCount', substr($data, $bytePos, 2));
            $ary['startCount'][$i] = $ar['startCount'];
            $bytePos += 2;
        }

        $ary['idDelta'] = array();

        for ($i = 0; $i < $ary['segCount']; $i++) {
            $ar = unpack('nidDelta', substr($data, $bytePos, 2));
            $ary['idDelta'][$i] = self::shiftToSigned($ar['idDelta']);
            $bytePos += 2;
        }

        $ary['idRangeOffset'] = array();

        for ($i = 0; $i < $ary['segCount']; $i++) {
            $ar = unpack('nidRangeOffset', substr($data, $bytePos, 2));
            $ary['idRangeOffset'][$i] = $ar['idRangeOffset'] >> 1;
            $bytePos += 2;
        }

        $ary['glyphIndexArray'] = array();

        for (; $bytePos < strlen($data); $bytePos += 2) {
            $ar = unpack('nglyphIndex', substr($data, $bytePos, 2));
            $ary['glyphIndexArray'][] = $ar['glyphIndex'];
        }

        $ary['glyphNumbers'] = array();

        for ($segmentNum = 0; $segmentNum < $ary['segCount']; $segmentNum++) {
            if ($ary['idRangeOffset'][$segmentNum] == 0) {
                $delta = $ary['idDelta'][$segmentNum];

                for ($code = $ary['startCount'][$segmentNum];
                     $code <= $ary['endCount'][$segmentNum];
                     $code++) {
                    $ary['glyphNumbers'][$code] = ($code + $delta) % 65536;
                }
            } else {
                $code       = $ary['startCount'][$segmentNum];
                $glyphIndex = $ary['idRangeOffset'][$segmentNum] - ($ary['segCount'] - $segmentNum) - 1;

                while ($code <= $ary['endCount'][$segmentNum]) {
                    if (isset($ary['glyphIndexArray'][$glyphIndex])) {
                        $ary['glyphNumbers'][$code] = $ary['glyphIndexArray'][$glyphIndex];
                    }

                    $code++;
                    $glyphIndex++;
                }
            }
        }

        $ary['mapData'] = str_repeat("\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00", 8192);
        // Fill the index
        foreach ($ary['glyphNumbers'] as $charCode => $glyph) {
            $ary['mapData'][$charCode * 2] = chr($glyph >> 8);
            $ary['mapData'][$charCode * 2 + 1] = chr($glyph & 0xFF);
        }

        return $ary;
    }

    /**
     * Method to shift an unpacked signed short from big endian to little endian
     *
     * @param  int|array $values
     * @return int|array
     */
    public static function shiftToSigned($values)
    {
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                if ($value >= pow(2, 15)) {
                    $values[$key] -= pow(2, 16);
                }
            }
        } else {
            if ($values >= pow(2, 15)) {
                $values -= pow(2, 16);
            }
        }

        return $values;
    }

}