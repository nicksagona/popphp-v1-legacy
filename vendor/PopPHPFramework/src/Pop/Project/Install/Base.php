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

use Pop\Code\Generator,
    Pop\Locale\Locale;

/**
 * This is the Base class for the Project Install component.
 *
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0
 */
class Base
{

    /**
     * Install the base folder and file structure
     *
     * @param Pop\Config $install
     * @return void
     */
    public static function install($install)
    {
        echo Locale::factory()->__('Creating base folder and file structure...') . PHP_EOL;

        // Define folders to create
        $folders = array(
            $install->project->base,
            $install->project->base . '/config',
            $install->project->base . '/module',
            $install->project->base . '/module/' . $install->project->name,
            $install->project->base . '/module/' . $install->project->name . '/config',
            $install->project->base . '/module/' . $install->project->name . '/data',
            $install->project->base . '/module/' . $install->project->name . '/src',
            $install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name,
            $install->project->base . '/module/' . $install->project->name . '/view',
            $install->project->docroot
        );

        // Create the folders
        foreach ($folders as $folder) {
            if (!file_exists($folder)) {
                mkdir($folder);
            }
        }

        // Make the '/data' folder writable
        chmod($install->project->base . '/module/' . $install->project->name . '/data', 0777);

        // Create project.config.php file
        $projectCfg = new Generator($install->project->base . '/config/project.config.php');
        $projectCfg->appendToBody('return new Pop\Config(array(', true)
                   ->appendToBody("    'base'      => '" . addslashes(realpath($install->project->base)) . "',")
                   ->appendToBody("    'docroot'   => '" . addslashes(realpath($install->project->docroot)) . "'", false);

        // Add the database config to it
        if (isset($install->databases)) {
            $projectCfg->appendToBody(",")
                       ->appendToBody("    'databases' => array(");
            $databases = $install->databases->asArray();
            $default = null;
            $i = 0;
            foreach ($databases as $dbname => $db) {
                $isPdo = (stripos($db['type'], 'pdo') !== false) ? true : false;
                $isSqlite = (stripos($db['type'], 'sqlite') !== false) ? true : false;

                if ($isPdo) {
                    $pdoType = strtolower(substr($db['type'], (strpos($db['type'], '_') + 1)));
                    $realDbType = 'Pdo';
                } else {
                    $pdoType = null;
                    $realDbType = $db['type'];
                }

                $projectCfg->appendToBody("        '" . $dbname . "' => Pop\\Db\\Db::factory('" . $realDbType . "', array (");
                $j = 0;
                $default = ($db['default']) ? $dbname : null;
                $dbCreds = $db;
                unset($dbCreds['type']);
                unset($dbCreds['prefix']);
                unset($dbCreds['default']);
                foreach ($dbCreds as $key => $value) {
                    $j++;
                    if ($isSqlite) {
                        $dbFile = $install->project->base . '/module/' . $install->project->name . '/data/' . basename($value);
                        $dbFile = addslashes(realpath($dbFile));
                        $ary = "            '{$key}' => '{$dbFile}'";
                    } else {
                        $ary = "            '{$key}' => '{$value}'";
                    }
                    if ($isPdo) {
                        $ary .= "," . PHP_EOL . "            'type' => '{$pdoType}'";
                    }
                    if ($j < count($dbCreds)) {
                       $ary .= ',';
                    }
                    $projectCfg->appendToBody($ary);
                }
                $i++;
                $end = ($i < count($databases)) ? '        )),' : '        ))';
                $projectCfg->appendToBody($end);
            }
            $projectCfg->appendToBody('    )', false);

            if (null !== $default) {
                $projectCfg->appendToBody("," . PHP_EOL . "    'defaultDb' => '" . $default . "'", false);
            }
        }

        // Save project config
        $projectCfg->appendToBody(PHP_EOL . '));', false);
        $projectCfg->save();

        // Create the module config file
        $moduleCfg = new Generator($install->project->base . '/module/' . $install->project->name . '/config/module.config.php');
        $moduleCfg->appendToBody('return new Pop\Config(array(')
                  ->appendToBody("    'name'   => '{$install->project->name}',")
                  ->appendToBody("    'base'   => '" . addslashes(realpath($install->project->base . '/module/' . $install->project->name)) . "',")
                  ->appendToBody("    'config' => '" . addslashes(realpath($install->project->base . '/module/' . $install->project->name . '/config')) . "',")
                  ->appendToBody("    'data'   => '" . addslashes(realpath($install->project->base . '/module/' . $install->project->name . '/data')) . "',")
                  ->appendToBody("    'src'    => '" . addslashes(realpath($install->project->base . '/module/' . $install->project->name . '/src')) . "',")
                  ->appendToBody("    'view'   => '" . addslashes(realpath($install->project->base . '/module/' . $install->project->name . '/view')) . "'")
                  ->appendToBody("));", false)
                  ->save();
    }

}
