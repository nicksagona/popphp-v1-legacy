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
 * @package    Pop_Compress
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Compress;

/**
 * This is the Deflate class for the Compress component.
 *
 * @category   Pop
 * @package    Pop_Compress
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
 */
class Deflate implements CompressInterface
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
