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
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Pdf\Parser;

use Pop\Compress\Zlib,
    Pop\File\File,
    Pop\Font\TrueType,
    Pop\Font\TrueType\OpenType,
    Pop\Font\Type1,
    Pop\Locale\Locale,
    Pop\Pdf\Object;

/**
 * @category   Pop
 * @package    Pop_Pdf
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
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

        $ext = strtolower(substr($fle, -4));
        switch ($ext) {
            case '.ttf':
                $this->_font = new TrueType($fle);
                break;
            case '.otf':
                $this->_font = new OpenType($fle);
                break;
            case '.pfb':
                $this->_font = new Type1($fle);
                break;
            case 'afm':
                $this->_font = new Type1($fle);
                break;
            default:
                throw new Exception(Locale::factory()->__('That font type is not supported.'));
        }


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
        $fontName = ($this->_font instanceof Type1) ? $this->_font->info->postscriptName : $this->_font->tables['name']->postscriptName;
        return $fontName;
    }

    /**
     * Method to create the font objects.
     *
     * @return void
     */
    protected function _createFontObjects()
    {
        if ($this->_font instanceof Type1) {
            $fontType = 'Type1';
            $fontName = $this->_font->info->postscriptName;
            $fontFile = 'FontFile';
            $glyphWidths = array('encoding' => 'StandardEncoding', 'widths' => $this->_font->glyphWidths);
            if (strtolower($this->_font->ext) == 'pfb') {
                $unCompStream = $this->_font->read();
            } else {
                $f = new File($this->_font->pfbPath);
                $unCompStream = $f->read();
            }
        } else {
            $fontType = 'TrueType';
            $fontName = $this->_font->tables['name']->postscriptName;
            $fontFile = 'FontFile2';
            $glyphWidths = $this->_getGlyphWidths($this->_font->tables['cmap']);
            $unCompStream = $this->_font->read();
        }

        $this->_objects[$this->_objectIndex] = new Object("{$this->_objectIndex} 0 obj\n<<\n    /Type /Font\n    /Subtype /{$fontType}\n    /FontDescriptor {$this->_fontDescIndex} 0 R\n    /Name /TT{$this->_fontIndex}\n    /BaseFont /" . $fontName . "\n    /FirstChar 32\n    /LastChar 255\n    /Widths [" . implode(' ', $glyphWidths['widths']) . "]\n    /Encoding /" . $glyphWidths['encoding'] . "\n>>\nendobj\n\n");
        $bBox = '[' . $this->_font->bBox->xMin . ' ' . $this->_font->bBox->yMin . ' ' . $this->_font->bBox->xMax . ' ' . $this->_font->bBox->yMax . ']';

        $compStream = (function_exists('gzcompress')) ? Zlib::compress($unCompStream) : null;
        if ($this->_compress) {
            $fontFileObj = "{$this->_fontFileIndex} 0 obj\n<</Length " . strlen($compStream) . " /Filter /FlateDecode /Length1 " . strlen($unCompStream) . ">>\nstream\n" . $compStream . "\nendstream\nendobj\n\n";
        } else {
            $fontFileObj = "{$this->_fontFileIndex} 0 obj\n<</Length " . strlen($unCompStream) . " /Length1 " . strlen($unCompStream) . ">>\nstream\n" . $unCompStream . "\nendstream\nendobj\n\n";
        }

        $this->_objects[$this->_fontDescIndex] = new Object("{$this->_fontDescIndex} 0 obj\n<<\n    /Type /FontDescriptor\n    /FontName /" . $fontName . "\n    /{$fontFile} {$this->_fontFileIndex} 0 R\n    /MissingWidth {$this->_font->missingWidth}\n    /StemV {$this->_font->stemV}\n    /Flags " . $this->_font->calcFlags() . "\n    /FontBBox {$bBox}\n    /Descent {$this->_font->descent}\n    /Ascent {$this->_font->ascent}\n    /CapHeight {$this->_font->capHeight}\n    /ItalicAngle {$this->_font->italicAngle}\n>>\nendobj\n\n");
        $this->_objects[$this->_fontFileIndex] = new Object($fontFileObj);
    }

    /**
     * Method to to get the glyph widths
     *
     * @param  Pop\Font\TrueType\Table\Cmap $cmap
     * @return array
     */
    protected function _getGlyphWidths($cmap)
    {
        $gw = array('encoding' => null, 'widths' => array());
        $msTable = null;
        $macTable = null;

        foreach ($cmap->subTables as $index => $table) {
            if ($table->encoding == 'Microsoft Unicode') {
                $msTable = $index;
            }
            if (($table->encoding == 'Mac Roman') && ($table->format == 0)) {
                $macTable = $index;
            }
        }

        if (null !== $msTable) {
            $gw['encoding'] = 'WinAnsiEncoding';
            foreach ($cmap->subTables[$msTable]->parsed['glyphNumbers'] as $key => $value) {
                $gw['widths'][$key] = $this->_font->glyphWidths[$value];
            }
        } else if (null !== $macTable) {
            $gw['encoding'] = 'MacRomanEncoding';
            foreach ($cmap->subTables[$macTable]->parsed as $key => $value) {
                if (($this->_font->glyphWidths[$value->ascii] != 0) && ($this->_font->glyphWidths[$value->ascii] != $this->_font->missingWidth)) {
                    $gw['widths'][$key] = $this->_font->glyphWidths[$value->ascii];
                }
            }
        }

        return $gw;
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