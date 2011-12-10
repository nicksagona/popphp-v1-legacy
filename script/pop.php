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
 * -v --version    Display version of Pop PHP Framework
 * -c --check      Check the current configuration for required dependencies
 * -b --build      Build a project based on the project configuration file
 *
 */
require_once __DIR__ . '/../public/bootstrap.php';

if (isset($argv[1])) {
    // Write header
    echo PHP_EOL . 'Pop PHP Framework PHP CLI script' . PHP_EOL;
    echo '================================' . PHP_EOL . PHP_EOL;

    // Check for version
    if (($argv[1] == '-v') || ($argv[1] == '--version')) {
        echo 'Version Check' . PHP_EOL;
        echo '-------------' . PHP_EOL;
        echo 'Installed: ' . Pop\Version::getVersion() . PHP_EOL;
        echo 'Latest Available: ' . Pop\Version::getLatest() . PHP_EOL;
    // Else, check dependencies
    } else if (($argv[1] == '-c') || ($argv[1] == '--check')) {
        echo 'Dependencies Check' . PHP_EOL;
        echo '------------------' . PHP_EOL;
        echo Pop\Version::check() . PHP_EOL;
    // Else, build project
    } else if (($argv[1] == '-b') || ($argv[1] == '--build')) {
        echo 'Build';
    }

}
