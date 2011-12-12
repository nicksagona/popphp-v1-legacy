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
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop;

use Pop\Data\Sql,
    Pop\Data\Xml,
    Pop\Data\Yaml,
    Pop\File\File,
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Project
{

    /**
     * CLI error codes & messages
     * @var array
     */
    protected static $_cliErrorCodes = array(
                                           0 => 'Unknown error.',
                                           1 => 'You must pass a source folder and a output file to generate a class map file.',
                                           2 => 'The source folder passed does not exist.',
                                           3 => 'The output file passed must be a PHP file.',
                                           4 => 'You must pass a name for the project.',
                                           5 => 'Unknown option: ',
                                           6 => 'You must pass at least one argument.'
                                       );
    /**
     * Build the project based on the available config files
     *
     * @param string $name
     * @return void
     */
    public static function build($name)
    {
        echo $name . PHP_EOL . PHP_EOL;
    }

    /**
     * Return a CLI error message based on the code
     *
     * @param int    $num
     * @param string $arg
     * @return string
     */
    public static function cliError($num = 0, $arg = null)
    {
        $i = (int)$num;
        if (!array_key_exists($i, self::$_cliErrorCodes)) {
            $i = 0;
        }
        $msg = Locale::factory()->__(self::$_cliErrorCodes[$i]) . $arg . PHP_EOL .
               Locale::factory()->__('Run \'./pop.php -h\' for help.') . PHP_EOL . PHP_EOL;
        return $msg;
    }

}
