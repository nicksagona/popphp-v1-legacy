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
 * MAXP table class
 *
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Maxp
{

    /**
     * Number of glyphs
     * @var int
     */
    public $numberOfGlyphs = 0;

    /**
     * Constructor
     *
     * Instantiate a TTF 'maxp' table object.
     *
     * @param  \Pop\Font\AbstractFont $font
     * @return \Pop\Font\TrueType\Table\Maxp
     */
    public function __construct(\Pop\Font\AbstractFont $font)
    {
        $bytePos = $font->tableInfo['maxp']->offset + 4;
        $ary = unpack('nnumberOfGlyphs/', $font->read($bytePos, 2));
        $this->numberOfGlyphs = $ary['numberOfGlyphs'];
    }

}
