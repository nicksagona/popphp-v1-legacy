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
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */

/**
 * @namespace
 */
namespace Pop\Font;
use Pop\Font\Font;

class Type1 extends Font
{

    /**
     * Type1 dictionary
     * @var string
     */
    public $dict = null;

    /**
     * Type1 data
     * @var string
     */
    public $data = null;

    /**
     * Type1 data in hex format
     * @var string
     */
    public $hex = null;

    /**
     * Type1 encoding
     * @var string
     */
    public $encoding = null;

    /**
     * Constructor
     *
     * Instantiate a Type1 font file object based on a pre-existing font file on disk.
     *
     * @param  string $font
     * @return void
     */
    public function __construct($font)
    {
        parent::__construct($font);
        $this->_parseDictionary();
    }

    /**
     * Method to parse the Type1 dictionary of the Type1 font file.
     *
     * @return void
     */
    protected function _parseDictionary()
    {
        $info = array();
        $data = $this->read();
        $this->dict = substr($data, stripos($data, 'FontDirectory'));
        $this->dict = substr($this->dict, 0, stripos($this->dict, 'currentdict end'));

        $this->data = substr($data, (stripos($data, 'currentfile eexec') + 18));
        $this->data = substr($this->data, 0, (stripos($this->data, '0000000000000000000000000000000000000000000000000000000000000000') - 1));

        $this->_convertToHex();

        if (stripos($this->dict, '/FullName') !== false) {
            $name = substr($this->dict, (stripos($this->dict, '/FullName ') + 10));
            $name = trim(substr($name, 0, stripos($name, 'readonly def')));
            $info['fullName'] = $this->_strip($name);
        }

        if (stripos($this->dict, '/FamilyName') !== false) {
            $family = substr($this->dict, (stripos($this->dict, '/FamilyName ') + 12));
            $family = trim(substr($family, 0, stripos($family, 'readonly def')));
            $info['fontFamily'] = $this->_strip($family);
        }

        if (stripos($this->dict, '/FontName') !== false) {
            $font = substr($this->dict, (stripos($this->dict, '/FontName ') + 10));
            $font = trim(substr($font, 0, stripos($font, 'def')));
            $info['postscriptName'] = $this->_strip($font);
        }

        if (stripos($this->dict, '/version') !== false) {
            $version = substr($this->dict, (stripos($this->dict, '/version ') + 9));
            $version = trim(substr($version, 0, stripos($version, 'readonly def')));
            $info['version'] = $this->_strip($version);
        }

        if (stripos($this->dict, '/UniqueId') !== false) {
            $matches = array();
            preg_match('/UniqueID\s\d/', $this->dict, $matches, PREG_OFFSET_CAPTURE);
            $id = substr($this->dict, ($matches[0][1] + 9));
            $id = trim(substr($id, 0, stripos($id, 'def')));
            $info['uniqueId'] = $this->_strip($id);
        }

        if (stripos($this->dict, '/Notice') !== false) {
            $copyright = substr($this->dict, (stripos($this->dict, '/Notice ') + 8));
            $copyright = substr($copyright, 0, stripos($copyright, 'readonly def'));
            $copyright = str_replace('\\(', '(', $copyright);
            $copyright = trim(str_replace('\\)', ')', $copyright));
            $info['copyright'] = $this->_strip($copyright);
        }

        $this->info = new \ArrayObject($info, \ArrayObject::ARRAY_AS_PROPS);

        if (stripos($this->dict, '/FontBBox') !== false) {
            $bbox = substr($this->dict, (stripos($this->dict, '/FontBBox') + 9));
            $bbox = substr($bbox, 0, stripos($bbox, 'readonly def'));
            $bbox = trim($this->_strip($bbox));
            $bboxAry = explode(' ', $bbox);
            $this->bBox = new \ArrayObject(array('xMin' => $bboxAry[0],
                                                'yMin' => $bboxAry[1],
                                                'xMax' => $bboxAry[2],
                                                'yMax' => $bboxAry[3]), \ArrayObject::ARRAY_AS_PROPS);
        }

        if (stripos($this->dict, '/ascent') !== false) {
            $ascent = substr($this->dict, (stripos($this->dict, '/ascent ') + 8));
            $this->ascent = trim(substr($ascent, 0, stripos($ascent, 'def')));
        }

        if (stripos($this->dict, '/descent') !== false) {
            $descent = substr($this->dict, (stripos($this->dict, '/descent ') + 9));
            $this->descent = trim(substr($descent, 0, stripos($descent, 'def')));
        }

        if (stripos($this->dict, '/ItalicAngle') !== false) {
            $italic = substr($this->dict, (stripos($this->dict, '/ItalicAngle ') + 13));
            $this->italicAngle = trim(substr($italic, 0, stripos($italic, 'def')));
        }

        if (stripos($this->dict, '/em') !== false) {
            $units = substr($this->dict, (stripos($this->dict, '/em ') + 4));
            $this->unitsPerEm = trim(substr($units, 0, stripos($units, 'def')));
        }

        if (stripos($this->dict, '/isFixedPitch') !== false) {
            $fixed = substr($this->dict, (stripos($this->dict, '/isFixedPitch ') + 14));
            $fixed = trim(substr($fixed, 0, stripos($fixed, 'def')));
            $this->flags->isFixedPitch = ($fixed == 'true') ? true : false;
        }

        if (stripos($this->dict, '/ForceBold') !== false) {
            $force = substr($this->dict, (stripos($this->dict, '/ForceBold ') + 11));
            $force = trim(substr($force, 0, stripos($force, 'def')));
            $this->flags->isForceBold = ($force == 'true') ? true : false;
        }

        if (stripos($this->dict, '/Encoding') !== false) {
            $enc = substr($this->dict, (stripos($this->dict, '/Encoding ') + 10));
            $this->encoding = trim(substr($enc, 0, stripos($enc, 'def')));
        }
    }

    /**
     * Method to convert the data string to hex.
     *
     * @return void
     */
    protected function _convertToHex()
    {
        $ary = str_split($this->data);
        $length = count($ary);

        for ($i = 0; $i < $length; $i++) {
            $this->hex .= bin2hex($ary[$i]);
        }
    }

    /**
     * Method to strip parentheses et al from a string.
     *
     * @param  string $str
     * @return string
     */
    protected function _strip($str)
    {
        // Strip parentheses
        if (substr($str, 0, 1) == '(') {
            $str = substr($str, 1);
        }
        if (substr($str, -1) == ')') {
            $str = substr($str, 0, -1);
        }
        // Strip curly brackets
        if (substr($str, 0, 1) == '{') {
            $str = substr($str, 1);
        }
        if (substr($str, -1) == '}') {
            $str = substr($str, 0, -1);
        }
        // Strip leading slash
        if (substr($str, 0, 1) == '/') {
            $str = substr($str, 1);
        }

        return $str;
    }

}
