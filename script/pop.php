#!/usr/bin/php
<?php
/**
 * Pop PHP Framework PHP CLI script
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
 * Possible arguments
 *
 * -c --check                Check the current configuration for required dependencies
 * -h --help                 Display this help
 * -i --install file.php     Install a project based on the install file specified
 * -l --lang fr              Set the default language for the project
 * -m --map folder file.php  Create a class map file from the source folder and save to the output file
 * -s --show                 Show project install instructions
 * -t --test folder          Run the unit tests from a folder
 * -v --version              Display version of Pop PHP Framework
 *
 * IMPORTANT!
 *
 * If you move the 'bootstrap.php' file, make
 * sure you adjust the path to it accordingly
 *
 */

require_once __DIR__ . '/../public/bootstrap.php';

use Pop\File\File,
    Pop\Loader\Classmap,
    Pop\Locale\Locale,
    Pop\Project\Project,
    Pop\Version;

// Write header
echo PHP_EOL;
echo 'Pop PHP Framework CLI script' . PHP_EOL;
echo '============================' . PHP_EOL . PHP_EOL;

if (!empty($argv[1])) {
    // Check for version
    if (($argv[1] == '-v') || ($argv[1] == '--version')) {
        echo 'Version Check' . PHP_EOL;
        echo '-------------' . PHP_EOL;
        echo 'Installed: ' . Version::getVersion() . PHP_EOL;
        echo 'Latest Available: ' . Version::getLatest() . PHP_EOL;
    // Else, check dependencies
    } else if (($argv[1] == '-c') || ($argv[1] == '--check')) {
        echo 'Dependencies Check' . PHP_EOL;
        echo '------------------' . PHP_EOL;
        echo Version::check() . PHP_EOL;
    // Else, display help
    } else if (($argv[1] == '-h') || ($argv[1] == '--help')) {
        echo 'Help' . PHP_EOL;
        echo '----' . PHP_EOL;
        Project::cliHelp();
    // Else, display help
    } else if (($argv[1] == '-s') || ($argv[1] == '--show')) {
        echo 'Build Project Instructions' . PHP_EOL;
        echo '--------------------------' . PHP_EOL;
        Project::instructions();
    // Else, set default project language
    } else if (($argv[1] == '-l') || ($argv[1] == '--lang')) {
        echo 'Set Default Project Language' . PHP_EOL;
        echo '----------------------------' . PHP_EOL;
        $langs = Locale::factory()->getLanguages();
        $langsList = null;
        foreach ($langs as $key => $value) {
            $langsList .= '[' . $key . '] : ' . $value . PHP_EOL;
        }
        if (isset($argv[2])) {
            if (!array_key_exists($argv[2], $langs)) {
                echo $langsList;
                $lang = Project::getLanguage($langs);
            } else {
                $lang = $argv[2];
            }
        } else {
            echo $langsList;
            $lang = Project::getLanguage($langs);
        }
        echo 'You selected [' . $lang .'] : ' . $langs[$lang] . PHP_EOL . PHP_EOL;

        // Get the bootstrap file
        $location = Project::getBootstrap();
        $bootstrap = new File($location . '/bootstrap.php');
        $bootstrapCode = $bootstrap->read();

        // Set the new default language setting into the bootstrap file
        if (stripos($bootstrapCode, 'define(\'POP_DEFAULT_LANG') !== false) {
            $curLangCode = substr($bootstrapCode, stripos($bootstrapCode, 'define(\'POP_DEFAULT_LANG'));
            $curLangCode = substr($curLangCode, 0, strpos($curLangCode, ';'));
            $bootstrapCode = str_replace($curLangCode, 'define(\'POP_DEFAULT_LANG\', \'' . $lang . '\')', $bootstrapCode);
        } else {
            $curLangCode = substr($bootstrapCode, stripos($bootstrapCode, '// Require the Autoloader class file'));
            $curLangCode = substr($curLangCode, 0, strpos($curLangCode, 'Autoloader class file'));
            $langCode = '// Define the default language to use' . PHP_EOL . 'define(\'POP_DEFAULT_LANG\', \'' . $lang . '\');' . PHP_EOL . PHP_EOL . '// Require the ';
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
            echo Project::cliError(1);
        // Else, check if the source folder exists
        } else if (!file_exists($argv[2])) {
            echo Project::cliError(2);
        // Else, check if the output file ends in '.php'
        } else if (strtolower(substr($argv[3], -4)) != '.php') {
            echo Project::cliError(3);
        // Else, generate the class map file
        } else {
            echo 'Generating class map file \'' . $argv[3] . '\' from source folder \'' . $argv[2] . '\'' . PHP_EOL;
            Classmap::generate($argv[2], $argv[3]);

            // Add project to the bootstrap file
            $input = Project::cliInput('Add classmap to the bootstrap file? (Y/N) ');
            if ($input == 'y') {
                $location = Project::getBootstrap();
                $bootstrap = new File($location . '/bootstrap.php');
                $bootstrap->write("\$autoloader->loadClassMap('" . addslashes(realpath($argv[3])) . "');" . PHP_EOL . PHP_EOL, true)
                          ->save();
            }
            echo 'Done.' . PHP_EOL . PHP_EOL;
        }
    // Else, build project
    } else if (($argv[1] == '-i') || ($argv[1] == '--install')) {
        // Check if the $name argument was passed
        if (empty($argv[2])) {
            echo Project::cliError(4);
        // Else, run the build process
        } else {
            echo 'Installing Project' . PHP_EOL;
            echo '------------------' . PHP_EOL;
            if (!file_exists($argv[2])) {
                echo 'The project install file \'' . $argv[2] . '\' does not exist.' . PHP_EOL . PHP_EOL;
                exit(0);
            }
            Project::install($argv[2]);
        }
    // Else, unknown option passed
    } else {
        echo Project::cliError(5, $argv[1]);
    }
// Else, no option passed
} else {
    echo Project::cliError(6);
}
