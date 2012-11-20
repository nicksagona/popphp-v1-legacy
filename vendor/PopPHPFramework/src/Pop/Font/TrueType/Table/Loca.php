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
 * This is the Loca class for the Font component.
 *
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
 */
class Loca
{

    /**
     * Location offsets
     * @var array
     */
    public $offsets = array();

    /**
     * Constructor
     *
     * Instantiate a TTF 'loca' table object.
     *
     * @param  Pop_Font $font
     * @return void
     */
    public function __construct($font)
    {
        $bytePos = $font->tableInfo['loca']->offset;

        $format = ($font->header->indexToLocFormat == 1) ? 'N' : 'n';
        $byteLength = ($font->header->indexToLocFormat == 1) ? 4 : 2;
        $multiplier = ($font->header->indexToLocFormat == 1) ? 1 : 2;

        for ($i = 0; $i < ($font->numberOfGlyphs + 1); $i++) {
            $ary = unpack($format . 'offset', $font->read($bytePos, $byteLength));
            $this->offsets[$i] = $ary['offset'] * $multiplier;
            $bytePos += $byteLength;
        }
    }

}
