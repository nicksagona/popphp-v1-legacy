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
     * @param string     $dbname
     * @param array      $db
     * @param string     $dir
     * @param Pop\Config $install
     * @throws Exception
     * @return array
     */
    public static function install($dbname, $db, $dir, $install)
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

        // If there are SQL files, parse them and execute the SQL queries
        if (count($sqlFiles) > 0) {
            echo 'SQL files found. Executing SQL queries...' . PHP_EOL;
            foreach ($sqlFiles as $sqlFile) {
                $file = new File($sqlFile);

                $sql = trim($file->read());
                $statements = explode(';', $sql);

                // Loop through each statement found and execute
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

        // Get table info
        $tables = array();

        try {
            // Get Sqlite table info
            if ($db['type'] == 'Sqlite') {
                $tablesFromDb = $popdb->adapter->getTables();
                if (count($tablesFromDb) > 0) {
                    foreach ($tablesFromDb as $table) {
                        $popdb->adapter->query("PRAGMA table_info('" . $table . "')");
                        while (($row = $popdb->adapter->fetch()) != false) {
                            if ($row['pk'] == 1) {
                                $tables[$table] = array('primaryId' => $row['name'], 'auto' => true);
                            }
                        }
                    }
                }
            // Else, get MySQL and PgSQL table info
            } else {
                if ($db['type'] == 'Pgsql') {
                    $schema = 'CATALOG';
                    $tableSchema = " AND TABLE_SCHEMA = 'public'";
                    $tableName = 'table_name';
                    $constraintName = 'constraint_name';
                    $columnName = 'column_name';
                } else {
                    $schema = 'SCHEMA';
                    $tableSchema = null;
                    $tableName = 'TABLE_NAME';
                    $constraintName = 'CONSTRAINT_NAME';
                    $columnName = 'COLUMN_NAME';
                }
                $popdb->adapter->query("SELECT * FROM information_schema.TABLES WHERE TABLE_" . $schema . " = '" . $dbname . "'" . $tableSchema);

                // Get the auto increment info (mysql) and set table name
                while (($row = $popdb->adapter->fetch()) != false) {
                    $auto = (!empty($row['AUTO_INCREMENT'])) ? true : false;
                    $tables[$row[$tableName]] = array('primaryId' => null, 'auto' => $auto);
                }

                // Get the primary key info
                foreach ($tables as $table => $value) {
                    // Pgsql sequence info for auto increment
                    if ($db['type'] == 'Pgsql') {
                        $popdb->adapter->query("SELECT column_name FROM information_schema.COLUMNS WHERE table_name = '" . $table . "'");
                        $columns = array();
                        while (($row = $popdb->adapter->fetch()) != false) {
                            $columns[] = $row['column_name'];
                        }

                        if (count($columns) > 0) {
                            foreach ($columns as $column) {
                                $popdb->adapter->query("SELECT pg_get_serial_sequence('" . $table . "', '" . $column . "')");
                                while (($row = $popdb->adapter->fetch()) != false) {
                                    if (!empty($row['pg_get_serial_sequence'])) {
                                        $idAry = explode('_', $row['pg_get_serial_sequence']);
                                        if (isset($idAry[1]) && (in_array($idAry[1], $columns))) {
                                            $tables[$table]['auto'] = true;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // Get primary id, if there is one
                    $popdb->adapter->query("SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE CONSTRAINT_" . $schema . " = '" . $dbname . "' AND TABLE_NAME = '" . $table . "'");
                    while (($row = $popdb->adapter->fetch()) != false) {
                        if (isset($row[$constraintName])) {
                            $tables[$table]['primaryId'] = $row[$columnName];
                        }
                    }
                }
            }

            // Modify table name with prefix, if any
            if (isset($db['prefix'])) {
                foreach ($tables as $table => $value) {
                    $tables[$table]['prefix'] = $db['prefix'];
                    $popdb->adapter->query("ALTER TABLE " . $table . " RENAME TO " . $db['prefix'] . $table);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL . PHP_EOL;
            exit(0);
        }
        return $tables;
    }

}
