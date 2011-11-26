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
 * @package    Pop_Autoloader
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Autoloader
 *
 * @category   Pop
 * @package    Pop_Autoloader
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Autoloader
{

    /**
     * Method to autoload a class via the file name.
     *
     * @param  string $class
     * @return void
     */
    public static function autoload($class)
    {
        // Set the file name and path.
        $filePath = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';

        // Require the file.
        require_once $filePath;
    }

    /**
     * Method to register the autoload class name with the autoload stack.
     *
     * @return void
     */
    public static function registerAutoloader()
    {
        spl_autoload_register('Pop_Autoloader::autoload');
    }

    /**
     * Method to set the include path of the library.
     *
     * @return void
     */
    public static function setupIncludePath()
    {
        set_include_path(realpath(dirname(__FILE__) . '/../') . PATH_SEPARATOR . get_include_path());
    }

    /**
     * Method to bootstrap the autoloader.
     *
     * @param  string|array $dirs
     * @return void
     */
    public static function bootstrap($dirs = null)
    {
        if (null !== $dirs) {
            if (is_array($dirs)) {
                $realDirs = array();
                foreach ($dirs as $dir) {
                    $realDirs[] = realpath($dir);
                }
                $d = implode(PATH_SEPARATOR, $realDirs) . PATH_SEPARATOR . get_include_path();
            } else {
                $d = realpath($dirs) . PATH_SEPARATOR . get_include_path();
            }
            set_include_path($d);
        }

        self::setupIncludePath();
        self::registerAutoloader();
    }

}
