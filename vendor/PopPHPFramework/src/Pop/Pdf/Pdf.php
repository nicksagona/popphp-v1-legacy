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
namespace Pop\Pdf;

use Pop\Color\Color,
    Pop\Color\ColorInterface,
    Pop\Color\Rgb,
    Pop\File\File,
    Pop\Locale\Locale,
    Pop\Pdf\Import,
    Pop\Pdf\Info,
    Pop\Pdf\Object,
    Pop\Pdf\Page,
    Pop\Pdf\PdfParent,
    Pop\Pdf\Root,
    Pop\Pdf\Parser\Font,
    Pop\Pdf\Parser\Image;

/**
 * @category   Pop
 * @package    Pop_Pdf
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Pdf extends File
{

    /**
     * PDF root index.
     * @var int
     */
    protected $_root = 1;

    /**
     * PDF parent index.
     * @var int
     */
    protected $_parent = 2;

    /**
     * PDF info index.
     * @var int
     */
    protected $_info = 3;

    /**
     * Array of allowed file types.
     * @var array
     */
    protected $_allowed = array('pdf' => 'application/pdf');

    /**
     * Array of PDF page object indices.
     * @var array
     */
    protected $_pages = array();

    /**
     * Array of PDF objects.
     * @var array
     */
    protected $_objects = array();

    /**
     * PDF trailer.
     * @var string
     */
    protected $_trailer = null;

    /**
     * Current PDF page.
     * @var int
     */
    protected $_curPage = null;

    /**
     * PDF text parameters.
     * @var array
     */
    protected $_textParams = array('c' => 0, 'w' => 0, 'h' => 100, 'v' => 100, 'rot' => 0, 'rend' => 0);

    /**
     * PDF bytelength
     * @var int
     */
    protected $_bytelength = null;

    /**
     * Standard PDF fonts with their approximate character width and height factors.
     * @var array
     */
    protected $_standard_fonts = array(
        'Arial'                    => array('width_factor' => 0.5, 'height_factor' => 1),
        'Arial,Italic'             => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'Arial,Bold'               => array('width_factor' => 0.55, 'height_factor' => 1.12),
        'Arial,BoldItalic'         => array('width_factor' => 0.55, 'height_factor' => 1.12),
        'Courier'                  => array('width_factor' => 0.65, 'height_factor' => 1),
        'CourierNew'               => array('width_factor' => 0.65, 'height_factor' => 1),
        'Courier-Oblique'          => array('width_factor' => 0.65, 'height_factor' => 1),
        'CourierNew,Italic'        => array('width_factor' => 0.65, 'height_factor' => 1),
        'Courier-Bold'             => array('width_factor' => 0.65, 'height_factor' => 1),
        'CourierNew,Bold'          => array('width_factor' => 0.65, 'height_factor' => 1),
        'Courier-BoldOblique'      => array('width_factor' => 0.65, 'height_factor' => 1),
        'CourierNew,BoldItalic'    => array('width_factor' => 0.65, 'height_factor' => 1),
        'Helvetica'                => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'Helvetica-Oblique'        => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'Helvetica-Bold'           => array('width_factor' => 0.55, 'height_factor' => 1.12),
        'Helvetica-BoldOblique'    => array('width_factor' => 0.55, 'height_factor' => 1.12),
        'Symbol'                   => array('width_factor' => 0.85, 'height_factor' => 1.12),
        'Times-Roman'              => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'Times-Bold'               => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'Times-Italic'             => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'Times-BoldItalic'         => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'TimesNewRoman'            => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'TimesNewRoman,Italic'     => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'TimesNewRoman,Bold'       => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'TimesNewRoman,BoldItalic' => array('width_factor' => 0.5, 'height_factor' => 1.12),
        'ZapfDingbats'             => array('width_factor' => 0.75, 'height_factor' => 1.12)
    );

    /**
     * Last font name
     * @var string
     */
    protected $_lastFontName = null;

    /**
     * Stroke ON or OFF flag
     * @var boolean
     */
    protected $_stroke = false;

    /**
     * Stroke width
     * @var int
     */
    protected $_strokeWidth = null;

    /**
     * Stroke dash length
     * @var int
     */
    protected $_strokeDashLength = null;

    /**
     * Stroke dash gap
     * @var int
     */
    protected $_strokeDashGap = null;

    /**
     * Stroke color of the document
     * @var mixed
     */
    protected $_strokeColor = null;

    /**
     * Fill color of the document
     * @var mixed
     */
    protected $_fillColor = null;

    /**
     * Background color of the document
     * @var mixed
     */
    protected $_backgroundColor = null;

    /**
     * Compression property
     * @var boolean
     */
    protected $_compress = false;

    /**
     * Constructor
     *
     * Instantiate a PDF file object based on either a pre-existing PDF file on disk,
     * or a new PDF file. Arguments may be passed to add a page upon instantiation.
     * The PDF file exists, it and all of its assets will be imported.
     *
     * @param  string $pdf
     * @param  string $sz
     * @param  int    $w
     * @param  int    $h
     * @return void
     */
    public function __construct($pdf, $sz = null, $w = null, $h = null)
    {
        $this->_fillColor = new Rgb(0, 0, 0);
        $this->_backgroundColor = new Rgb(255, 255, 255);

        parent::__construct($pdf);

        $this->_objects[1] = new Root();
        $this->_objects[2] = new PdfParent();
        $this->_objects[3] = new Info();

        // If the PDF file already exists, import it.
        if ($this->_size != 0) {
            $this->importPdf($this->fullpath);
        }

        // If page parameters were passed, add a new page.
        if ((null !== $sz) || ((null !== $w) && (null !== $h))) {
            $this->addPage($sz, $w, $h);
        }
    }

    /**
     * Method to import either an entire PDF, or a page of a PDF, and the related data.
     *
     * @param  string           $pdf
     * @param  int|string|array $pg
     * @return Pop\Pdf\Pdf
     */
    public function importPdf($pdf, $pg = null)
    {
        // Create a new PDF Import object.
        $pdfi = new Import($pdf, $pg);

        // Shift the imported objects indices based on existing indices in this PDF.
        $pdfi->shiftObjects(($this->_lastIndex($this->_objects) + 1));

        // Fetch the imported objects.
        $importedObjs = $pdfi->returnObjects($this->_parent);

        // Loop through the imported objects, adding the pages or objects as applicable.
        foreach($importedObjs as $key => $value) {
            if ($value['type'] == 'page') {
                // Add the page object.
                $this->_objects[$key] = new Page($value['data']);

                // Finalize related page variables and objects.
                $this->_curPage = (null === $this->_curPage) ? 0 : ($this->_lastIndex($this->_pages) + 1);
                $this->_pages[$this->_curPage] = $key;
                $this->_objects[$this->_parent]->count += 1;
            } else {
                // Else, add the content object.
                $this->_objects[$key] = new Object($value['data']);
            }
        }

        foreach ($pdfi->pages as $value) {
            $this->_objects[$this->_parent]->kids[] = $value;
        }

        return $this;
    }

    /**
     * Method to add a page to the PDF of a determined size.
     *
     * @param  string $sz
     * @param  int    $w
     * @param  int    h
     * @return Pop\Pdf\Pdf
     */
    public function addPage($sz = null, $w = null, $h = null)
    {
        // Define the next page and content object indices.
        $pi = $this->_lastIndex($this->_objects) + 1;
        $ci = $this->_lastIndex($this->_objects) + 2;

        // Create the page object.
        $this->_objects[$pi] = new Page(null, $sz, $w, $h, $pi);
        $this->_objects[$pi]->content[] = $ci;
        $this->_objects[$pi]->curContent = $ci;
        $this->_objects[$pi]->parent = $this->_parent;

        // Create the content object.
        $this->_objects[$ci] = new Object($ci);

        // Finalize related page variables and objects.
        $this->_curPage = (null === $this->_curPage) ? 0 : ($this->_lastIndex($this->_pages) + 1);
        $this->_pages[$this->_curPage] = $pi;
        $this->_objects[$this->_parent]->count += 1;
        $this->_objects[$this->_parent]->kids[] = $pi;

        return $this;
    }

    /**
     * Method to copy a page of the PDF.
     *
     * @param  int $pg
     * @throws Exception
     * @return Pop\Pdf\Pdf
     */
    public function copyPage($pg)
    {
        $key = $pg - 1;

        // Check if the page exists.
        if (!array_key_exists($key, $this->_pages)) {
            throw new Exception($this->_lang->__('Error: That page does not exist.'));
        } else {
            $pi = $this->_lastIndex($this->_objects) + 1;
            $ci = $this->_lastIndex($this->_objects) + 2;
            $this->_objects[$pi] = new Page($this->_objects[$this->_pages[$key]]);
            $this->_objects[$pi]->index = $pi;

            // Duplicate the page's content objects.
            $oldContent = $this->_objects[$pi]->content;
            unset($this->_objects[$pi]->content);
            foreach ($oldContent as $key => $value) {
                $this->_objects[$ci] = new Object((string)$this->_objects[$value]);
                $this->_objects[$ci]->index = $ci;
                $this->_objects[$pi]->content[] = $ci;
                $ci += 1;
            }

            // Finalize related page variables and objects.
            $this->_curPage = (null === $this->_curPage) ? 0 : ($this->_lastIndex($this->_pages) + 1);
            $this->_pages[$this->_curPage] = $pi;
            $this->_objects[$this->_parent]->count += 1;
            $this->_objects[$this->_parent]->kids[] = $pi;
        }

        return $this;
    }

    /**
     * Method to delete the page of the PDF and its content objects.
     *
     * @param  int $pg
     * @throws Exception
     * @return Pop\Pdf\Pdf
     */
    public function deletePage($pg)
    {
        $key = $pg - 1;

        // Check if the page exists.
        if (!array_key_exists($key, $this->_pages)) {
            throw new Exception($this->_lang->__('Error: That page does not exist.'));
        } else {
            // Determine the page index and related data.
            $pi = $this->_pages[$key];
            $ki =  array_search($pi, $this->_objects[$this->_parent]->kids);
            $content_objs = $this->_objects[$pi]->content;

            // Remove the page's content objects.
            if (count($content_objs) != 0) {
                foreach ($content_objs as $value) {
                    unset($this->_objects[$value]);
                }
            }

            // Subtract the page from the parent's count property.
            $this->_objects[$this->_parent]->count -= 1;

            // Remove the page from the kids and pages arrays, and remove the page object.
            unset($this->_objects[$this->_parent]->kids[$ki]);
            unset($this->_pages[$key]);
            unset($this->_objects[$pi]);

            // Reset the kids array.
            $tmpAry = $this->_objects[$this->_parent]->kids;
            $this->_objects[$this->_parent]->kids = array();
            foreach ($tmpAry as $value) {
                $this->_objects[$this->_parent]->kids[] = $value;
            }

            // Reset the pages array.
            $tmpAry = $this->_pages;
            $this->_pages = array();
            foreach ($tmpAry as $value) {
                $this->_pages[] = $value;
            }
        }

        return $this;
    }

    /**
     * Method to order the pages of the PDF.
     *
     * @param  array $pgs
     * @throws Exception
     * @return Pop\Pdf\Pdf
     */
    public function orderPages($pgs)
    {
        $newOrder = array();

        // Check if the PDF has more than one page.
        if (count($this->_pages) <= 1) {
            throw new Exception($this->_lang->__('Error: The PDF does not have enough pages in which to order.'));
        // Else, check if the numbers of pages passed equals the number of pages in the PDF.
        } else if (count($pgs) != count($this->_pages)) {
            throw new Exception($this->_lang->__('Error: The pages array passed does not contain the same number of pages as the PDF.'));
        } else {
            // Make sure each page passed is within the PDF and not out of range.
            foreach ($pgs as $value) {
                if (!array_key_exists(($value - 1), $this->_pages)) {
                    throw new Exception($this->_lang->__('Error: The pages array passed contains a page that does not exist.'));
                }
            }

            // Set the new order of the page objects.
            foreach ($pgs as $value) {
                $newOrder[] = $this->_pages[$value - 1];
            }
        }

        // Set the kids and pages arrays to the new order.
        $this->_objects[$this->_parent]->kids = $newOrder;
        $this->_pages = $newOrder;

        return $this;
    }

    /**
     * Method to return the current page number of the current page of the PDF.
     *
     * @return int
     */
    public function curPage()
    {
        return ($this->_curPage + 1);
    }

    /**
     * Method to return the current number of pages in the PDF.
     *
     * @return int
     */
    public function numPages()
    {
        return count($this->_pages);
    }

    /**
     * Method to return the name of the last font added.
     *
     * @return string
     */
    public function getLastFontName()
    {
        return $this->_lastFontName;
    }

    /**
     * Method to set the compression of the PDF.
     *
     * @param  boolean $comp
     * @return Pop\Pdf\Pdf
     */
    public function setCompression($comp = false)
    {
        $this->_compress = $comp;
        return $this;
    }

    /**
     * Method to set the current page of the PDF in which to edit.
     *
     * @param  int $pg
     * @throws Exception
     * @return Pop\Pdf\Pdf
     */
    public function setPage($pg)
    {
        $key = $pg - 1;

        // Check if the page exists.
        if (!array_key_exists($key, $this->_pages)) {
            throw new Exception($this->_lang->__('Error: That page does not exist.'));
        } else {
            $this->_curPage = $pg - 1;
        }

        return $this;
    }

    /**
     * Method to set the PDF version.
     *
     * @param  string $ver
     * @return Pop\Pdf\Pdf
     */
    public function setVersion($ver)
    {
        $this->_objects[$this->_root]->version = $ver;
        return $this;
    }

    /**
     * Method to set the PDF info title.
     *
     * @param  string $tle
     * @return Pop\Pdf\Pdf
     */
    public function setTitle($tle)
    {
        $this->_objects[$this->_info]->title = $tle;
        return $this;
    }

    /**
     * Method to set the PDF info author.
     *
     * @param  string $auth
     * @return Pop\Pdf\Pdf
     */
    public function setAuthor($auth)
    {
        $this->_objects[$this->_info]->author = $auth;
        return $this;
    }

    /**
     * Method to set the PDF info subject.
     *
     * @param  string $subj
     * @return Pop\Pdf\Pdf
     */
    public function setSubject($subj)
    {
        $this->_objects[$this->_info]->subject = $subj;
        return $this;
    }

    /**
     * Method to set the PDF info creation date.
     *
     * @param  string $dt
     * @return Pop\Pdf\Pdf
     */
    public function setCreateDate($dt)
    {
        $this->_objects[$this->_info]->create_date = $dt;
        return $this;
    }

    /**
     * Method to set the PDF info modification date.
     *
     * @param  string $dt
     * @return Pop\Pdf\Pdf
     */
    public function setModDate($dt)
    {
        $this->_objects[$this->_info]->mod_date = $dt;
        return $this;
    }

    /**
     * Method to set the background of the document.
     *
     * @param  mixed $color
     * @return Pop\Pdf\Pdf
     */
    public function setBackgroundColor(ColorInterface $color)
    {
        $this->_backgroundColor = $color;
        return $this;
    }

    /**
     * Method to set the fill color of objects and text in the PDF.
     *
     * @param  mixed $color
     * @return Pop\Pdf\Pdf
     */
    public function setFillColor(ColorInterface $color)
    {
        $this->_fillColor = $color;

        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\n" . $this->_convertColor($color->getRed()) . " " . $this->_convertColor($color->getGreen()) . " " . $this->_convertColor($color->getBlue()) . " rg\n");

        return $this;
    }

    /**
     * Method to set the stroke color of paths in the PDF.
     *
     * @param  mixed $color
     * @return Pop\Pdf\Pdf
     */
    public function setStrokeColor(ColorInterface $color)
    {
        $this->_strokeColor = $color;

        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\n" . $this->_convertColor($color->getRed()) . " " . $this->_convertColor($color->getGreen()) . " " . $this->_convertColor($color->getBlue()) . " RG\n");

        return $this;
    }

    /**
     * Method to set the width and dash properties of paths in the PDF.
     *
     * @param  int $w
     * @param  int $dash_len
     * @param  int $dash_gap
     * @return Pop\Pdf\Pdf
     */
    public function setStrokeWidth($w = null, $dash_len = null, $dash_gap = null)
    {
        if ((null === $w) || ($w == false) || ($w == 0)) {
            $this->_stroke = false;
            $this->_strokeWidth = null;
            $this->_strokeDashLength = null;
            $this->_strokeDashGap = null;
        } else {
            $this->_stroke = true;
            $this->_strokeWidth = $w;
            $this->_strokeDashLength = $dash_len;
            $this->_strokeDashGap = $dash_gap;

            // Set stroke to the $w argument, or else default it to 1pt.
            $new_str = "\n{$w} w\n";

            // Set the dash properties of the stroke, or else default it to a solid line.
            $new_str .= ((null !== $dash_len) && (null !== $dash_gap)) ? "[{$dash_len} {$dash_gap}] 0 d\n" : "[] 0 d\n";

            $co_index = $this->_getContentObject();
            $this->_objects[$co_index]->setStream($new_str);
        }

        return $this;
    }

    /**
     * Method to set the text parameters for rendering text content.
     *
     * @param  int $c    (character spacing)
     * @param  int $w    (word spacing)
     * @param  int $h    (horz stretch)
     * @param  int $v    (vert stretch)
     * @param  int $rot  (rotation)
     * @param  int $rend (render flag, 0 - 7)
     * @throws Exception
     * @return Pop\Pdf\Pdf
     */
    public function setTextParams($c = 0, $w = 0, $h = 100, $v = 100, $rot = 0, $rend = 0)
    {
        // Check the rotation parameter.
        if (abs($rot) > 90) {
            throw new Exception($this->_lang->__('Error: The rotation parameter must be between -90 and 90 degrees.'));
        }

        // Check the render parameter.
        if ((!is_int($rend)) || (($rend > 7) || ($rend < 0))) {
            throw new Exception($this->_lang->__('Error: The render parameter must be an integer between 0 and 7.'));
        }

        // Set the text parameters.
        $this->_textParams['c'] = $c;
        $this->_textParams['w'] = $w;
        $this->_textParams['h'] = $h;
        $this->_textParams['v'] = $v;
        $this->_textParams['rot'] = $rot;
        $this->_textParams['rend'] = $rend;

        return $this;
    }

    /**
     * Method to add a font to the PDF.
     *
     * @param  string $font
     * @throws Exception
     * @return Pop\Pdf\Pdf
     */
    public function addFont($font, $embedOverride = false)
    {
        // Embed the font file.
        if (file_exists($font)) {
            $fontIndex = (count($this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts) == 0) ? 1 : count($this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts) + 1;
            $objectIndex = $this->_lastIndex($this->_objects) + 1;

            $fontParser = new Font($font, $fontIndex, $objectIndex, $this->_compress);

            if (!$fontParser->isEmbeddable() && !$embedOverride) {
                throw new Exception($this->_lang->__('Error: The font license does not allow for it to be embedded.'));
            } else {
                $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts[$fontParser->getFontName()] = $fontParser->getFontRef();

                $fontObjects = $fontParser->getObjects();

                foreach ($fontObjects as $key => $value) {
                    $this->_objects[$key] = $value;
                }

                $this->_lastFontName = $fontParser->getFontName();
            }
        // Else, use a standard font.
        } else {
            // Check to make sure the font is a standard PDF font.
            if (!array_key_exists($font, $this->_standard_fonts)) {
                throw new Exception($this->_lang->__('Error: That font is not contained within the standard PDF fonts.'));
            } else {
                // Set the font index.
                $ft_index = (count($this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts) == 0) ? 1 : count($this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts) + 1;

                // Set the font name and the next object index.
                $f = 'MF' . $ft_index;
                $i = $this->_lastIndex($this->_objects) + 1;

                // Add the font to the current page's fonts and add the font to _objects array.
                $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts[$font] = "/{$f} {$i} 0 R";
                $this->_objects[$i] = new Object("{$i} 0 obj\n<<\n    /Type /Font\n    /Subtype /Type1\n    /Name /{$f}\n    /BaseFont /{$font}\n    /Encoding /StandardEncoding\n>>\nendobj\n\n");

                $this->_lastFontName = $font;
            }
        }

        return $this;
    }

    /**
     * Method to add text to the PDF.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $size
     * @param  string $str
     * @param  string $font
     * @throws Exception
     * @return Pop\Pdf\Pdf
     */
    public function addText($x, $y, $size, $str, $font)
    {
        // Check to see if the font already exists on another page.
        $fontExists = false;

        foreach ($this->_pages as $value) {
            if (array_key_exists($font, $this->_objects[$value]->fonts)) {
                $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts[$font] = $this->_objects[$value]->fonts[$font];
                $fontObj = substr($this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts[$font], 1, (strpos(' ', $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts[$font]) + 3));
                $fontExists = true;
            }
        }

        // If the font does not already exist, add it.
        if (!$fontExists) {
            if (array_key_exists($font, $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts)) {
                $fontObj = substr($this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts[$font], 1, (strpos(' ', $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->fonts[$font]) + 3));
            } else {
                throw new Exception($this->_lang->__('Error: The font \'%1\' has not been added to the PDF.', $font));
            }
        }

        // Add the text to the current page's content stream.
        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\nBT\n    /{$fontObj} {$size} Tf\n    " . $this->_calcTextMatrix() . " {$x} {$y} Tm\n    " . $this->_textParams['c'] . " Tc " . $this->_textParams['w'] . " Tw " . $this->_textParams['rend'] . " Tr\n    ({$str})Tj\nET\n");

        return $this;
    }

    /**
     * Method to get the width and height of a string in a certain font. It returns
     * an array with the approximate width, height and offset baseline values.
     *
     * @param  string $str
     * @param  string $font
     * @param  int    $sz
     * @throws Exception
     * @return array
     */
    public function getStringSize($str, $font, $sz)
    {
        if (!array_key_exists($font, $this->_standard_fonts)) {
            throw new Exception($this->_lang->__('Error: That font is not contained within the standard PDF fonts.'));
        } else {
            // Calculate the approximate width, height and offset baseline values of the string at the certain font.
            $size = array();

            $size['width'] = round(($sz * $this->_standard_fonts[$font]['width_factor']) * strlen($str));
            $size['height'] = round($sz * $this->_standard_fonts[$font]['height_factor']);
            $size['baseline'] = round($sz / 3);

            return $size;
        }
    }

    /**
     * Method to add a line to the PDF.
     *
     * @param  int $x1
     * @param  int $y1
     * @param  int $x2
     * @param  int $y2
     * @return Pop\Pdf\Pdf
     */
    public function addLine($x1, $y1, $x2, $y2)
    {
        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\n{$x1} {$y1} m\n{$x2} {$y2} l\nS\n");

        return $this;
    }

    /**
     * Method to add a rectangle to the PDF.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addRectangle($x, $y, $w, $h = null, $fill = true)
    {
        if (null === $h) {
            $h = $w;
        }

        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\n{$x} {$y} {$w} {$h} re\n" . $this->_setStyle($fill) . "\n");

        return $this;
    }

    /**
     * Method to add a square to the PDF.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addSquare($x, $y, $w, $fill = true)
    {
        $this->addRectangle($x, $y, $w, $w, $fill);
        return $this;
    }

    /**
     * Method to add an ellipse to the PDF.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @param  int     $h
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addEllipse($x, $y, $w, $h = null, $fill = true)
    {
        if (null === $h) {
            $h = $w;
        }

        $x1 = $x + $w;
        $y1 = $y;

        $x2 = $x;
        $y2 = $y - $h;

        $x3 = $x - $w;
        $y3 = $y;

        $x4 = $x;
        $y4 = $y + $h;

        // Calculate coordinate number one's 2 bezier points.
        $coor1_bez1_x = $x1;
        $coor1_bez1_y = (round(0.55 * ($y2 - $y1))) + $y1;
        $coor1_bez2_x = $x1;
        $coor1_bez2_y = (round(0.45 * ($y1 - $y4))) + $y4;

        // Calculate coordinate number two's 2 bezier points.
        $coor2_bez1_x = (round(0.45 * ($x2 - $x1))) + $x1;
        $coor2_bez1_y = $y2;
        $coor2_bez2_x = (round(0.55 * ($x3 - $x2))) + $x2;
        $coor2_bez2_y = $y2;

        // Calculate coordinate number three's 2 bezier points.
        $coor3_bez1_x = $x3;
        $coor3_bez1_y = (round(0.55 * ($y2 - $y3))) + $y3;
        $coor3_bez2_x = $x3;
        $coor3_bez2_y = (round(0.45 * ($y3 - $y4))) + $y4;

        // Calculate coordinate number four's 2 bezier points.
        $coor4_bez1_x = (round(0.55 * ($x3 - $x4))) + $x4;
        $coor4_bez1_y = $y4;
        $coor4_bez2_x = (round(0.45 * ($x4 - $x1))) + $x1;
        $coor4_bez2_y = $y4;

        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\n{$x1} {$y1} m\n{$coor1_bez1_x} {$coor1_bez1_y} {$coor2_bez1_x} {$coor2_bez1_y} {$x2} {$y2} c\n{$coor2_bez2_x} {$coor2_bez2_y} {$coor3_bez1_x} {$coor3_bez1_y} {$x3} {$y3} c\n{$coor3_bez2_x} {$coor3_bez2_y} {$coor4_bez1_x} {$coor4_bez1_y} {$x4} {$y4} c\n{$coor4_bez2_x} {$coor4_bez2_y} {$coor1_bez2_x} {$coor1_bez2_y} {$x1} {$y1} c\n" . $this->_setStyle($fill) . "\n");

        return $this;
    }

    /**
     * Method to add a circle to the PDF.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addCircle($x, $y, $w, $fill = true)
    {
        $this->addEllipse($x, $y, $w, $w, $fill);
        return $this;
    }

    /**
     * Method to add a polygon to the image.
     *
     * @param  array $points
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addPolygon($points, $fill = true)
    {
        $i = 1;
        $polygon = null;

        foreach ($points as $coord) {
            if ($i == 1) {
                $polygon .= $coord['x'] . " " . $coord['y'] . " m\n";
            } else if ($i <= count($points)) {
                $polygon .= $coord['x'] . " " . $coord['y'] . " l\n";
            }
            $i++;
        }
        $polygon .= "h\n";

        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\n{$polygon}\n" . $this->_setStyle($fill) . "\n");

        return $this;
    }

    /**
     * Method to add an arc to the PDF.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addArc($x, $y, $start, $end, $w, $h = null, $fill = true)
    {
        if (null === $h) {
            $h = $w;
        }

        $sX = round($w * cos($start / 180 * pi()));
        $sY = round($h * sin($start / 180 * pi()));
        $eX = round($w * cos($end / 180 * pi()));
        $eY = round($h * sin($end / 180 * pi()));

        $centerPoint = array('x' => $x, 'y' => $y);
        $startPoint = array('x' => $x + $sX, 'y' => $y - $sY);
        $endPoint = array('x' => $x + $eX, 'y' => $y - $eY);

        $startQuad = $this->_getQuadrant($startPoint, $centerPoint);
        $endQuad = $this->_getQuadrant($endPoint, $centerPoint);

        $maskPoint1 = array('x' => ($x + $w + 50), 'y' => ($y - $h - 50));
        $maskPoint2 = array('x' => ($x - $w - 50), 'y' => ($y - $h - 50));
        $maskPoint3 = array('x' => ($x - $w - 50), 'y' => ($y + $h + 50));
        $maskPoint4 = array('x' => ($x + $w + 50), 'y' => ($y + $h + 50));

        $polyPoints = array($centerPoint, $startPoint);

        switch ($startQuad) {
            case 1:
                $polyPoints[] = $maskPoint1;
                if ($endQuad == 1) {
                    $polyPoints[] = $maskPoint4;
                    $polyPoints[] = $maskPoint3;
                    $polyPoints[] = $maskPoint2;
                    $polyPoints[] = array('x' => $endPoint['x'], 'y' => $maskPoint2['y']);
                } else if ($endQuad == 2) {
                    $polyPoints[] = $maskPoint4;
                    $polyPoints[] = $maskPoint3;
                    $polyPoints[] = $maskPoint2;
                } else if ($endQuad == 3) {
                    $polyPoints[] = $maskPoint4;
                    $polyPoints[] = $maskPoint3;
                } else if ($endQuad == 4) {
                    $polyPoints[] = $maskPoint4;
                }
                break;

            case 2:
                $polyPoints[] = $maskPoint2;
                if ($endQuad == 2) {
                    $polyPoints[] = $maskPoint1;
                    $polyPoints[] = $maskPoint4;
                    $polyPoints[] = $maskPoint3;
                    $polyPoints[] = array('x' => $maskPoint3['x'], 'y' => $endPoint['y']);
                } else if ($endQuad == 3) {
                    $polyPoints[] = $maskPoint1;
                    $polyPoints[] = $maskPoint4;
                    $polyPoints[] = $maskPoint3;
                } else if ($endQuad == 4) {
                    $polyPoints[] = $maskPoint1;
                    $polyPoints[] = $maskPoint4;
                } else if ($endQuad == 1) {
                    $polyPoints[] = $maskPoint1;
                }

                break;
            case 3:
                $polyPoints[] = $maskPoint3;
                if ($endQuad == 3) {
                    $polyPoints[] = $maskPoint2;
                    $polyPoints[] = $maskPoint1;
                    $polyPoints[] = $maskPoint4;
                    $polyPoints[] = array('x' => $endPoint['x'], 'y' => $maskPoint4['y']);
                } else if ($endQuad == 4) {
                    $polyPoints[] = $maskPoint2;
                    $polyPoints[] = $maskPoint1;
                    $polyPoints[] = $maskPoint4;
                } else if ($endQuad == 1) {
                    $polyPoints[] = $maskPoint2;
                    $polyPoints[] = $maskPoint1;
                } else if ($endQuad == 2) {
                    $polyPoints[] = $maskPoint2;
                }

                break;
            case 4:
                $polyPoints[] = $maskPoint4;
                if ($endQuad == 4) {
                    $polyPoints[] = $maskPoint3;
                    $polyPoints[] = $maskPoint2;
                    $polyPoints[] = $maskPoint1;
                    $polyPoints[] = array('x' => $maskPoint1['x'], 'y' => $endPoint['y']);
                } else if ($endQuad == 1) {
                    $polyPoints[] = $maskPoint3;
                    $polyPoints[] = $maskPoint2;
                    $polyPoints[] = $maskPoint1;
                } else if ($endQuad == 2) {
                    $polyPoints[] = $maskPoint3;
                    $polyPoints[] = $maskPoint2;
                } else if ($endQuad == 3) {
                    $polyPoints[] = $maskPoint3;
                }

                break;
        }

        $polyPoints[] = $endPoint;

        $this->addEllipse($x, $y, $w, $h, $fill);
        $this->addClippingPolygon($polyPoints, true);

        return $this;
    }

    /**
     * Method to open a new graphics state layer within the PDF.
     * Must be used in conjunction with the closeLayer() method.
     *
     * @return Pop\Pdf\Pdf
     */
    public function openLayer()
    {
        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\nq\n");

        return $this;
    }

    /**
     * Method to close a new graphics state layer within the PDF.
     * Must be used in conjunction with the openLayer() method.
     *
     * @return Pop\Pdf\Pdf
     */
    public function closeLayer()
    {
        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\nQ\n");

        return $this;
    }

    /**
     * Method to add a clipping rectangle to the PDF.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addClippingRectangle($x, $y, $w, $h = null)
    {
        $oldFillColor = $this->_fillColor;
        $oldStrokeColor = $this->_strokeColor;
        $oldStrokeWidth = $this->_strokeWidth;
        $oldStrokeDashLength = $this->_strokeDashLength;
        $oldStrokeDashGap = $this->_strokeDashGap;

        $this->setFillColor($this->_backgroundColor);
        $this->setStrokeWidth(false);

        $h = (null === $h) ? $w : $h;
        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\n{$x} {$y} {$w} {$h} re\nW\nF\n");

        $this->setFillColor($oldFillColor);
        if (null !== $oldStrokeColor) {
            $this->setStrokeColor($oldStrokeColor);
            $this->setStrokeWidth($oldStrokeWidth, $oldStrokeDashLength, $oldStrokeDashGap);
        }

        return $this;
    }

    /**
     * Method to add a clipping square to the PDF.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addClippingSquare($x, $y, $w)
    {
        $this->addClippingRectangle($x, $y, $w, $w);
        return $this;
    }

    /**
     * Method to add a clipping ellipse to the PDF.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @param  int     $h
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addClippingEllipse($x, $y, $w, $h = null)
    {
        $oldFillColor = $this->_fillColor;
        $oldStrokeColor = $this->_strokeColor;
        $oldStrokeWidth = $this->_strokeWidth;
        $oldStrokeDashLength = $this->_strokeDashLength;
        $oldStrokeDashGap = $this->_strokeDashGap;

        $this->setFillColor($this->_backgroundColor);
        $this->setStrokeWidth(false);

        if (null === $h) {
            $h = $w;
        }

        $x1 = $x + $w;
        $y1 = $y;

        $x2 = $x;
        $y2 = $y - $h;

        $x3 = $x - $w;
        $y3 = $y;

        $x4 = $x;
        $y4 = $y + $h;

        // Calculate coordinate number one's 2 bezier points.
        $coor1_bez1_x = $x1;
        $coor1_bez1_y = (round(0.55 * ($y2 - $y1))) + $y1;
        $coor1_bez2_x = $x1;
        $coor1_bez2_y = (round(0.45 * ($y1 - $y4))) + $y4;

        // Calculate coordinate number two's 2 bezier points.
        $coor2_bez1_x = (round(0.45 * ($x2 - $x1))) + $x1;
        $coor2_bez1_y = $y2;
        $coor2_bez2_x = (round(0.55 * ($x3 - $x2))) + $x2;
        $coor2_bez2_y = $y2;

        // Calculate coordinate number three's 2 bezier points.
        $coor3_bez1_x = $x3;
        $coor3_bez1_y = (round(0.55 * ($y2 - $y3))) + $y3;
        $coor3_bez2_x = $x3;
        $coor3_bez2_y = (round(0.45 * ($y3 - $y4))) + $y4;

        // Calculate coordinate number four's 2 bezier points.
        $coor4_bez1_x = (round(0.55 * ($x3 - $x4))) + $x4;
        $coor4_bez1_y = $y4;
        $coor4_bez2_x = (round(0.45 * ($x4 - $x1))) + $x1;
        $coor4_bez2_y = $y4;

        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\n{$x1} {$y1} m\n{$coor1_bez1_x} {$coor1_bez1_y} {$coor2_bez1_x} {$coor2_bez1_y} {$x2} {$y2} c\n{$coor2_bez2_x} {$coor2_bez2_y} {$coor3_bez1_x} {$coor3_bez1_y} {$x3} {$y3} c\n{$coor3_bez2_x} {$coor3_bez2_y} {$coor4_bez1_x} {$coor4_bez1_y} {$x4} {$y4} c\n{$coor4_bez2_x} {$coor4_bez2_y} {$coor1_bez2_x} {$coor1_bez2_y} {$x1} {$y1} c\nW\nF\n");

        $this->setFillColor($oldFillColor);
        if (null !== $oldStrokeColor) {
            $this->setStrokeColor($oldStrokeColor);
            $this->setStrokeWidth($oldStrokeWidth, $oldStrokeDashLength, $oldStrokeDashGap);
        }

        return $this;
    }

    /**
     * Method to add a clipping circle to the PDF.
     *
     * @param  int     $x
     * @param  int     $y
     * @param  int     $w
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addClippingCircle($x, $y, $w)
    {
        $this->addClippingEllipse($x, $y, $w, $w);
        return $this;
    }

    /**
     * Method to add a clipping polygon to the PDF.
     *
     * @param  array $points
     * @param  boolean $fill
     * @return Pop\Pdf\Pdf
     */
    public function addClippingPolygon($points)
    {
        $oldFillColor = $this->_fillColor;
        $oldStrokeColor = $this->_strokeColor;
        $oldStrokeWidth = $this->_strokeWidth;
        $oldStrokeDashLength = $this->_strokeDashLength;
        $oldStrokeDashGap = $this->_strokeDashGap;

        $this->setFillColor($this->_backgroundColor);
        $this->setStrokeWidth(false);

        $i = 1;
        $polygon = null;

        foreach ($points as $coord) {
            if ($i == 1) {
                $polygon .= $coord['x'] . " " . $coord['y'] . " m\n";
            } else if ($i <= count($points)) {
                $polygon .= $coord['x'] . " " . $coord['y'] . " l\n";
            }
            $i++;
        }
        $polygon .= "h\n";
        $polygon .= "W\n";

        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream("\n{$polygon}\nF\n");

        $this->setFillColor($oldFillColor);
        if (null !== $oldStrokeColor) {
            $this->setStrokeColor($oldStrokeColor);
            $this->setStrokeWidth($oldStrokeWidth, $oldStrokeDashLength, $oldStrokeDashGap);
        }

        return $this;
    }

    /**
     * Method to add a URL link to the PDF.
     *
     * @param  int    $x
     * @param  int    $y
     * @param  int    $w
     * @param  int    $h
     * @param  string $url
     * @return Pop\Pdf\Pdf
     */
    public function addUrl($x, $y, $w, $h, $url)
    {
        $x2 = $x + $w;
        $y2 = $y + $h;

        $i = $this->_lastIndex($this->_objects) + 1;

        // Add the annotation index to the current page's annotations and add the annotation to _objects array.
        $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->annots[] = $i;
        $this->_objects[$i] = new Object("{$i} 0 obj\n<<\n    /Type /Annot\n    /Subtype /Link\n    /Rect [{$x} {$y} {$x2} {$y2}]\n    /Border [0 0 0]\n    /A <</S /URI /URI ({$url})>>\n>>\nendobj\n\n");

        return $this;
    }

    /**
     * Method to add an internal link to the PDF.
     *
     * @param  int $x
     * @param  int $y
     * @param  int $w
     * @param  int $h
     * @param  int $X
     * @param  int $Y
     * @param  int $Z
     * @param  int $dest
     * @throws Exception
     * @return Pop\Pdf\Pdf
     */
    public function addLink($x, $y, $w, $h, $X, $Y, $Z, $dest = null)
    {
        $x2 = $x + $w;
        $y2 = $y + $h;

        $i = $this->_lastIndex($this->_objects) + 1;

        // Set the destination of the internal link, or default to the current page.
        if (null !== $dest) {
            if (!isset($this->_pages[$dest - 1])) {
                throw new Exception($this->_lang->__('Error: That page has not been defined.'));
            } else {
                $d = $this->_objects[$this->_pages[$dest - 1]]->index;
            }
        // Else, set the destination to the current page.
        } else {
            $d = $this->_objects[$this->_pages[$this->_curPage]]->index;
        }

        // Add the annotation index to the current page's annotations and add the annotation to _objects array.
        $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->annots[] = $i;
        $this->_objects[$i] = new Object("{$i} 0 obj\n<<\n    /Type /Annot\n    /Subtype /Link\n    /Rect [{$x} {$y} {$x2} {$y2}]\n    /Border [0 0 0]\n    /Dest [{$d} 0 R /XYZ {$X} {$Y} {$Z}]\n>>\nendobj\n\n");

        return $this;
    }

    /**
     * Method to add an image to the PDF.
     *
     * @param  string    $image
     * @param  int       $x
     * @param  int       $y
     * @param  int|float $scl
     * @throws Exception
     * @return Pop\Pdf\Pdf
     */
    public function addImage($image, $x, $y, $scl = null)
    {
        // Create image parser object
        $i = $this->_lastIndex($this->_objects) + 1;
        $imageParser = new Image($image, $x, $y, $i, $scl);

        $imageObjects = $imageParser->getObjects();

        foreach ($imageObjects as $key => $value) {
            $this->_objects[$key] = $value;
        }

        // Add the image to the current page's xobject array and content stream.
        $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->xobjs[] = $imageParser->getXObject();

        $co_index = $this->_getContentObject();
        $this->_objects[$co_index]->setStream($imageParser->getStream());

        return $this;
    }

    /**
     * Output the PDF directly to the browser.
     *
     * @param  boolean $download
     * @return void
     */
    public function output($download = false)
    {
        // Format and finalize the PDF.
        $this->finalize();
        parent::output($download);
    }

    /**
     * Save the PDF directly to the server.
     *
     * @param  string $to
     * @throws Exception
     * @return void
     */
    public function save($to = null, $append = false)
    {
        // Format and finalize the PDF.
        $this->finalize();
        parent::save($to, $append);

        return $this;
    }

    /**
     * Method to finalize the PDF.
     *
     * @return Pop\Pdf\Pdf
     */
    public function finalize()
    {
        $this->_output = null;

        // Define some variables and initialize the trailer.
        $numObjs = count($this->_objects) + 1;
        $this->_trailer = "xref\n0 {$numObjs}\n0000000000 65535 f \n";

        // Calculate the root object lead off.
        $byteLength = $this->_calcByteLength($this->_objects[$this->_root]);
        $this->_bytelength += $byteLength;
        $this->_trailer .= $this->_formatByteLength($this->_bytelength) . " 00000 n \n";
        $this->_output .= $this->_objects[$this->_root];

        // Loop through the rest of the objects, calculate their size and length for the xref table and add their data to the output.
        foreach ($this->_objects as $obj) {
            if ($obj->index != $this->_root) {
                if (($obj instanceof Object) && ($this->_compress) && (!$obj->isPalette()) && (!$obj->isCompressed())) {
                    $obj->compress();
                }
                $byteLength = $this->_calcByteLength($obj);
                $this->_bytelength += $byteLength;
                $this->_trailer .= $this->_formatByteLength($this->_bytelength) . " 00000 n \n";
                $this->_output .= $obj;
            }
        }

        // Finalize the trailer.
        $this->_trailer .= "trailer\n<</Size {$numObjs}/Root {$this->_root} 0 R/Info {$this->_info} 0 R>>\nstartxref\n" . ($this->_bytelength + 68) . "\n%%EOF";

        // Append the trailer to the final output.
        $this->_output .= $this->_trailer;

        // Write to the file.
        $this->write($this->_output);

        return $this;
    }

    /**
     * Method to return the current page's content object, or create one if necessary.
     *
     * @return int
     */
    protected function _getContentObject()
    {
        // If the page's current content object index is not set, create one.
        if (null === $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->curContent) {
            $coi = $this->_lastIndex($this->_objects) + 1;
            $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->content[] = $coi;
            $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->curContent = $coi;
            $this->_objects[$coi] = new Object($coi);
        // Else, set and return the page's current content object index.
        } else {
            $coi = $this->_objects[$this->_objects[$this->_pages[$this->_curPage]]->index]->curContent;
        }

        return $coi;
    }

    /**
     * Method to calculate text matrix.
     *
     * @return string
     */
    protected function _calcTextMatrix()
    {
        // Define some variables.
        $tm = '';
        $a = '';
        $b = '';
        $c = '';
        $d = '';
        $neg = null;

        // Determine is the rotate parameter is negative or not.
        $neg = ($this->_textParams['rot'] < 0) ? true : false;

        // Calculate the text matrix parameters.
        $rot = abs($this->_textParams['rot']);

        if (($rot >= 0) && ($rot <= 45)) {
            $factor = round(($rot / 45), 2);
            if ($neg) {
                $a = 1;
                $b = '-' . $factor;
                $c = $factor;
                $d = 1;
            } else {
                $a = 1;
                $b = $factor;
                $c = '-' . $factor;
                $d = 1;
            }
        } else if (($rot > 45) && ($rot <= 90)) {
            $factor = round(((90 - $rot) / 45), 2);
            if ($neg) {
                $a = $factor;
                $b = -1;
                $c = 1;
                $d = $factor;
            } else {
                $a = $factor;
                $b = 1;
                $c = -1;
                $d = $factor;
            }
        }

        // Adjust the text matrix parameters according to the horizontal and vertical scale parameters.
        if ($this->_textParams['h'] != 100) {
            $a = round(($a * ($this->_textParams['h'] / 100)), 2);
            $b = round(($b * ($this->_textParams['h'] / 100)), 2);
        }

        if ($this->_textParams['v'] != 100) {
            $c = round(($c * ($this->_textParams['v'] / 100)), 2);
            $d = round(($d * ($this->_textParams['v'] / 100)), 2);
        }

        // Set the text matrix and return it.
        $tm = "{$a} {$b} {$c} {$d}";

        return $tm;
    }


    /**
     * Method to calculate which quadrant a point is in.
     *
     * @param  array $point
     * @param  array $center
     * @return int
     */
    protected function _getQuadrant($point, $center)
    {
        $quad = 0;

        if ($point['x'] >= $center['x']) {
            $quad = ($point['y'] >= $center['y']) ? 4 : 1;
        } else {
            $quad = ($point['y'] >= $center['y']) ? 3 : 2;
        }

        return $quad;
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

    /**
     * Method to format byte length.
     *
     * @param  int|string $num
     * @return string
     */
    protected function _formatByteLength($num)
    {
        return sprintf('%010d', $num);
    }

    /**
     * Method to convert color.
     *
     * @param  int|string $color
     * @return float
     */
    protected function _convertColor($color)
    {
        $c = round(($color / 256), 2);
        return $c;
    }

    /**
     * Method to set the fill/stroke style.
     *
     * @param  boolean $fill
     * @return string
     */
    protected function _setStyle($fill)
    {
        $style = null;

        if (($fill) && ($this->_stroke)) {
            $style = 'B';
        } else if ($fill) {
            $style = 'F';
        } else {
            $style = 'S';
        }

        return $style;
    }

    /**
     * Method to return the last object index.
     *
     * @param  array $arr
     * @throws Exception
     * @return int
     */
    protected function _lastIndex($arr)
    {
        if (!is_array($arr)) {
            throw new Exception($this->_lang->__('Error: The argument passed must be an array.'));
        } else {
            $objs = array_keys($arr);
            sort($objs);

            foreach ($objs as $obj) {
                $last = $obj;
            }

            return $last;
        }
    }

}
