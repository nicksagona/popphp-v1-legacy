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
namespace Pop\Font;

use Pop\File\File;

/**
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
abstract class AbstractFont extends File
{

    /**
     * Font info
     * @var mixed
     */
    public $info = null;

    /**
     * Font bounding box info
     * @var ArrayObject
     */
    public $bBox = null;

    /**
     * Font ascent value
     * @var int
     */
    public $ascent = 0;

    /**
     * Font descent value
     * @var int
     */
    public $descent = 0;

    /**
     * Font number of glyphs value
     * @var int
     */
    public $numberOfGlyphs = 0;

    /**
     * Font glyph widths
     * @var array
     */
    public $glyphWidths = array();

    /**
     * Font number of horizontal metrics value
     * @var int
     */
    public $numberOfHMetrics = 0;

    /**
     * Font italic angle value
     * @var float
     */
    public $italicAngle = 0;

    /**
     * Font cap height value
     * @var int
     */
    public $capHeight = 0;

    /**
     * Font StemH value
     * @var int
     */
    public $stemH = 0;

    /**
     * Font StemV value
     * @var int
     */
    public $stemV = 0;

    /**
     * Font units per EM value
     * @var int
     */
    public $unitsPerEm = 1000;

    /**
     * Font flags
     * @var ArrayObject
     */
    public $flags = null;

    /**
     * Array of allowed file types.
     * @var array
     */
    protected $_allowed = array(
        'afm' => 'application/x-font-afm',
        'otf' => 'application/x-font-otf',
        'pfb' => 'application/x-font-pfb',
        'pfm' => 'application/x-font-pfm',
        'ttf' => 'application/x-font-ttf'
    );

    /**
     * Constructor
     *
     * Instantiate a font file object based on a pre-existing font file on disk.
     *
     * @param  string $font
     * @return void
     */
    public function __construct($font)
    {
        $this->flags = new \ArrayObject(array(
            'isFixedPitch'  => false,
            'isSerif'       => false,
            'isSymbolic'    => false,
            'isScript'      => false,
            'isNonSymbolic' => false,
            'isItalic'      => false,
            'isAllCap'      => false,
            'isSmallCap'    => false,
            'isForceBold'   => false
        ), \ArrayObject::ARRAY_AS_PROPS);

        parent::__construct($font);
    }

    /**
     * Static method to read and return a fixed-point number
     *
     * @param  int    $mantissaBits
     * @param  int    $fractionBits
     * @param  string $bytes
     * @return int
     */
    public function readFixed($mantissaBits, $fractionBits, $bytes)
    {
        $bitsToRead = $mantissaBits + $fractionBits;
        $number = $this->readInt(($bitsToRead >> 3), $bytes) / (1 << $fractionBits);
        return $number;
    }

    /**
     * Static method to read and return a signed integer
     *
     * @param  int    $size
     * @param  string $bytes
     * @return int
     */
    public function readInt($size, $bytes)
    {
        $number = ord($bytes[0]);

        if (($number & 0x80) == 0x80) {
            $number = (~ $number) & 0xff;
            for ($i = 1; $i < $size; $i++) {
                $number = ($number << 8) | ((~ ord($bytes[$i])) & 0xff);
            }
            $number = ~$number;
        } else {
            for ($i = 1; $i < $size; $i++) {
                $number = ($number << 8) | ord($bytes[$i]);
            }
        }

        return $number;
    }

    /**
     * Method to shift an unpacked signed short from little endian to big endian
     *
     * @param  int|array $values
     * @return int|array
     */
    public function shiftToSigned($values)
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

    /**
     * Method to convert a value to the representative value in EM.
     *
     * @param int $value
     * @return int
     */
    public function toEmSpace($value)
    {
        return ($this->unitsPerEm == 1000) ? $value : ceil(($value / $this->unitsPerEm) * 1000);
    }

    /**
     * Method to calculate the font flags
     *
     * @return int
     */
    public function calcFlags()
    {
        // Array to represent big-endian order flag bits
        $flags = array(
            19 => 0,
            18 => 0,
            17 => 0,
            16 => 0,
            15 => 0,
            14 => 0,
            13 => 0,
            12 => 0,
            11 => 0,
            10 => 0,
             9 => 0,
             8 => 0,
             7 => 0,
             6 => 0,
             5 => 0,
             4 => 0,
             3 => 0,
             2 => 0,
             1 => 0
        );

        if ($this->flags->isFixedPitch) {
            $flags[1] = 1;
        }
        if ($this->flags->isSerif) {
            $flags[2] = 1;
        }
        if ($this->flags->isSymbolic) {
            $flags[3] = 1;
        }
        if ($this->flags->isScript) {
            $flags[4] = 1;
        }
        if ($this->flags->isNonSymbolic) {
            $flags[6] = 1;
        }
        if ($this->flags->isItalic) {
            $flags[7] = 1;
        }
        if ($this->flags->isAllCap) {
            $flags[17] = 1;
        }
        if ($this->flags->isSmallCap) {
            $flags[18] = 1;
        }
        if ($this->flags->isForceBold) {
            $flags[19] = 1;
        }

        $flagsValue = bindec(implode('', $flags));
        if ($flagsValue == 0) {
            $flagsValue = ($this->flags->isNonSymbolic) ? 32 : 4;
        }

        // Glue the bits together, convert to an integer and return
        return $flagsValue;
    }

}
