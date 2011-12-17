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

use Pop\File\File,
    Pop\Filter\String,
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Install
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
                                           4 => 'You must pass an install file to install the project.',
                                           5 => 'Unknown option: ',
                                           6 => 'You must pass at least one argument.',
                                           7 => 'That folder does not exist.',
                                           8 => 'The folder argument is not a folder.'
                                       );

    /**
     * Install the project based on the available config files
     *
     * @param string $installFile
     * @return void
     */
    public static function install($installFile)
    {
        $dbTables = array();
        self::instructions();

        $input = self::cliInput();
        if ($input == 'n') {
            echo Locale::factory()->__('Aborted.') . PHP_EOL . PHP_EOL;
            exit(0);
        }

        // Get the install config.
        $installDir = realpath(dirname($installFile));
        $install = include $installFile;

        // Check if a project folder already exists.
        if (file_exists($install->project->name)) {
            echo wordwrap(Locale::factory()->__('Project folder exists. This may overwrite any project files you may already have under that project folder.'), 70, PHP_EOL) . PHP_EOL;
            $input = self::cliInput();
        } else {
            $input = 'y';
        }

        // If 'No', abort
        if ($input == 'n') {
            echo Locale::factory()->__('Aborted.') . PHP_EOL . PHP_EOL;
            exit(0);
        // Else, continue
        } else {
            $db = false;

            // Test for a database creds and schema, and ask to install the database.
            if (isset($install->databases)) {
                $databases =  $install->databases->asArray();
                $keys = array_keys($databases);
                if (isset($keys[0]) && (file_exists($installDir . '/' . $keys[0]))) {
                    echo Locale::factory()->__('Database credentials and schema detected.') . PHP_EOL;
                    $input = self::cliInput(Locale::factory()->__('Test and install the database(s)?') . ' (Y/N) ');
                    $db = ($input == 'n') ? false : true;
                }
            }

            // Handle any databases
            if ($db) {
                // Get current error reporting setting and set
                // error reporting to E_ERROR to suppress warnings
                $oldError = ini_get('error_reporting');
                error_reporting(E_ERROR);

                // Test the databases
                echo Locale::factory()->__('Testing the database(s)...') . PHP_EOL;

                foreach ($databases as $dbname => $db) {
                    echo Locale::factory()->__('Testing') . ' \'' . $dbname . '\'...' . PHP_EOL;
                    if (!isset($db['type']) || !isset($db['database'])) {
                        echo Locale::factory()->__('The database type and database name must be set for the database ') . '\'' . $dbname . '\'.' . PHP_EOL . PHP_EOL;
                        exit(0);
                    }
                    $check = Db::check($db);
                    if (null !== $check) {
                        echo $check . PHP_EOL . PHP_EOL;
                        exit(0);
                    } else {
                        echo Locale::factory()->__('Database') . ' \'' . $dbname . '\' passed.' . PHP_EOL;
                        echo Locale::factory()->__('Installing database') .' \'' . $dbname . '\'...' . PHP_EOL;
                        $tables = Db::install($db, $installDir);
                        if (null !== $tables) {
                            $dbTables = array_merge($dbTables, $tables);
                        }
                    }
                }
                // Return error reporting to its original state
                error_reporting($oldError);
            }

            // Create base folder and file structure
            self::_createBase($install);

            // Create project
            self::_createProject($install, $installDir);

            // Create tables
            if (count($dbTables) > 0) {
                self::_createTables($install, $dbTables);
            }

            // Create 'bootstrap.php' file
            $autoload = realpath(__DIR__ . '/../Loader/Autoloader.php');
            $projectCfg = addslashes(realpath($install->project->base . '/config/project.config.php'));
            $moduleCfg = addslashes(realpath($install->project->base . '/module/' . $install->project->name . '/config/module.config.php'));
            $moduleSrc = addslashes(realpath($install->project->base . '/module/' . $install->project->name . '/src'));

            $bootstrap = new File($install->project->docroot . '/bootstrap.php');

            // Create new bootstrap file
            if (!file_exists($install->project->docroot . '/bootstrap.php')) {
                $bootstrap->write("<?php " . PHP_EOL . PHP_EOL)
                          ->write("// Require the Autoloader class file" . PHP_EOL . "require_once '{$autoload}';" . PHP_EOL . PHP_EOL, true)
                          ->write("// Instantiate the autoloader object" . PHP_EOL . "\$autoloader = Pop\\Loader\\Autoloader::factory();" . PHP_EOL . "\$autoloader->splAutoloadRegister();" . PHP_EOL, true);
            }

            // Else, just append to the existing bootstrap file
            $bootstrap->write("\$autoloader->register('{$install->project->name}', '{$moduleSrc}');" . PHP_EOL . PHP_EOL, true)
                      ->write("// Create a project config object" . PHP_EOL, true)
                      ->write("\$project = {$install->project->name}\\Project::factory(" . PHP_EOL, true)
                      ->write("    include '{$projectCfg}'," . PHP_EOL, true)
                      ->write("    include '{$moduleCfg}'" . PHP_EOL, true)
                      ->write(");" . PHP_EOL . PHP_EOL, true)
                      ->write("\$project->run();" . PHP_EOL . PHP_EOL, true)
                      ->save();

            echo Locale::factory()->__('Project install complete.') . PHP_EOL . PHP_EOL;
        }

    }

    /**
     * Display CLI instructions
     *
     * @return string
     */
    public static function instructions()
    {
        $msg = "This process will create and install a lightweight framework for your project under the folder specified in the install file. Minimally, the install file should return a Pop\\Config object containing your project install settings, such as project name, folders and any database credentials. Besides creating the folders and files for you, one of the main benefits is ability to test and install the database and the corresponding configuration and class files. You can enable this by having the SQL files in the same folder as your install file under a folder named after the database, i.e. './dbname'. The following folder structure is required for the database installation to work properly:";
        echo wordwrap(Locale::factory()->__($msg), 70, PHP_EOL) . PHP_EOL . PHP_EOL;
        echo './project.install.php' . PHP_EOL;
        echo './dbname/create/*.sql' . PHP_EOL;
        echo './dbname/insert/*.sql' . PHP_EOL;
        echo './dbname/*.sql' . PHP_EOL . PHP_EOL;
    }

    /**
     * Print the CLI help message
     *
     * @return void
     */
    public static function cliHelp()
    {
        echo ' -c --check                ' . Locale::factory()->__('Check the current configuration for required dependencies') . PHP_EOL;
        echo ' -h --help                 ' . Locale::factory()->__('Display this help') . PHP_EOL;
        echo ' -i --install file.php     ' . Locale::factory()->__('Install a project based on the install file specified') . PHP_EOL;
        echo ' -l --lang fr              ' . Locale::factory()->__('Set the default language for the project') . PHP_EOL;
        echo ' -m --map folder file.php  ' . Locale::factory()->__('Create a class map file from the source folder and save to the output file') . PHP_EOL;
        echo ' -s --show                 ' . Locale::factory()->__('Show project install instructions') . PHP_EOL;
        echo ' -t --test folder          ' . Locale::factory()->__('Run the unit tests from a folder') . PHP_EOL;
        echo ' -v --version              ' . Locale::factory()->__('Display version of Pop PHP Framework and latest available') . PHP_EOL . PHP_EOL;
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
    public static function cliInput($msg = null)
    {
        echo ((null === $msg) ? Locale::factory()->__('Continue?') . ' (Y/N) ' : $msg);
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

    /**
     * Return the location of the bootstrap file from STDIN
     *
     * @return string
     */
    public static function getBootstrap()
    {
        $msg = Locale::factory()->__('Enter the folder where the \'bootstrap.php\' is located in relation to the current folder: ');
        echo $msg;
        $input = null;

        while (!file_exists($input . '/bootstrap.php')) {
            if (null !== $input) {
                echo Locale::factory()->__('Bootstrap file not found. Try again.') . PHP_EOL . $msg;
            }
            $prompt = fopen("php://stdin", "r");
            $input = fgets($prompt, 255);
            $input = rtrim($input);
            fclose ($prompt);
        }

        return $input;
    }

    /**
     * Return the two-letter language code from STDIN
     *
     * @param array $langs
     * @return string
     */
    public static function getLanguage($langs)
    {
        $msg = Locale::factory()->__('Enter the two-letter code for the default language: ');
        echo $msg;
        $lang = null;

        while (!array_key_exists($lang, $langs)) {
            if (null !== $lang) {
                echo $msg;
            }
            $prompt = fopen("php://stdin", "r");
            $lang = fgets($prompt, 5);
            $lang = rtrim($lang);
            fclose ($prompt);
        }

        return $lang;
    }

    /**
     * Create the base folder and file structure
     *
     * @param Pop\Config $install
     * @return void
     */
    protected static function _createBase($install)
    {
        echo Locale::factory()->__('Creating base folder and file structure...') . PHP_EOL;

        $folders = array(
            $install->project->base,
            $install->project->base . '/config',
            $install->project->base . '/module',
            $install->project->base . '/module/' . $install->project->name,
            $install->project->base . '/module/' . $install->project->name . '/config',
            $install->project->base . '/module/' . $install->project->name . '/src',
            $install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name,
            $install->project->base . '/module/' . $install->project->name . '/view',
            $install->project->docroot
        );

        foreach ($folders as $folder) {
            if (!file_exists($folder)) {
                mkdir($folder);
            }
        }

        $projectCfg = new File($install->project->base . '/config/project.config.php');
        $projectCfg->write('<?php' . PHP_EOL . PHP_EOL)
                   ->write('return new Pop\Config(array(' . PHP_EOL, true)
                   ->write("    'base'      => '" . addslashes(realpath($install->project->base)) . "'," . PHP_EOL, true)
                   ->write("    'docroot'   => '" . addslashes(realpath($install->project->docroot)) . "'", true);
        if (isset($install->databases)) {
            $projectCfg->write("," . PHP_EOL, true)
                       ->write("    'databases' => array(" . PHP_EOL, true);
            $databases = $install->databases->asArray();
            $i = 0;
            foreach ($databases as $dbname => $db) {
                $projectCfg->write("        '" . $dbname . "' => Pop\\Db\\Db::factory('" . $db['type'] . "', array (" . PHP_EOL, true);
                $j = 0;
                foreach ($db as $key => $value) {
                    $j++;
                    if ($key != 'type') {
                        $ary = "            '{$key}' => '{$value}'";
                        if ($j < count($db)) {
                           $ary .= ',';
                        }
                        $projectCfg->write($ary . PHP_EOL, true);
                    }
                }
                $i++;
                $end = ($i < count($databases)) ? '        )),' : '        ))';
                $projectCfg->write($end . PHP_EOL, true);
            }
            $projectCfg->write('    )', true);
        }
        if (isset($install->controller)) {
            $projectCfg->write(',' . PHP_EOL . "    'controller' => '{$install->project->name}\\\\Controller'", true);
        }
        $projectCfg->write(PHP_EOL . '));' . PHP_EOL, true);
        $projectCfg->save();

        // Create the module config file
        $moduleCfg = new File($install->project->base . '/module/' . $install->project->name . '/config/module.config.php');
        $moduleCfg->write('<?php' . PHP_EOL . PHP_EOL)
                  ->write('return new Pop\Config(array(' . PHP_EOL, true)
                  ->write("    'name'   => '{$install->project->name}'," . PHP_EOL, true)
                  ->write("    'base'   => '" . addslashes(realpath($install->project->base . '/module/' . $install->project->name)) . "'," . PHP_EOL, true)
                  ->write("    'config' => '" . addslashes(realpath($install->project->base . '/module/' . $install->project->name . '/config')) . "'," . PHP_EOL, true)
                  ->write("    'src'    => '" . addslashes(realpath($install->project->base . '/module/' . $install->project->name . '/src')) . "'" . PHP_EOL, true)
                  ->write("));" . PHP_EOL, true)
                  ->save();
    }

    /**
     * Create the project class files
     *
     * @param Pop\Config $install
     * @param string     $installDir
     * @return void
     */
    protected static function _createProject($install, $installDir)
    {
        // Create the project class file
        $projectCls = new File($install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Project.php');
        $projectCls->write('<?php' . PHP_EOL . PHP_EOL)
                   ->write('namespace ' . $install->project->name . ';' . PHP_EOL . PHP_EOL, true)
                   ->write('use Pop\\Project\\Project as P;' . PHP_EOL . PHP_EOL, true)
                   ->write('class Project extends P' . PHP_EOL, true)
                   ->write('{' . PHP_EOL . PHP_EOL, true)
                   ->write('    public function run()' . PHP_EOL, true)
                   ->write('    {' . PHP_EOL, true)
                   ->write('        // Add any project specific code for run-time here.' . PHP_EOL, true)
                   ->write('        parent::run();' . PHP_EOL, true)
                   ->write('    }' . PHP_EOL . PHP_EOL, true)
                   ->write('}' . PHP_EOL, true)
                   ->save();

        // Create the controller class file
        if (isset($install->controller)) {
            if (!file_exists($install->project->base . '/view')) {
                mkdir($install->project->base . '/view');
            }
            $controllerCls = new File($install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Controller.php');
            $controllerCls->write('<?php' . PHP_EOL . PHP_EOL)
                          ->write('namespace ' . $install->project->name. ';' . PHP_EOL . PHP_EOL, true)
                          ->write('use Pop\\Http\\Response,' . PHP_EOL, true)
                          ->write('    Pop\\Http\\Request,' . PHP_EOL, true)
                          ->write('    Pop\\Mvc\\Controller as C,' . PHP_EOL, true)
                          ->write('    Pop\\Mvc\\Model,' . PHP_EOL, true)
                          ->write('    Pop\\Mvc\\View;' . PHP_EOL . PHP_EOL, true)
                          ->write('class Controller extends C' . PHP_EOL, true)
                          ->write('{' . PHP_EOL . PHP_EOL, true)
                          ->write("    public function __construct(Request \$request = null, Response \$response = null, \$viewPath = null)" . PHP_EOL, true)
                          ->write("    {" . PHP_EOL, true)
                          ->write("        if (null === \$viewPath) {" . PHP_EOL, true)
                          ->write("            \$viewPath = __DIR__ . '/../../../../view';" . PHP_EOL, true)
                          ->write("        }" . PHP_EOL . PHP_EOL, true)
                          ->write("        parent::__construct(\$request, \$response, \$viewPath);" . PHP_EOL . PHP_EOL, true)
                          ->write("        if (\$this->_request->getRequestUri() == '/') {" . PHP_EOL, true)
                          ->write("            \$this->index();" . PHP_EOL, true)
                          ->write("        } else if (!is_null(\$this->_request->getPath(0)) && method_exists(\$this, \$this->_request->getPath(0))) {" . PHP_EOL, true)
                          ->write("            \$path = \$this->_request->getPath(0);" . PHP_EOL, true)
                          ->write("            \$this->\$path();" . PHP_EOL, true)
                          ->write("        } else {" . PHP_EOL, true)
                          ->write("            \$this->_isError = true;" . PHP_EOL, true)
                          ->write("            \$this->error();" . PHP_EOL, true)
                          ->write("        }" . PHP_EOL, true)
                          ->write("    }" . PHP_EOL. PHP_EOL, true);
            $views = $install->controller->asArray();
            foreach ($views as $key => $value) {
                if (file_exists($installDir . '/view/' . $value)) {
                    copy($installDir . '/view/' . $value, $install->project->base . '/view/' . $value);
                }
                $controllerCls->write("    public function {$key}()" . PHP_EOL, true)
                              ->write("    {" . PHP_EOL, true)
                              ->write("        // Add your model data here to inject into the view." . PHP_EOL, true)
                              ->write("        \$this->_view = View::factory(\$this->_viewPath . '/{$value}');" . PHP_EOL, true)
                              ->write("    }" . PHP_EOL . PHP_EOL, true);
            }
            $controllerCls->write('}' . PHP_EOL, true)
                          ->save();
        }

        // Create index controller file
        $indexFile = new File($install->project->docroot . '/index.php');
        $indexFile->write("<?php" . PHP_EOL . PHP_EOL, true)
                  ->write("require_once 'bootstrap.php';" . PHP_EOL . PHP_EOL, true)
                  ->save();

        // Create .htaccess file
        $htFile = new File($install->project->docroot . '/.htaccess', array());
        $htFile->write("RewriteEngine On" . PHP_EOL . PHP_EOL, true)
               ->write("RewriteCond %{REQUEST_FILENAME} -s [OR]" . PHP_EOL, true)
               ->write("RewriteCond %{REQUEST_FILENAME} -l [OR]" . PHP_EOL, true)
               ->write("RewriteCond %{REQUEST_FILENAME} -f [OR]" . PHP_EOL, true)
               ->write("RewriteCond %{REQUEST_FILENAME} -d" . PHP_EOL . PHP_EOL, true)
               ->write("RewriteRule ^.*$ - [NC,L]" . PHP_EOL, true)
               ->write("RewriteRule ^.*$ index.php [NC,L]" . PHP_EOL . PHP_EOL, true)
               ->save();
    }

    /**
     * Create the table class files
     *
     * @param Pop\Config $install
     * @param array  $dbTables
     * @return void
     */
    protected static function _createTables($install, $dbTables)
    {
        echo Locale::factory()->__('Creating database table class files...') . PHP_EOL;

        $tableDir = $install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Table';
        if (!file_exists($tableDir)) {
            mkdir($tableDir);
        }

        foreach ($dbTables as $table) {
            if (null !== $table['tableName']) {
                $tableName = String::factory($table['tableName'])->underscoreToCamelcase()->upperFirst();
                $tableCls = new File($tableDir . '/' . $tableName . '.php');
                $tableCls->write('<?php' . PHP_EOL . PHP_EOL)
                         ->write('namespace ' . $install->project->name . '\\Table;' . PHP_EOL . PHP_EOL, true)
                         ->write('use Pop\\Record\\Record;' . PHP_EOL . PHP_EOL, true);

                $auto = ($table['auto']) ? 'true' : 'false';
                $primaryId = (null !== $table['primaryId']) ? "'" . $table['primaryId'] . "'" : 'null';

                $tableCls->write('class ' . $tableName . ' extends Record' . PHP_EOL, true)
                         ->write('{' . PHP_EOL . PHP_EOL, true)
                         ->write('    protected $_primaryId = ' . $primaryId . ';' . PHP_EOL . PHP_EOL, true)
                         ->write('    protected $_auto =  ' . $auto . ';' . PHP_EOL . PHP_EOL, true)
                         ->write('}' . PHP_EOL, true)
                         ->save();
            }
        }
    }

}
