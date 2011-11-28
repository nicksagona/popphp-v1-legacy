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
 * @package    Pop_Pdf
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @category   Pop
 * @package    Pop_Pdf
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */

/**
 * @namespace
 */
namespace Pop\Pdf\Parser;
use Pop\Archive\Archive,
    Pop\Font\TrueType,
    Pop\Pdf\Object;

class Font
{

    /**
     * Font object
     * @var Pop_Font
     */
    protected $_font = null;

    /**
     * Font reference index
     * @var int
     */
    protected $_fontIndex = 0;

    /**
     * Font object index
     * @var int
     */
    protected $_objectIndex = 0;

    /**
     * Font descriptor index
     * @var int
     */
    protected $_fontDescIndex = 0;

    /**
     * Font file index
     * @var int
     */
    protected $_fontFileIndex = 0;

    /**
     * Font objects
     * @var array
     */
    protected $_objects = array();

    /**
     * Font compress flag
     * @var boolean
     */
    protected $_compress = false;

    /**
     * Constructor
     *
     * Instantiate a font parser object to be used by Pop_Pdf.
     *
     * @param  string  $fle
     * @param  int     $fi
     * @param  int     $oi
     * @param  boolean $comp
     * @throws Exception
     * @return void
     */
    public function __construct($fle, $fi, $oi, $comp = false)
    {

        $this->_fontIndex = $fi;
        $this->_objectIndex = $oi;
        $this->_fontDescIndex = $oi + 1;
        $this->_fontFileIndex = $oi + 2;
        $this->_compress = $comp;

        $this->_font = new TrueType($fle);

        $this->_createFontObjects();

    }

    /**
     * Method to get the font objects.
     *
     * @return array
     */
    public function getObjects()
    {

        return $this->_objects;

    }

    /**
     * Method to get the font reference.
     *
     * @return array
     */
    public function getFontRef()
    {

        return "/TT{$this->_fontIndex} {$this->_objectIndex} 0 R";

    }

    /**
     * Method to get the font name.
     *
     * @return array
     */
    public function getFontName()
    {

        return $this->_font->tables['name']->postscriptName;

    }



    /**
     * Method to create the font objects.
     *
     * @return void
     */
    protected function _createFontObjects()
    {

        $this->_objects[$this->_objectIndex] = new Object("{$this->_objectIndex} 0 obj\n<<\n    /Type /Font\n    /Subtype /TrueType\n    /FontDescriptor {$this->_fontDescIndex} 0 R\n    /Name /TT{$this->_fontIndex}\n    /BaseFont /" . $this->_font->tables['name']->postscriptName . "\n    /FirstChar 32\n    /LastChar 255\n    /Widths [" . implode(' ', $this->_font->glyphWidths) . "]\n    /Encoding /WinAnsiEncoding\n>>\nendobj\n\n");

        $unCompStream = $this->_font->read();
        $compStream = (function_exists('gzcompress')) ? Archive::compress($unCompStream) : null;
        $bBox = '[' . $this->_font->bBox->xMin . ' ' . $this->_font->bBox->yMin . ' ' . $this->_font->bBox->xMax . ' ' . $this->_font->bBox->yMax . ']';

        if ($this->_compress) {
            $fontFileObj = "{$this->_fontFileIndex} 0 obj\n<</Length " . $this->_calcByteLength($compStream) . " /Filter /FlateDecode /Length1 " . $this->_calcByteLength($unCompStream) . ">>\nstream\n" . $compStream . "\nendstream\nendobj\n\n";
        } else {
            $fontFileObj = "{$this->_fontFileIndex} 0 obj\n<</Length " . $this->_calcByteLength($unCompStream) . ">>\nstream\n" . $unCompStream . "\nendstream\nendobj\n\n";
        }

        $this->_objects[$this->_fontDescIndex] = new Object("{$this->_fontDescIndex} 0 obj\n<<\n    /Type /FontDescriptor\n    /FontName /" . $this->_font->tables['name']->postscriptName . "\n    /FontFile2 {$this->_fontFileIndex} 0 R\n    /StemV {$this->_font->stemV}\n    /Flags " . $this->_font->calcFlags() . "\n    /FontBBox {$bBox}\n    /Descent {$this->_font->descent}\n    /Ascent {$this->_font->ascent}\n    /CapHeight {$this->_font->capHeight}\n    /ItalicAngle {$this->_font->italicAngle}\n>>\nendobj\n\n");
        $this->_objects[$this->_fontFileIndex] = new Object($fontFileObj);

    }

    /**
     * Method to calculate byte length.
     *
     * @param  string $str
     * @return int
     */
    protected function _calcByteLength($str)
    {

        $bytes = str_replace("\n", "", $str);
        return strlen($bytes);

    }

}