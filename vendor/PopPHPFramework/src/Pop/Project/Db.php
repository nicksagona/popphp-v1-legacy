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
namespace Pop\Project;

use Pop\Data\Sql,
    Pop\Data\Xml,
    Pop\Data\Yaml,
    Pop\Db\Db as PopDb,
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
class Db
{

    /**
     * Check the database
     *
     * @param array $db
     * @return int
     */
    public static function check($db)
    {
        if (($db['type'] != 'Mysql') &&
            ($db['type'] != 'Mysqli') &&
            ($db['type'] != 'Pdo') &&
            ($db['type'] != 'Pgsql') &&
            ($db['type'] != 'Sqlite')) {
            return 'The database type \'' . $db['type'] . '\' is not valid.';
        } else {
            try {
                $db = PopDb::factory($db['type'], $db);
                return null;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * Install the database
     *
     * @param string $folder
     * @return mixed
     */
    public static function install($folder)
    {

    }

    /**
     * Write to the project config file
     *
     * @param string $file
     * @return mixed
     */
    public static function config($file)
    {

    }

}
