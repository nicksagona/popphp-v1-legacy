<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Compress
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Compress;

/**
 * Deflate class
 *
 * @category   Pop
 * @package    Pop_Compress
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Deflate
{

    /**
     * Static method to compress data
     *
     * @param  string $data
     * @param  int    $level
     * @return mixed
     */
    public static function compress($data, $level = 9)
    {
        return gzdeflate($data, $level);
    }

    /**
     * Static method to decompress data
     *
     * @param  string $data
     * @return mixed
     */
    public static function decompress($data)
    {
        return gzinflate($data);
    }

}
