#!/usr/bin/php
<?php
/**
 * Pop PHP Framework PHP CLI script (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Cli
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 *
 * Possible arguments
 *
 * -c --check                     Check the current configuration for required dependencies
 * -h --help                      Display this help
 * -i --install file.php          Install a project based on the install file specified
 * -l --lang fr                   Set the default language for the project
 * -m --map folder file.php       Create a class map file from the source folder and save to the output file
 * -s --show                      Show project install instructions
 * -v --version                   Display version of Pop PHP Framework
 */

set_time_limit(0);

require_once __DIR__  . '/../vendor/PopPHPFramework/src/Pop/Loader/Autoloader.php';

$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

use Pop\File\File;
use Pop\Loader\Classmap;
use Pop\I18n\I18n;
use Pop\Project\Install;
use Pop\Version;

// Write header
echo PHP_EOL;
echo 'Pop PHP Framework CLI' . PHP_EOL;
echo '=====================' . PHP_EOL . PHP_EOL;

if (!empty($argv[1])) {
    // Check for version
    if (($argv[1] == '-v') || ($argv[1] == '--version')) {
        echo 'Version Check' . PHP_EOL;
        echo '-------------' . PHP_EOL;
        echo 'Installed: ' . Version::getVersion() . PHP_EOL;
        echo 'Latest Available: ' . Version::getLatest() . PHP_EOL . PHP_EOL;
    // Else, check dependencies
    } else if (($argv[1] == '-c') || ($argv[1] == '--check')) {
        echo 'Dependencies Check' . PHP_EOL;
        echo '------------------' . PHP_EOL;
        echo Version::check() . PHP_EOL;
    // Else, display help
    } else if (($argv[1] == '-h') || ($argv[1] == '--help')) {
        echo 'Help' . PHP_EOL;
        echo '----' . PHP_EOL;
        Install::cliHelp();
    // Else, show instructions
    } else if (($argv[1] == '-s') || ($argv[1] == '--show')) {
        echo 'Project Install Instructions' . PHP_EOL;
        echo '----------------------------' . PHP_EOL;
        Install::instructions();
    // Else, set default project language
    } else if (($argv[1] == '-l') || ($argv[1] == '--lang')) {
        echo 'Set Default Project Language' . PHP_EOL;
        echo '----------------------------' . PHP_EOL;

        // Create list of available languages
        $langs = I18n::getLanguages();
        $langsList = null;
        $i = 0;
        foreach ($langs as $key => $value) {
            $num = ($i < 10) ? ' ' . $i : $i;
            $langsList .= '  ' . $num . ' : [' . $key . '] ' . $value . PHP_EOL;
            $i++;
        }

        // Prompt user to select language
        if (isset($argv[2])) {
            if (!array_key_exists($argv[2], $langs)) {
                echo $langsList . PHP_EOL;
                $lang = Install::getLanguage($langs);
            } else {
                $lang = $argv[2];
            }
        } else {
            echo $langsList . PHP_EOL;
            $lang = Install::getLanguage($langs);
        }
        $keys = array_keys($langs);

        echo 'You selected [' . $keys[$lang] .'] : ' . $langs[$keys[$lang]] . PHP_EOL . PHP_EOL;

        // Get the bootstrap file
        $location = Install::getBootstrap();
        $bootstrap = new File($location . '/bootstrap.php');
        $bootstrapCode = $bootstrap->read();

        // Set the new default language setting into the bootstrap file
        if (stripos($bootstrapCode, 'define(\'POP_LANG') !== false) {
            $curLangCode = substr($bootstrapCode, stripos($bootstrapCode, 'define(\'POP_LANG'));
            $curLangCode = substr($curLangCode, 0, strpos($curLangCode, ';'));
            $bootstrapCode = str_replace($curLangCode, 'define(\'POP_LANG\', \'' . $keys[$lang] . '\')', $bootstrapCode);
        } else {
            $curLangCode = substr($bootstrapCode, stripos($bootstrapCode, 'require_once'));
            $curLangCode = substr($curLangCode, 0, strpos($curLangCode, ';'));
            $langCode = PHP_EOL . '// Define the default language to use' . PHP_EOL . 'define(\'POP_LANG\', \'' . $keys[$lang] . '\');' . PHP_EOL . PHP_EOL . $curLangCode;
            $bootstrapCode = str_replace($curLangCode, $langCode, $bootstrapCode);
        }

        $bootstrap->write($bootstrapCode)
                  ->save();

        echo 'Done.' . PHP_EOL . PHP_EOL;
    // Else, generate class map
    } else if (($argv[1] == '-m') || ($argv[1] == '--map')) {
        echo 'Generate Class Map File' . PHP_EOL;
        echo '-----------------------' . PHP_EOL;

        // Check if the source folder and output file arguments were passed
        if (empty($argv[2]) || empty($argv[3])) {
            echo Install::cliError(1);
        // Else, check if the source folder exists
        } else if (!file_exists($argv[2])) {
            echo Install::cliError(2);
        // Else, check if the output file ends in '.php'
        } else if (strtolower(substr($argv[3], -4)) != '.php') {
            echo Install::cliError(3);
        // Else, generate the class map file
        } else {
            echo 'Generating class map file \'' . $argv[3] . '\' from source folder \'' . $argv[2] . '\'' . PHP_EOL;
            Classmap::generate($argv[2], $argv[3]);

            // Add project to the bootstrap file
            $input = Install::cliInput('Add classmap to the bootstrap file? (Y/N) ');
            if ($input == 'y') {
                $location = Install::getBootstrap();
                $bootstrap = new File($location . '/bootstrap.php');
                $bootstrap->write("\$autoloader->loadClassMap('" . addslashes(realpath($argv[3])) . "');" . PHP_EOL . PHP_EOL, true)
                          ->save();
            }
            echo 'Done.' . PHP_EOL . PHP_EOL;
        }
    // Else, install project
    } else if (($argv[1] == '-i') || ($argv[1] == '--install')) {
        // Check if the project install file argument was passed
        if (empty($argv[2])) {
            echo Install::cliError(4);
        // Else, run the install process
        } else {
            echo 'Installing Project' . PHP_EOL;
            echo '------------------' . PHP_EOL;
            if (!file_exists($argv[2])) {
                echo 'The project install file \'' . $argv[2] . '\' does not exist.' . PHP_EOL . PHP_EOL;
                exit(0);
            }
            Install::install($argv[2]);
        }
    // Else, unknown option passed
    } else {
        echo Install::cliError(5, $argv[1]);
    }
// Else, no option passed
} else {
    echo Install::cliError(6);
}
