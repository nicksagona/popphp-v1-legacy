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
     * @throws Exception
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
                $result = null;
                // Test the db connection
                if ($db['type'] != 'Sqlite') {
                    $dbconn = PopDb::factory($db['type'], $db);
                }
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * Install the database
     *
     * @param array      $db
     * @param string     $dir
     * @param Pop\Config $install
     * @throws Exception
     * @return array
     */
    public static function install($db, $dir, $install)
    {
        // Detect any SQL files
        $dir = new Dir($dir, true);
        $sqlFiles = array();
        foreach ($dir->files as $file) {
            if (substr($file, -4) == '.sql') {
                $sqlFiles[] = $file;
            }
        }

        // If SQLite, create folder and empty SQLite file
        if ($db['type'] == 'Sqlite') {
            // Define folders to create
            $folders = array(
                $install->project->base,
                $install->project->base . '/module',
                $install->project->base . '/module/' . $install->project->name,
                $install->project->base . '/module/' . $install->project->name . '/data'
            );
            // Create the folders
            foreach ($folders as $folder) {
                if (!file_exists($folder)) {
                    mkdir($folder);
                }
            }
            // Create empty SQLite file and make file and folder writable
            chmod($install->project->base . '/module/' . $install->project->name . '/data', 0777);
            touch($install->project->base . '/module/' . $install->project->name . '/data/' . $db['database']);
            chmod($install->project->base . '/module/' . $install->project->name . '/data/' . $db['database'], 0777);
            $db['database'] = $install->project->base . '/module/' . $install->project->name . '/data/' . $db['database'];
        }

        // Create DB connection
        $popdb = PopDb::factory($db['type'], $db);
        $tables = array();

        // If there are SQL files, parse them and execute the SQL queries
        if (count($sqlFiles) > 0) {
            echo 'SQL files found. Executing SQL queries...' . PHP_EOL;
            foreach ($sqlFiles as $sqlFile) {
                $file = new File($sqlFile);

                $sql = trim($file->read());
                $statements = explode(';', $sql);

                $tableName = null;
                $auto = false;
                $primaryId = null;

                // Loop through each statement found
                foreach ($statements as $s) {
                    $s = trim($s);
                    if (!empty($s)) {
                        // Get table name from DROP
                        if ((stripos($s, 'DROP') !== false) && (stripos($s, 'TABLE') !== false)) {
                            $tableName = trim(substr($s, strrpos($s, ' ')));
                            $tableName = str_replace('`', '', $tableName);
                            $tableName = str_replace('"', '', $tableName);
                            $tableName = str_replace("'", "", $tableName);

                            // Set table info
                            $tables[$tableName] = array('primaryId' => null, 'auto' => false);
                            if (isset($db['prefix'])) {
                                $tables[$tableName]['prefix'] = $db['prefix'];
                            } else {
                                $tables[$tableName]['prefix'] = null;
                            }
                        }

                        // Get table name from CREATE
                        if ((stripos($s, 'CREATE') !== false) && (stripos($s, 'TABLE') !== false)) {
                            $tableName = substr($s, (stripos($s, 'CREATE') + 6));
                            $tableName = trim(substr($tableName, 0, strpos($tableName, '(')));
                            $tableName = trim(substr($tableName, strrpos($tableName, ' ')));
                            $tableName = str_replace('`', '', $tableName);
                            $tableName = str_replace('"', '', $tableName);
                            $tableName = str_replace("'", "", $tableName);

                            // Set table info
                            $tables[$tableName] = array('primaryId' => null, 'auto' => false);
                            if (isset($db['prefix'])) {
                                $tables[$tableName]['prefix'] = $db['prefix'];
                            } else {
                                $tables[$tableName]['prefix'] = null;
                            }
                        }

                        // Get primary key (mysql & sqlite)
                        if (stripos($s, 'PRIMARY KEY') !== false) {
                            if ($db['type'] == 'Sqlite') {
                                $matches = array();
                                preg_match('/^(.*)PRIMARY\sKEY,/im', $sql, $matches);
                                if (isset($matches[0])) {
                                    $id = trim($matches[0]);
                                    $primaryId = substr($id, 0, strpos($id, ' '));

                                    // Set table info
                                    if (isset($tables[$tableName])) {
                                        $tables[$tableName]['primaryId'] = $primaryId;
                                        $tables[$tableName]['auto'] = true;
                                    }
                                }
                            } else {
                                $primaryId = trim(substr($s, (stripos($s, 'PRIMARY KEY') + 11)));
                                $primaryId = trim(substr($primaryId, 0, strpos($primaryId, ')')));
                                $primaryId = str_replace('`', '', $primaryId);
                                $primaryId = str_replace('"', '', $primaryId);
                                $primaryId = str_replace("'", "", $primaryId);
                                $primaryId = str_replace('(', '', $primaryId);
                                $primaryId = str_replace(')', '', $primaryId);

                                // Set table info
                                if (isset($tables[$tableName])) {
                                    $tables[$tableName]['primaryId'] = $primaryId;
                                }
                            }
                        }

                        // Get auto-increment (mysql)
                        if ((stripos($s, 'AUTO_INCREMENT') !== false)) {
                            if (isset($tables[$tableName])) {
                                $tables[$tableName]['auto'] = true;
                            }
                        }

                        // Get primary key and auto (pgsql)
                        if (stripos($s, 'SERIAL') !== false) {
                            $id = trim(substr($s, 0, stripos($s, 'SERIAL')));
                            $id = trim(substr($id, strrpos($id, ' ')));

                            // Set table info
                            if (isset($tables[$tableName])) {
                                $tables[$tableName]['primaryId'] = $id;
                                $tables[$tableName]['auto'] = true;
                            }

                        }

                        // Execute the SQL query
                        try {
                            // Append the table prefix to the table in the query
                            if (isset($tables[$tableName]) && isset($tables[$tableName]['prefix'])) {
                                $s = str_replace($tableName, $tables[$tableName]['prefix'] . $tableName, $s);
                            }

                            $popdb->adapter->query(trim($s));
                        } catch (\Exception $e) {
                            echo $e->getMessage() . PHP_EOL . PHP_EOL;
                            exit(0);
                        }
                    }
                }
            }
        }

        return $tables;
    }

}
