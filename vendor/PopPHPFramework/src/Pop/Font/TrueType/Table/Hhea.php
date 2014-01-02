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
namespace Pop\Font\TrueType\Table;

/**
 * HHEA table class
 *
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
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
     * @param  \Pop\Font\AbstractFont $font
     * @return \Pop\Font\TrueType\Table\Hhea
     */
    public function __construct(\Pop\Font\AbstractFont $font)
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
