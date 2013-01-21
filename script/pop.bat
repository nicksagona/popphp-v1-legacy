@echo off
REM
REM Pop PHP Framework Windows CLI script (http://www.popphp.org/)
REM https://github.com/nicksagona/PopPHP
REM http://www.popphp.org/license    New BSD License
REM
REM Possible arguments
REM
REM -c --check                     Check the current configuration for required dependencies
REM -h --help                      Display this help
REM -i --install file.php          Install a project based on the install file specified
REM -l --lang fr                   Set the default language for the project
REM -m --map folder file.php       Create a class map file from the source folder and save to the output file
REM -s --show                      Show project install instructions
REM -v --version                   Display version of Pop PHP Framework
REM

SET SCRIPT_DIR=%~dp0
php %SCRIPT_DIR%pop.php %*
