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
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Post
{

    /**
     * Italic angle
     * @var float
     */
    public $italicAngle = 0;


    /**
     * Fixed
     * @var int
     */
    public $fixed = 0;

    /**
     * Constructor
     *
     * Instantiate a TTF 'post' table object.
     *
     * @param  Pop_Font $font
     * @return void
     */
    public function __construct($font)
    {
        $bytePos = $font->tableInfo['post']->offset + 4;

        $italicBytes = $font->read($bytePos, 4);
        $this->italicAngle = $font->readFixed(16, 16, $italicBytes);

        $bytePos += 8;

        $ary = unpack('nfixed/', $font->read($bytePos, 2));
        $ary = $font->shiftToSigned($ary);
        $this->fixed = $ary['fixed'];
    }

}
