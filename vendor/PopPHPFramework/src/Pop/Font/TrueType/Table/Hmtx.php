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
 * This is the Hmtx class for the Font component.
 *
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
 */
class Hmtx
{

    /**
     * Glyph widths
     * @var array
     */
    public $glyphWidths = array();

    /**
     * Constructor
     *
     * Instantiate a TTF 'hmtx' table object.
     *
     * @param  Pop_Font $font
     * @return void
     */
    public function __construct($font)
    {
        $bytePos = $font->tableInfo['hmtx']->offset;

        for ($i = 0; $i < $font->numberOfHMetrics; $i++) {
            $ary = unpack('nglyphWidth/', $font->read($bytePos, 2));
            $this->glyphWidths[$i] = $font->shiftToSigned($ary['glyphWidth']);
            $bytePos += 4;
        }

        while (count($this->glyphWidths) < $font->numberOfGlyphs) {
            $this->glyphWidths[] = end($this->glyphWidths);
        }
    }

}
