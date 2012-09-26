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
 * This is the String class for the Filter component.
 *
 * @category   Pop
 * @package    Pop_Filter
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0
 */
class String
{

    /**
     * Constant for alpha-numeric + special characters
     * @var int
     */
    const ALL = 1;

    /**
     * Constant for alpha-numeric
     * @var int
     */
    const ALPHANUM = 2;

    /**
     * Constant for alpha
     * @var int
     */
    const ALPHA = 3;

    /**
     * Constant for mixed case
     * @var int
     */
    const MIXED = 4;

    /**
     * Constant for lower case only
     * @var int
     */
    const LOWER = 5;

    /**
     * Constant for upper case only
     * @var int
     */
    const UPPER = 6;

    /**
     * String property
     * @var string
     */
    protected $string = null;

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
        $this->string = (null !== $str) ? $str : '';
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
     * Method to generate a random alphanumeric string of a predefined length.
     *
     * @param  int  $length
     * @param  int  $type
     * @param  int  $case
     * @return Pop\Filter\String
     */
    public static function random($length, $type = String::ALL, $case = String::MIXED)
    {
        $str = null;

        $chars = array(
            0 => str_split('abcdefghjkmnpqrstuvwxyz'),
            1 => str_split('ABCDEFGHJKLMNPQRSTUVWXYZ'),
            2 => str_split('23456789'),
            3 => str_split('!#$%&()*+-,.:;=?@[]^_{|}')
        );

        $indices = array(0, 1, 2, 3);

        switch ($type) {
            case self::ALPHANUM:
                $indices = array(0, 1, 2);
                break;
            case self::ALPHA:
                $indices = array(0, 1);
                break;
        }

        switch ($case) {
            case self::LOWER:
                unset($indices[1]);
                break;
            case self::UPPER:
                unset($indices[0]);
                break;
        }

        $indices = array_values($indices);

        for ($i = 0; $i < $length; $i++) {
            $index = $indices[rand(0, (count($indices) - 1))];
            $subIndex = rand(0, (count($chars[$index]) - 1));
            $str .= $chars[$index][$subIndex];
        }

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
        $this->string = strtolower($this->string);
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
        $this->string = strtoupper($this->string);
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
        $this->string = ucwords($this->string);
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
        $this->string = ucfirst($this->string);
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
        $startPos = (strpos($this->string, $start) !== false)
            ? (strpos($this->string, $start) + strlen($start)) : 0;

        $this->string = substr($this->string, $startPos);
        $this->string = (strpos($this->string, $end) !== false)
            ? substr($this->string, 0, (strpos($this->string, $end))) : $this->string;

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
                        $this->string = str_replace($value[0], $value[1], $this->string);
                    } else {
                        $this->string = str_ireplace($value[0], $value[1], $this->string);
                    }
                }
            }
        } else {
            if ($caseSenstive) {
                $this->string = str_replace($search, $replace, $this->string);
            } else {
                $this->string = str_ireplace($search, $replace, $this->string);
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
        $this->string = preg_replace($pattern, $replace, $this->string);
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
        $this->string = (null !== $chars)
            ? trim($this->string, $chars) : trim($this->string);
        return $this;
    }

    /**
     * Method to add slashes to the string and return the newly
     * edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function addSlashes()
    {
        $this->string = addslashes($this->string);
        return $this;
    }

    /**
     * Method to strip slashes from the string and return the newly
     * edited string filter object.
     *
     * @return Pop\Filter\String
     */
    public function stripSlashes()
    {
        $this->string = stripslashes($this->string);
        return $this;
    }

    /**
     * Method to strip HTML tags from the string and return the
     * newly edited string filter object.
     *
     * @param  string $allowed
     * @return Pop\Filter\String
     */
    public function stripTags($allowed = null)
    {
        $this->string = (null !== $allowed)
            ? strip_tags($this->string, $allowed) : strip_tags($this->string);
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
        $this->string = htmlentities($this->string, ENT_QUOTES, 'UTF-8');
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
        $this->string = html_entity_decode($this->string, ENT_QUOTES, 'UTF-8');
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
        $this->string = nl2br($this->string);
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
        $replace = array(
            array('\\', '\\\\'),
            array("\n", "\\n"),
            array("\r", "\\r"),
            array("\x00", "\\x00"),
            array("\x1a", "\\x1a"),
            array('\'', '\\\''),
            array('"', '\\"')
        );

        if ($all) {
            $replace[] = array('%', '\\%');
            $replace[] = array('_', '\\_');
        }

        $this->replace($replace);
        return $this;
    }

    /**
     * Method to clean the string of any of the standard MS Word based
     * characters and return the newly edited string filter object
     *
     * @param  boolean $html
     * @return Pop\Filter\String
     */
    public function clean($html = false)
    {
        if ($html) {
            $apos = "&#39;";
            $quot = "&#34;";
        } else {
            $apos = "'";
            $quot = '"';
        }

        $this->string = str_replace(chr(146), $apos, $this->string);
        $this->string = str_replace(chr(147), $quot, $this->string);
        $this->string = str_replace(chr(148), $quot, $this->string);
        $this->string = str_replace(chr(150), "&#150;", $this->string);
        $this->string = str_replace(chr(133), "...", $this->string);

        return $this;
    }

    /**
     * Method to convert newlines from DOS to UNIX
     *
     * @return Pop\Filter\String
     */
    public function dosToUnix()
    {
        $this->string = str_replace(chr(13) . chr(10), chr(10), $this->string);
        return $this;
    }

    /**
     * Method to convert newlines from UNIX to DOS
     *
     * @return Pop\Filter\String
     */
    public function unixToDos()
    {
        $this->string = str_replace(chr(10), chr(13) . chr(10), $this->string);
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
        if (strlen($this->string) > 0) {
            if (null !== $sep) {
                $strAry = explode($sep, $this->string);
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

                $this->string = '/' . implode('/', $tmpStrAry);
                $this->string = str_replace('/-', '/', $this->string);
                $this->string = str_replace('-/', '/', $this->string);
            } else {
                $this->string = strtolower($this->string);
                $this->string = str_replace('&', 'and', $this->string);
                $this->string = preg_replace('/([^a-zA-Z0-9 \-\/])/', '', $this->string);
                $this->string = str_replace('/', '-', $this->string);
                $this->string = str_replace(' ', '-', $this->string);
                $this->string = preg_replace('/-*-/', '-', $this->string);
                $this->string = '/' . $this->string;
            }

            return $this;
        } else {
            $this->string = '';
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

        $this->string = preg_replace('/[f|ht]+tp:\/\/[^\s]*/', '<a href="$0">$0</a>', $this->string);
        $this->string = preg_replace('/\s[\w]+[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,4})/', ' <a href="http://$0">$0</a>', $this->string);
        $this->string = preg_replace('/[a-zA-Z0-9\.\-\_+%]+@[a-zA-Z0-9\-\_\.]+\.[a-zA-Z]{2,4}/', '<a href="mailto:$0">$0</a>', $this->string);
        $this->string = str_replace('href="http:// ', 'href="http://', $this->string);
        $this->string = str_replace('"> ', '">', $this->string);
        $this->string = str_replace('<a ', '<a ' . $target, $this->string);

        return $this;
    }

    /**
     * Method to convert the string to an MD5 hash
     *
     * @param  boolean $raw
     * @return Pop\Filter\String
     */
    public function md5($raw = false)
    {
        $this->string = md5($this->string, $raw);
        return $this;
    }

    /**
     * Method to convert the string to an SHA1 hash
     *
     * @param  boolean $raw
     * @return Pop\Filter\String
     */
    public function sha1($raw = false)
    {
        $this->string = sha1($this->string, $raw);
        return $this;
    }

    /**
     * Method to convert the string to a hash using the crypt functions
     *
     * @param  string $salt
     * @return Pop\Filter\String
     */
    public function crypt($salt = null)
    {
        if (null === $salt) {
            $this->string = crypt($this->string);
        } else {
            $this->string = crypt($this->string, $salt);
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
       $this->string = $this->convertCamelCase('-');
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
        $this->string = $this->convertCamelCase($sep);
        return $this;
    }

    /**
     * Method to convert the string from camelCase to under_score format
     *
     * @return Pop\Filter\String
     */
    public function camelCaseToUnderscore()
    {
        $this->string = $this->convertCamelCase('_');
        return $this;
    }

    /**
     * Method to convert the string from dash to camelCase format
     *
     * @return Pop\Filter\String
     */
    public function dashToCamelcase()
    {
        $strAry = explode('-', $this->string);
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

        $this->string = $camelCase;

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
        $this->string = str_replace('-', $sep, $this->string);
        return $this;
    }

    /**
     * Method to convert the string from dash to under_score format
     *
     * @return Pop\Filter\String
     */
    public function dashToUnderscore()
    {
        $this->string = str_replace('-', '_', $this->string);
        return $this;
    }

    /**
     * Method to convert the string from under_score to camelCase format
     *
     * @return Pop\Filter\String
     */
    public function underscoreToCamelcase()
    {
        $strAry = explode('_', $this->string);
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

        $this->string = $camelCase;

        return $this;
    }

    /**
     * Method to convert the string from under_score to dash format
     *
     * @return Pop\Filter\String
     */
    public function underscoreToDash()
    {
        $this->string = str_replace('_', '-', $this->string);
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
        $this->string = str_replace('_', $sep, $this->string);
        return $this;
    }

    /**
     * Method to convert a camelCase string using the $sep value passed
     *
     * @param string $sep
     * @return string
     */
    protected function convertCamelCase($sep)
    {
        $strAry = str_split($this->string);
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
        return $this->string;
    }

}
