@echo off
REM
REM Pop PHP Framework Windows CLI script
REM
REM LICENSE
REM
REM This source file is subject to the new BSD license that is bundled
REM with this package in the file LICENSE.TXT.
REM It is also available through the world-wide-web at this URL:
REM http://www.popphp.org/LICENSE.TXT
REM If you did not receive a copy of the license and are unable to
REM obtain it through the world-wide-web, please send an email
REM to info@popphp.org so we can send you a copy immediately.
REM
REM Possible arguments
REM
REM -c --check                     Check the current configuration for required dependencies
REM -h --help                      Display this help
REM -i --install file.php          Install a project based on the install file specified
REM -l --lang fr                   Set the default language for the project
REM -m --map folder file.php       Create a class map file from the source folder and save to the output file
REM -r --reconfig projectfolder    Reconfigure the project based on the new location of the project
REM -s --show                      Show project install instructions
REM -v --version                   Display version of Pop PHP Framework
REM

SET SCRIPT_DIR=%~dp0
php %SCRIPT_DIR%pop.php %1 %2 %3