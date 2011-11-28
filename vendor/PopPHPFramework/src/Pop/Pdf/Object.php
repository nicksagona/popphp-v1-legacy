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
namespace Pop\Pdf;
use Pop\Archive\Archive;

class Object
{

    /**
     * PDF object index
     * @var int
     */
    public $index = null;

    /**
     * PDF object data
     * @var string
     */
    protected $_data = null;

    /**
     * PDF object definition
     * @var string
     */
    protected $_def = null;

    /**
     * PDF object stream
     * @var string
     */
    protected $_stream = null;

    /**
     * Compression property
     * @var boolean
     */
    protected $_compress = false;

    /**
     * Compressed flag property
     * @var boolean
     */
    protected $_isCompressed = false;

    /**
     * Palette object property
     * @var boolean
     */
    protected $_isPalette = false;

    /**
     * Constructor
     *
     * Instantiate a PDF object.
     *
     * @param  int|string $i
     * @return void
     */
    public function __construct($i)
    {
        // Use default settings for a new PDF object.
        if (is_int($i)) {
            $this->index = $i;
            $this->_data = "\n[{obj_index}] 0 obj\n[{obj_def}]\n[{obj_stream}]\nendobj\n\n";
        } else if (is_string($i)) {
            // Else, determine the object index.
            $this->index = substr($i, 0, strpos($i, ' '));

            // Determine the objects definition and stream, if applicable.
            $s = substr($i, (strpos($i, ' obj') + 4));
            $s = substr($s, 0, strpos($s, 'endobj'));
            if (strpos($s, 'stream') !== false) {
                $def = substr($s, 0, strpos($s, 'stream'));
                $str = substr($s, (strpos($s, 'stream') + 6));
                $str = substr($str, 0, strpos($str, 'endstream'));
                $this->define($def);
                $this->setStream($str);
            } else {
                $this->define($s);
            }

            $this->_data = "\n[{obj_index}] 0 obj\n[{obj_def}]\n[{obj_stream}]\nendobj\n\n";
        }
    }

    /**
     * Method to print the PDF object.
     *
     * @return string
     */
    public function __toString()
    {
        $matches = array();

        // Set the content stream.
        $stream = (null !== $this->_stream) ? "stream" . $this->_stream . "endstream\n" : '';

        // Set up the Length definition.
        if (strpos($this->_def, '/Length ') !== false) {
            preg_match('/\/Length\s\d*/', $this->_def, $matches);
            if (isset($matches[0])) {
                $len = $matches[0];
                $len = str_replace('/Length', '', $len);
                $len = str_replace(' ', '', $len);
                $this->_def = str_replace($len, '[{byte_length}]', $this->_def);
            }
        } else {
            $this->_def .= "<</Length [{byte_length}]>>\n";
        }

        // Calculate the byte length of the content stream and swap out the placeholders.
        $byteLength = (($this->_compress) && (function_exists('gzcompress')) && (strpos($this->_def, ' /Image') === false) && (strpos($this->_def, '/FlateDecode') === false)) ? $this->_calcByteLength($this->_stream) . " /Filter /FlateDecode" : $this->_calcByteLength($this->_stream);
        $data = str_replace('[{obj_index}]', $this->index, $this->_data);
        $data = str_replace('[{obj_stream}]', $stream, $data);
        $data = str_replace('[{obj_def}]', $this->_def, $data);
        $data = str_replace('[{byte_length}]', $byteLength, $data);

        // Clear Length definition if it is zero.
        if (strpos($data, '<</Length 0>>') !== false) {
            $data = str_replace('<</Length 0>>', '', $data);
        }

        return $data;
    }

    /**
     * Method to define the PDF object.
     *
     * @param  string $str
     * @return void
     */
    public function define($str)
    {
        $this->_def = $str;
    }

    /**
     * Method to return the PDF object definition.
     *
     * @return string
     */
    public function getDef()
    {
        return $this->_def;
    }

    /**
     * Method to set the stream the PDF object.
     *
     * @param  string $str
     * @return void
     */
    public function setStream($str)
    {
        $this->_stream .= $str;
    }

    /**
     * Method to return the PDF object stream.
     *
     * @return string
     */
    public function getStream()
    {
        return $this->_stream;
    }

    /**
     * Method to compress the PDF object.
     *
     * @return void
     */
    public function compress()
    {
        if (($this->_stream != '') && (function_exists('gzcompress')) && (strpos($this->_def, ' /Image') === false) && (strpos($this->_def, '/FlateDecode') === false)) {
            $this->_compress = true;
            $this->_stream = "\n" . Archive::compress($this->_stream) . "\n";
            $this->_isCompressed = true;
        }
    }


    /**
     * Method to determine whether or not the PDF object is compressed.
     *
     * @return boolean
     */
    public function isCompressed()
    {
        return $this->_isCompressed;
    }

    /**
     * Method to set whether the PDF object is a palette object.
     *
     * @param  boolean $is
     * @return void
     */
    public function setPalette($is)
    {
        $this->_isPalette = $is;
    }

    /**
     * Method to get whether the PDF object is a palette object.
     *
     * @return boolean
     */
    public function isPalette()
    {
        return $this->_isPalette;
    }

    /**
     * Method to get the PDF object byte length.
     *
     * @param  string $str
     * @return void
     */
    public function getByteLength()
    {
        return $this->_calcByteLength($this);
    }

    /**
     * Method to calculate the byte length.
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
