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

use Pop\File\File,
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
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

}
