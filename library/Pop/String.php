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
 * @package    Pop_String
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_String
 *
 * @category   Pop
 * @package    Pop_String
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_String
{

    /**
     * String property
     * @var string
     */
    protected $_string;

    /**
     * Constructor
     *
     * Instantiate the string object.
     *
     * @param  string $str
     * @return void
     */
    public function __construct($str = null)
    {
        $this->_string = (!is_null($str)) ? $str : '';
    }

    /**
     * Method to return the string value for printing output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->_string;
    }

    /**
     * Static method to instantiate the string object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $str
     * @return Pop_String
     */
    public static function factory($str = null)
    {
        return new self($str);
    }

    /**
     * Method to return the length of the string.
     *
     * @return int
     */
    public function length()
    {
        return strlen($this->_string);
    }

    /**
     * Method to return the position of the character(s) in the string.
     *
     * @param  string $char
     * @param  int    $offset
     * @return int
     */
    public function pos($char, $offset = 0)
    {
        return strpos($this->_string, $char, $offset);
    }

    /**
     * Method to return the position of the case-insensitive character(s) in the string.
     *
     * @param  string $char
     * @param  int    $offset
     * @return int
     */
    public function ipos($char, $offset = 0)
    {
        return stripos($this->_string, $char, $offset);
    }

    /**
     * Method to return the last position of the character(s) in the string.
     *
     * @param  string $char
     * @param  int    $offset
     * @return int
     */
    public function rpos($char, $offset = 0)
    {
        return strrpos($this->_string, $char, $offset);
    }

    /**
     * Method to return the last position of the case-insensitive character(s) in the string.
     *
     * @param  string $char
     * @param  int    $offset
     * @return int
     */
    public function ripos($char, $offset = 0)
    {
        return strripos($this->_string, $char, $offset);
    }

    /**
     * Method to return an array of parts of the string based on the delimiter.
     *
     * @param  string $delimiter
     * @return array
     */
    public function split($delimiter)
    {
        return explode($delimiter, $this->_string);
    }

    /**
     * Method to glue an array of parts togeter into a string based on the delimiter.
     *
     * @param  array  $ary
     * @param  string $delimiter
     * @return Pop_String
     */
    public function glue($ary, $delimiter)
    {
        $this->_string = implode($delimiter, $ary);
        return $this;
    }

    /**
     * Method to convert the string to all lowercase and return the newly edited string.
     *
     * @return Pop_String
     */
    public function lower()
    {
        $this->_string = strtolower($this->_string);
        return $this;
    }

    /**
     * Method to convert the first letter of each word in the string to uppercase and return the newly edited string.
     *
     * @return Pop_String
     */
    public function upper()
    {
        $this->_string = ucwords($this->_string);
        return $this;
    }

    /**
     * Method to convert the string to all uppercase and return the newly edited string.
     *
     * @return Pop_String
     */
    public function upperall()
    {
        $this->_string = strtoupper($this->_string);
        return $this;
    }

    /**
     * Method to convert the first letter of a string to uppercase and return the newly edited string.
     *
     * @return Pop_String
     */
    public function upperfirst()
    {
        $this->_string = ucfirst($this->_string);
        return $this;
    }

    /**
     * Method to return a substring of the string.
     *
     * @param  int $start
     * @param  int $len
     * @return Pop_String
     */
    public function sub($start, $len = null)
    {
        $this->_string = (!is_null($len)) ? substr($this->_string, $start, $len) : substr($this->_string, $start);
        return $this;
    }

    /**
     * Method to return a substring of the string between two delimiters.
     *
     * @param  int $start
     * @param  int $end
     * @return Pop_String
     */
    public function between($start, $end)
    {
        $startPos = (strpos($this->_string, $start) !== false) ? (strpos($this->_string, $start) + strlen($start)) : 0;

        $this->_string = substr($this->_string, $startPos);
        $this->_string = (strpos($this->_string, $end) !== false) ? substr($this->_string, 0, (strpos($this->_string, $end))) : $this->_string;

        return $this;
    }

    /**
     * Method to replace the substring that was passed as an argument and return the newly edited string.
     *
     * @param  string $search
     * @param  string $replace
     * @return Pop_String
     */
    public function replace($search, $replace)
    {
        $this->_string = str_replace($search, $replace, $this->_string);
        return $this;
    }

    /**
     * Method to replace (case-insensitive) the substring using what was passed as an argument and return the newly edited string.
     *
     * @param  string $search
     * @param  string $replace
     * @return Pop_String
     */
    public function ireplace($search, $replace)
    {
        $this->_string = str_ireplace($search, $replace, $this->_string);
        return $this;
    }

    /**
     * Method to preg_replace the substring using what was passed as an argument and return the newly edited string.
     *
     * @param  string $pattern
     * @param  string $replace
     * @return Pop_String
     */
    public function preplace($pattern, $replace)
    {
        $this->_string = preg_replace($pattern, $replace, $this->_string);
        return $this;
    }

    /**
     * Method to preg_replace the substring using what was passed as an argument and return the newly edited string.
     *
     * @param  string $pattern
     * @param  int    $flags
     * @param  int    $offset
     * @return Pop_String
     */
    public function pmatch($pattern, $flags = 0, $offset = 0)
    {
        $matches = array();
        preg_match_all($pattern, $this->_string, $matches, $flags, $offset);
        return $matches;
    }

    /**
     * Method to trim the whitespace at the beginning and end of the string and return the newly edited string.
     *
     * @param  string $chars
     * @return Pop_String
     */
    public function trim($chars = null)
    {
        $this->_string = (!is_null($chars)) ? trim($this->_string, $chars) : trim($this->_string);
        return $this;
    }

    /**
     * Method to add slashes to the string and return the newly edited string.
     *
     * @return Pop_String
     */
    public function add()
    {
        $this->_string = addslashes($this->_string);
        return $this;
    }

    /**
     * Method to strip slashes from the string and return the newly edited string.
     *
     * @return Pop_String
     */
    public function strip()
    {
        $this->_string = stripslashes($this->_string);
        return $this;
    }

    /**
     * Method to strip HTML tags from the string and return the newly edited string.
     *
     * @param  string $allowed
     * @return Pop_String
     */
    public function striptags($allowed = null)
    {
        $this->_string = (!is_null($allowed)) ? strip_tags($this->_string, $allowed) : strip_tags($this->_string);
        return $this;
    }

    /**
     * Method to simulate escaping a string for DB entry, much like mysql_real_escape_string(), but without requiring a DB connection.
     * The parameter $all is boolean flag that, when set to true, causes the '%' and '_' characters to be escaped as well.
     *
     * @param  boolean $all
     * @return Pop_String
     */
    public function escape($all = false)
    {
        $this->_string = str_replace('\\', '\\\\', $this->_string);
        $this->_string = str_replace("\n", "\\n", $this->_string);
        $this->_string = str_replace("\r", "\\r", $this->_string);
        $this->_string = str_replace("\x00", "\\x00", $this->_string);
        $this->_string = str_replace("\x1a", "\\x1a", $this->_string);
        $this->_string = str_replace('\'', '\\\'', $this->_string);
        $this->_string = str_replace('"', '\"', $this->_string);

        if ($all) {
            $this->_string = str_replace('%', '\%', $this->_string);
            $this->_string = str_replace('_', '\_', $this->_string);
        }

        return $this;
    }

    /**
     * Method to clean the string of any of the standard MS Word based characters
     *
     * @param  boolean $html
     * @return Pop_String
     */
    public function msClean($html = false)
    {
        if ($html) {
            $apos = "&#39;";
            $quot = "&#34;";
        } else {
            $apos = "'";
            $quot = '"';
        }

        $this->_string = str_replace(chr(146), $apos, $this->_string);
        $this->_string = str_replace(chr(147), $quot, $this->_string);
        $this->_string = str_replace(chr(148), $quot, $this->_string);
        $this->_string = str_replace(chr(150), "&#150;", $this->_string);
        $this->_string = str_replace(chr(133), "...", $this->_string);

        return $this;
    }

    /**
     * Method to convert newlines from DOS to UNIX
     *
     * @param  boolean $html
     * @return Pop_String
     */
    public function dos2unix()
    {
        $this->_string = str_replace(chr(13) . chr(10), chr(10), $this->_string);
        return $this;
    }

    /**
     * Method to convert newlines from UNIX to DOS
     *
     * @return Pop_String
     */
    public function unix2dos()
    {
        $this->_string = str_replace(chr(10), chr(13) . chr(10), $this->_string);
        return $this;
    }

    /**
     * Method to convert newlines in the string to <br /> tags and return the newly edited string.
     *
     * @return Pop_String
     */
    public function br()
    {
        $this->_string = nl2br($this->_string);
        return $this;
    }

    /**
     * Method to perform a word wrap on a string.
     *
     * @param  string  $len
     * @param  string  $delimiter
     * @param  boolean $cut
     * @return Pop_String
     */
    public function wrap($len, $delimiter = "\n", $cut = false)
    {
        $this->_string = wordwrap($this->_string, $len, $delimiter, $cut);
        return $this;
    }

    /**
     * Method to convert special characters in the string to properly formatted HTML entities and return the newly edited string.
     *
     * @return Pop_String
     */
    public function html()
    {
        $this->_string = htmlentities($this->_string, ENT_QUOTES, 'UTF-8');
        return $this;
    }

    /**
     * Method to convert formatted HTML entities in the string back into special characters and return the newly edited string.
     *
     * @return Pop_String
     */
    public function dehtml()
    {
        $this->_string = html_entity_decode($this->_string, ENT_QUOTES, 'UTF-8');
        return $this;
    }

    /**
     * Method to convert the string into an SEO-friendly slug.
     *
     * @param  string $sep
     * @return Pop_String
     */
    public function slug($sep = null)
    {
        if (strlen($this->_string) > 0) {
            if (!is_null($sep)) {
                $strAry = explode($sep, $this->_string);
                $tmpStrAry = array();

                foreach ($strAry as $value) {
                    $str = strtolower($value);
                    $str = str_replace('&', 'and', $str);
                    $str = preg_replace('/([^a-zA-Z0-9 \-\/])/', '', $str);
                    $str = str_replace('/', '-', $str);
                    $str = str_replace(' ', '-', $str);
                    $str = preg_replace('/-*-/', '-', $str);
                    $tmpStrAry[] = $str;
                }

                $this->_string = '/' . implode('/', $tmpStrAry);
                $this->_string = str_replace('/-', '/', $this->_string);
                $this->_string = str_replace('-/', '/', $this->_string);
            } else {
                $this->_string = strtolower($this->_string);
                $this->_string = str_replace('&', 'and', $this->_string);
                $this->_string = preg_replace('/([^a-zA-Z0-9 \-\/])/', '', $this->_string);
                $this->_string = str_replace('/', '-', $this->_string);
                $this->_string = str_replace(' ', '-', $this->_string);
                $this->_string = preg_replace('/-*-/', '-', $this->_string);
                $this->_string = '/' . $this->_string;
            }

            return $this;
        } else {
            $this->_string = '';
            return $this;
        }
    }

    /**
     * Method to convert any links in the string to clickable HTML links.
     *
     * @param  boolean $tar
     * @return Pop_String
     */
    public function links($tar = false)
    {
        $target = ($tar == true) ? 'target="_blank" ' : '';

        $this->_string = preg_replace('/[f|ht]+tp:\/\/[^\s]*/', '<a href="$0">$0</a>', $this->_string);
        $this->_string = preg_replace('/\s[\w]+[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,4})/', ' <a href="http://$0">$0</a>', $this->_string);
        $this->_string = preg_replace('/[a-zA-Z0-9\.\-\_+%]+@[a-zA-Z0-9\-\_\.]+\.[a-zA-Z]{2,4}/', '<a href="mailto:$0">$0</a>', $this->_string);
        $this->_string = str_replace('href="http:// ', 'href="http://', $this->_string);
        $this->_string = str_replace('"> ', '">', $this->_string);
        $this->_string = str_replace('<a ', '<a ' . $target, $this->_string);

        return $this;
    }

    /**
     * Method to return a date-formatted string.
     *
     * @param  string $format
     * @return Pop_String
     */
    public function date($format = 'm/d/Y')
    {
        $this->_string = date($format, strtotime($this->_string));
        return $this;
    }

    /**
     * Method to generate a random alphanumeric string of a predefined length.
     *
     * @param  int     $len
     * @param  boolean $caps
     * @return Pop_String
     */
    public function random($len, $caps = false)
    {
        // Array of alphanumeric characters. The O, 0, I and 1 have been removed to eliminate confusion.
        $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        for ($i = 0; $i < $len; $i++) {
            $num = (rand(1, strlen($chars)) - 1);
            if ($caps) {
                $this->_string .= strtoupper($chars[$num]);
            } else {
                $this->_string .= $chars[$num];
            }
        }

        return $this;
    }

    /**
     * Method to convert the string from under_score to camelCase format
     *
     * @return Pop_String
     */
    public function toCamelcase()
    {
        $delim = (strpos($this->_string, '_') !== false) ? '_' : '-';

        $strAry = explode($delim, $this->_string);
        $camelCase = null;
        $i = 0;

        foreach ($strAry as $word) {
            if ($i == 0) {
                $camelCase .= $word;
            } else {
                $camelCase .= ucfirst($word);
            }
            $i++;
        }

        $this->_string = $camelCase;

        return $this;
    }

    /**
     * Method to convert the string from camelCase to under_score format
     *
     * @return Pop_String
     */
    public function toUnderscore()
    {
        $strAry = str_split($this->_string);
        $under_score = null;
        $i = 0;

        foreach ($strAry as $chr) {
            if ($i == 0) {
                $under_score .= strtolower($chr);
            } else {
                $under_score .= (ctype_upper($chr)) ? ('_' . strtolower($chr)) : $chr;
            }
            $i++;
        }

        $this->_string = $under_score;

        return $this;
    }

    /**
     * Method to convert the string from camelCase to hyphenated format
     *
     * @return Pop_String
     */
    public function toHyphen()
    {
        $strAry = str_split($this->_string);
        $hyphenated = null;
        $i = 0;

        foreach ($strAry as $chr) {
            if ($i == 0) {
                $hyphenated .= strtolower($chr);
            } else {
                $hyphenated .= (ctype_upper($chr)) ? ('-' . strtolower($chr)) : $chr;
            }
            $i++;
        }

        $this->_string = $hyphenated;

        return $this;
    }

}
