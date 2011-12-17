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
namespace Pop\Project\Install;

use Pop\Data\Sql,
    Pop\Db\Db as PopDb,
    Pop\Dir\Dir,
    Pop\File\File;

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
     * @return string
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
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * Install the database
     *
     * @param array  $db
     * @param string $dir
     * @return array
     */
    public static function install($db, $dir)
    {
        $popdb = PopDb::factory($db['type'], $db);
        $tables = array();

        $dbDir = $dir . '/' . $db['database'];
        $createDir = $dir . '/' . $db['database'] . '/create';
        $insertDir = $dir . '/' . $db['database'] . '/insert';

        // Create tables
        if (file_exists($createDir)) {
            echo 'Creating tables...' . PHP_EOL;
            $dir = new Dir($createDir, true);
            foreach ($dir->files as $file) {
                if (file_exists($file) && !is_dir($file)) {
                    $f = new File($file);
                    $sql = trim($f->read());
                    $statements = explode(';', $sql);
                    $tableName = null;
                    $auto = false;
                    $primaryId = null;
                    foreach ($statements as $s) {
                        $s = trim($s);
                        if (!empty($s)) {
                            // Get table name
                            if ((stripos($s, 'CREATE') !== false) && (stripos($s, 'TABLE') !== false)) {
                                $tableName = substr($s, (stripos($s, 'CREATE') + 6));
                                $tableName = trim(substr($tableName, 0, strpos($tableName, '(')));
                                $tableName = trim(substr($tableName, strrpos($tableName, ' ')));
                                $tableName = str_replace('`', '', $tableName);
                                $tableName = str_replace('"', '', $tableName);
                                $tableName = str_replace("'", "", $tableName);
                            }
                            // Get auto-increment (mysql & pgsql)
                            if ((stripos($s, 'AUTO_INCREMENT') !== false) || (stripos($s, 'CREATE SEQUENCE') !== false)) {
                                $auto = true;
                            }
                            // Get primary key (mysql)
                            if (stripos($s, 'PRIMARY KEY') !== false) {
                                $primaryId = trim(substr($s, (stripos($s, 'PRIMARY KEY') + 11)));
                                $primaryId = trim(substr($primaryId, 0, strpos($primaryId, ')')));
                                $primaryId = str_replace('`', '', $primaryId);
                                $primaryId = str_replace('"', '', $primaryId);
                                $primaryId = str_replace("'", "", $primaryId);
                                $primaryId = str_replace('(', '', $primaryId);
                                $primaryId = str_replace(')', '', $primaryId);
                            }
                            // Get primary key (pgsql)
                            if (stripos($s, 'ALTER SEQUENCE') !== false) {
                                $primaryId = trim(substr($s, (stripos($s, 'ALTER SEQUENCE') + 14)));
                                $primaryId = trim(substr($primaryId, strrpos($primaryId, ' ')));
                                $primaryId = str_replace($tableName . '.', '', $primaryId);
                            }
                            try {
                                $popdb->adapter->query(trim($s));
                            } catch (\Exception $e) {
                                echo $e->getMessage() . PHP_EOL . PHP_EOL;
                                exit(0);
                            }
                        }
                    }
                    $tables[] = array(
                        'tableName' => $tableName,
                        'auto'      => $auto,
                        'primaryId' => $primaryId
                    );
                }
            }
        }

        // Insert data
        if (file_exists($insertDir)) {
            echo 'Inserting data...' . PHP_EOL;
            $dir = new Dir($insertDir, true);
            foreach ($dir->files as $file) {
                if (file_exists($file) && !is_dir($file)) {
                    $f = new File($file);
                    $sql = trim($f->read());
                    $statements = explode(';', $sql);
                    foreach ($statements as $s) {
                        if (!empty($s)) {
                            try {
                                $popdb->adapter->query(trim($s));
                            } catch (\Exception $e) {
                                echo $e->getMessage() . PHP_EOL . PHP_EOL;
                                exit(0);
                            }
                        }
                    }
                }
            }
        }

        // Execute any other SQL
        if (file_exists($dbDir)) {
            echo 'Executing additional SQL queries...' . PHP_EOL;
            $dir = new Dir($dbDir, true);
            foreach ($dir->files as $file) {
                if (file_exists($file) && !is_dir($file)) {
                    $f = new File($file);
                    $sql = trim($f->read());
                    $statements = explode(';', $sql);
                    foreach ($statements as $s) {
                        if (!empty($s)) {
                            try {
                                $popdb->adapter->query(trim($s));
                            } catch (\Exception $e) {
                                echo $e->getMessage() . PHP_EOL . PHP_EOL;
                                exit(0);
                            }
                        }
                    }
                }
            }
        }

        return $tables;
    }

}
