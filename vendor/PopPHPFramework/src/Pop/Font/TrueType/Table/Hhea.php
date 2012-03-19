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
 * This is the Hhea class for the Font component.
 *
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0
 */
class Hhea
{

    /**
     * Ascent
     * @var int
     */
    public $ascent = 0;

    /**
     * Descent
     * @var int
     */
    public $descent = 0;

    /**
     * Number of horizontal metrics
     * @var int
     */
    public $numberOfHMetrics = 0;

    /**
     * Constructor
     *
     * Instantiate a TTF 'hhea' table object.
     *
     * @param  Pop_Font $font
     * @return void
     */
    public function __construct($font)
    {
        $bytePos = $font->tableInfo['hhea']->offset + 4;

        $ary = unpack(
            'nascent/' .
            'ndescent', $font->read($bytePos, 4)
        );

        $ary = $font->shiftToSigned($ary);
        $this->ascent = $font->toEmSpace($ary['ascent']);
        $this->descent = $font->toEmSpace($ary['descent']);

        $bytePos = $font->tableInfo['hhea']->offset + 34;
        $ary = unpack('nnumberOfHMetrics/', $font->read($bytePos, 2));
        $this->numberOfHMetrics = $ary['numberOfHMetrics'];
    }

}
