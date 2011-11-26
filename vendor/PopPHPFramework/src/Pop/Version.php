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
 * @package    Pop_Version
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Version
 *
 * @category   Pop
 * @package    Pop_Version
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Version
{

    /**
     * Current version
     */
    const VERSION = '0.9';

    /**
     * Current URL
     */
    const URL = 'http://www.popphp.org/version.txt';

    /**
     * Returns the version of this library install.
     *
     * @return string
     */
    public static function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Returns the version of this library install.
     *
     * @param  string $ver
     * @return int
     */
    public static function compareVersion($ver)
    {
        return version_compare($ver, self::VERSION);
    }

    /**
     * Returns the latest version available.
     *
     * @return string|null
     */
    public static function getLatest()
    {
        $latest = null;

        $handle = fopen(self::URL, 'r');
        if ($handle !== false) {
            $latest = stream_get_contents($handle);
            fclose($handle);
        }

        return $latest;
    }

}
