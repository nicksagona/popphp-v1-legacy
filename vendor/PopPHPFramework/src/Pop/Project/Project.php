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
        self::instructions();

        $input = self::cliInput();
        if ($input == 'n') {
            echo 'Aborted.' . PHP_EOL . PHP_EOL;
            exit(0);
        }

        // Check for the project config file.
        if (!file_exists(__DIR__ . '/../../../../../config/project.config.php')) {
            echo 'The project config file, \'config/project.config.php\', was not found.' . PHP_EOL;
            echo 'Aborted.' . PHP_EOL . PHP_EOL;
            exit(0);
        }

        $config = include __DIR__ . '/../../../../../config/project.config.php';

        // Check if a project folder already exists.
        if (file_exists(__DIR__ . '/../../../../../module/' . $name)) {
            echo 'This may overwrite any project files you may already have' . PHP_EOL;
            echo 'under the \'module/' . $name . '/src\' folder.' . PHP_EOL;
            $input = self::cliInput();
        } else {
            $input = 'y';
        }

        // If 'No', abort
        if ($input == 'n') {
            echo 'Aborted.' . PHP_EOL . PHP_EOL;
            exit(0);
        // Else, continue
        } else {
            $db = false;

            // Test for a database creds and schema, and ask to install the database.
            if (isset($config['databases']) && (count($config['databases']) > 0)) {
                $keys = array_keys($config['databases']);
                if (isset($keys[0]) && (file_exists(__DIR__ . '/../../../../../config/' . $keys[0]))) {
                    echo 'Database credentials and schema detected.' . PHP_EOL;
                    $input = self::cliInput('Test, create and install the database(s)? (Y/N) ');
                    $db = ($input == 'n') ? false : true;
                }
            }
            if ($db) {
                //echo 'Continue building the project (w/ the DB)...' . PHP_EOL . PHP_EOL;
                echo 'Testing the database(s)...' . PHP_EOL;
                foreach ($config['databases'] as $dbname => $db) {
                    echo 'Testing \'' . $dbname . '\'...' . PHP_EOL;
                    if (!isset($db['type']) || !isset($db['database'])) {
                        echo 'The database type and database name must be set for the database \'' . $dbname . '\'.' . PHP_EOL . PHP_EOL;
                        exit(0);
                    }
                    $check = Db::check($db);
                    if (null !== $check) {
                        echo $check . PHP_EOL . PHP_EOL;
                        exit(0);
                    } else {
                        echo 'Database \'' . $dbname . '\' passed.' . PHP_EOL;
                    }
                }
            } else {
                echo 'Continue building the project (w/o the DB)...' . PHP_EOL . PHP_EOL;
            }
        }
    }

    /**
     * Display CLI instructions
     *
     * @return string
     */
    public static function instructions()
    {
        echo 'This process will build a lightweight framework of your project under' . PHP_EOL;
        echo 'the \'module/ProjectName\' folder. Minimally, you will need to have the' . PHP_EOL;
        echo '\'config/project.config.php\' present, which should return an array' . PHP_EOL;
        echo 'containing your project configuration settings, such as your database' . PHP_EOL;
        echo 'credentials. Besides creating the folders and files for you, one of' . PHP_EOL;
        echo 'the main benefits is to optionally test, create and install the' . PHP_EOL;
        echo 'database and the corresponding configuration and class files. You' . PHP_EOL;
        echo 'can do this by having the your SQL files in the \'config/dbname\'' . PHP_EOL;
        echo 'folder. The following folder structure is required:' . PHP_EOL . PHP_EOL;
        echo '\'config/dbname/create/*.sql\'' . PHP_EOL;
        echo '\'config/dbname/insert/*.sql\'' . PHP_EOL;
        echo '\'config/dbname/*.sql\'' . PHP_EOL . PHP_EOL;
        echo 'This is necessary so that the tables are created before the data' . PHP_EOL;
        echo 'is inserted into the database.' . PHP_EOL . PHP_EOL;
    }

    /**
     * Print the CLI help message
     *
     * @return void
     */
    public static function cliHelp()
    {
        echo ' -b --build ProjectName    Build a project based on the files in the \'config\' folder' . PHP_EOL;
        echo ' -c --check                Check the current configuration for required dependencies' . PHP_EOL;
        echo ' -h --help                 Display this help' . PHP_EOL;
        echo ' -i --instructions         Display build project instructions' . PHP_EOL;
        echo ' -m --map folder file.php  Create a class map file from the source folder and save to the output file' . PHP_EOL;
        echo ' -v --version              Display version of Pop PHP Framework and latest available' . PHP_EOL . PHP_EOL;
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
               Locale::factory()->__('Run \'.' . DIRECTORY_SEPARATOR . 'pop -h\' for help.') . PHP_EOL . PHP_EOL;
        return $msg;
    }

    /**
     * Return the (Y/N) input from STDIN
     *
     * @return string
     */
    public static function cliInput($msg = 'Continue? (Y/N) ')
    {
        echo $msg;
        $input = null;

        while (($input != 'y') && ($input != 'n')) {
            if (null !== $input) {
                echo $msg;
            }
            $prompt = fopen("php://stdin", "r");
            $input = fgets($prompt, 5);
            $input = substr(strtolower(rtrim($input)), 0, 1);
            fclose ($prompt);
        }

        return $input;
    }

}
