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
 * @package    Pop_Filter
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Filter;

/**
 * @category   Pop
 * @package    Pop_Filter
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class String
{

    /**
     * String property
     * @var string
     */
    protected $_string = null;

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
        $this->_string = (null !== $str) ? $str : '';
    }

    /**
     * Static method to instantiate the string object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $str
     * @return Pop\Filter\String
     */
    public static function factory($str = null)
    {
        return new self($str);
    }

    /**
     * Method to convert the string to all lowercase and
     * return the newly edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function lower()
    {
        $this->_string = strtolower($this->_string);
        return $this;
    }

    /**
     * Method to convert the first letter of each word in the string
     * to uppercase and return the newly edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function upper()
    {
        $this->_string = strtoupper($this->_string);
        return $this;
    }

    /**
     * Method to convert the string to all uppercase and
     * return the newly edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function upperWords()
    {
        $this->_string = ucwords($this->_string);
        return $this;
    }

    /**
     * Method to convert the first letter of a string to uppercase
     * and return the newly edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function upperFirst()
    {
        $this->_string = ucfirst($this->_string);
        return $this;
    }

    /**
     * Method to return a substring of the string between two delimiters.
     *
     * @param  int $start
     * @param  int $end
     * @return Pop\Filter\String
     */
    public function between($start, $end)
    {
        $startPos = (strpos($this->_string, $start) !== false)
            ? (strpos($this->_string, $start) + strlen($start)) : 0;

        $this->_string = substr($this->_string, $startPos);
        $this->_string = (strpos($this->_string, $end) !== false)
            ? substr($this->_string, 0, (strpos($this->_string, $end))) : $this->_string;

        return $this;
    }

    /**
     * Method to replace the substring that was passed as an argument
     * and return the newly edited string filter object.
     *
     * @param  array|string  $search
     * @param  string        $replace
     * @param  boolean       $caseSenstive
     * @return Pop\Filter\String
     */
    public function replace($search, $replace = null, $caseSenstive = true)
    {
        if (is_array($search)) {
            foreach ($search as $value) {
                if (is_array($value) && isset($value[0]) && isset($value[1])) {
                    if ($caseSenstive) {
                        $this->_string = str_replace($value[0], $value[1], $this->_string);
                    } else {
                        $this->_string = str_ireplace($value[0], $value[1], $this->_string);
                    }
                }
            }
        } else {
            if ($caseSenstive) {
                $this->_string = str_replace($search, $replace, $this->_string);
            } else {
                $this->_string = str_ireplace($search, $replace, $this->_string);
            }
        }
        return $this;
    }

    /**
     * Method to preg_replace the substring using what was passed
     * as an argument and return the newly edited string filter object.
     *
     * @param  string $pattern
     * @param  string $replace
     * @return Pop\Filter\String
     */
    public function pregReplace($pattern, $replace)
    {
        $this->_string = preg_replace($pattern, $replace, $this->_string);
        return $this;
    }

    /**
     * Method to trim the whitespace at the beginning and end of the string
     * and return the newly edited string filter object.
     *
     * @param  string $chars
     * @return Pop\Filter\String
     */
    public function trim($chars = null)
    {
        $this->_string = (null !== $chars)
            ? trim($this->_string, $chars) : trim($this->_string);
        return $this;
    }

    /**
     * Method to add slashes to the string and return the newly
     * edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function add()
    {
        $this->_string = addslashes($this->_string);
        return $this;
    }

    /**
     * Method to strip slashes from the string and return the newly
     * edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function strip()
    {
        $this->_string = stripslashes($this->_string);
        return $this;
    }

    /**
     * Method to strip HTML tags from the string and return the
     * newly edited string filter object.
     *
     * @param  string $allowed
     * @return Pop\Filter\String
     */
    public function striptags($allowed = null)
    {
        $this->_string = (null !== $allowed)
            ? strip_tags($this->_string, $allowed) : strip_tags($this->_string);
        return $this;
    }

    /**
     * Method to convert special characters in the string to properly
     * formatted HTML entities and return the newly edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function html()
    {
        $this->_string = htmlentities($this->_string, ENT_QUOTES, 'UTF-8');
        return $this;
    }

    /**
     * Method to convert formatted HTML entities in the string back into
     * special characters and return the newly edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function dehtml()
    {
        $this->_string = html_entity_decode($this->_string, ENT_QUOTES, 'UTF-8');
        return $this;
    }

    /**
     * Method to convert newlines in the string to <br /> tags and return
     * the newly edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function br()
    {
        $this->_string = nl2br($this->_string);
        return $this;
    }

    /**
     * Method to simulate escaping a string for DB entry, much like
     * mysql_real_escape_string(), but without requiring a DB connection.
     *
     * The parameter $all is boolean flag that, when set to true, causes the
     * '%' and '_' characters to be escaped as well.
     *
     * @param  boolean $all
     * @return Pop\Filter\String
     */
    public function escape($all = false)
    {
        $this->_string = str_replace('\\', '\\\\', $this->_string);
        $this->_string = str_replace("\n", "\\n", $this->_string);
        $this->_string = str_replace("\r", "\\r", $this->_string);
        $this->_string = str_replace("\x00", "\\x00", $this->_string);
        $this->_string = str_replace("\x1a", "\\x1a", $this->_string);
        $this->_string = str_replace('\'', '\\\'', $this->_string);
        $this->_string = str_replace('"', '\\"', $this->_string);

        if ($all) {
            $this->_string = str_replace('%', '\\%', $this->_string);
            $this->_string = str_replace('_', '\\_', $this->_string);
        }

        return $this;
    }

    /**
     * Method to clean the string of any of the standard MS Word based
     * characters and return the newly edited string filter object
     *
     * @param  boolean $html
     * @return Pop\Filter\String
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
     * @return Pop\Filter\String
     */
    public function dosToUnix()
    {
        $this->_string = str_replace(chr(13) . chr(10), chr(10), $this->_string);
        return $this;
    }

    /**
     * Method to convert newlines from UNIX to DOS
     *
     * @return Pop\Filter\String
     */
    public function unixToDos()
    {
        $this->_string = str_replace(chr(10), chr(13) . chr(10), $this->_string);
        return $this;
    }

    /**
     * Method to convert the string into an SEO-friendly slug.
     *
     * @param  string $sep
     * @return Pop\Filter\String
     */
    public function slug($sep = null)
    {
        if (strlen($this->_string) > 0) {
            if (null !== $sep) {
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
     * @return Pop\Filter\String
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
     * Method to generate a random alphanumeric string of a predefined length.
     *
     * @param  int     $len
     * @param  boolean $caps
     * @return Pop\Filter\String
     */
    public function random($len, $caps = false)
    {
        // Array of alphanumeric characters. The O, 0, I and 1 have been
        // removed to eliminate confusion.
        $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';

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
     * Method to convert the string from camelCase to dash format
     *
     * @return Pop\Filter\String
     */
    public function camelCaseToDash()
    {
       $this->_string = $this->_convertCamelCase('-');
       return $this;
    }

    /**
     * Method to convert the string from camelCase to separator format
     *
     * @param  string $sep
     * @return Pop\Filter\String
     */
    public function camelCaseToSeparator($sep = DIRECTORY_SEPARATOR)
    {
        $this->_string = $this->_convertCamelCase($sep);
        return $this;
    }

    /**
     * Method to convert the string from camelCase to under_score format
     *
     * @return Pop\Filter\String
     */
    public function camelCaseToUnderscore()
    {
        $this->_string = $this->_convertCamelCase('_');
        return $this;
    }

    /**
     * Method to convert the string from dash to camelCase format
     *
     * @return Pop\Filter\String
     */
    public function dashToCamelcase()
    {
        $strAry = explode('-', $this->_string);
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
     * Method to convert the string from dash to separator format
     *
     * @param  string $sep
     * @return Pop\Filter\String
     */
    public function dashToSeparator($sep = DIRECTORY_SEPARATOR)
    {
        $this->_string = str_replace('_', $sep, $this->_string);
        return $this;
    }

    /**
     * Method to convert the string from dash to under_score format
     *
     * @return Pop\Filter\String
     */
    public function dashToUnderscore()
    {
        $this->_string = str_replace('-', '_', $this->_string);
        return $this;
    }

    /**
     * Method to convert the string from under_score to camelCase format
     *
     * @return Pop\Filter\String
     */
    public function underscoreToCamelcase()
    {
        $strAry = explode('_', $this->_string);
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
     * Method to convert the string from under_score to dash format
     *
     * @return Pop\Filter\String
     */
    public function underscoreToDash()
    {
        $this->_string = str_replace('_', '-', $this->_string);
        return $this;
    }

    /**
     * Method to convert the string from under_score to separator format
     *
     * @param  string $sep
     * @return Pop\Filter\String
     */
    public function underscoreToSeparator($sep = DIRECTORY_SEPARATOR)
    {
        $this->_string = str_replace('_', $sep, $this->_string);
        return $this;
    }

    /**
     * Method to convert a camelCase string using the $sep value passed
     *
     * @param string $sep
     * @return string
     */
    protected function _convertCamelCase($sep)
    {
        $strAry = str_split($this->_string);
        $convert = null;
        $i = 0;

        foreach ($strAry as $chr) {
            if ($i == 0) {
                $convert .= strtolower($chr);
            } else {
                $convert .= (ctype_upper($chr)) ? ($sep . strtolower($chr)) : $chr;
            }
            $i++;
        }

        return $convert;
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

}
