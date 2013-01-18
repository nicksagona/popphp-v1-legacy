<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Project\Install;

use Pop\Filter\String;

/**
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
 */
class Bootstrap
{

    /**
     * Create the bootstrap file
     *
     * @param \Pop\Config $install
     * @return void
     */
    public static function install($install)
    {
        // Define full paths of the autoloader and config files
        $autoload = addslashes(realpath(__DIR__ . '/../../Loader/Autoloader.php'));
        $projectCfg = addslashes(realpath($install->project->base . '/config/project.config.php'));
        $moduleCfg = addslashes(realpath($install->project->base . '/module/' . $install->project->name . '/config/module.config.php'));
        $moduleSrc = addslashes(realpath($install->project->base . '/module/' . $install->project->name . '/src'));

        // Create new Code file object
        $bootstrap = new \Pop\Code\Generator($install->project->docroot . '/bootstrap.php');

        // Create new bootstrap file
        if (!file_exists($install->project->docroot . '/bootstrap.php')) {
            $bootstrap->appendToBody("// Require the Autoloader class file" . PHP_EOL . "require_once '{$autoload}';" . PHP_EOL)
                      ->appendToBody("// Instantiate the autoloader object" . PHP_EOL . "\$autoloader = Pop\\Loader\\Autoloader::factory();" . PHP_EOL . "\$autoloader->splAutoloadRegister();");
        }

        // Else, just append to the existing bootstrap file
        $bootstrap->appendToBody("\$autoloader->register('{$install->project->name}', '{$moduleSrc}');" . PHP_EOL)
                  ->appendToBody("// Create a project object")
                  ->appendToBody("\$project = {$install->project->name}\\Project::factory(")
                  ->appendToBody("    include '{$projectCfg}',")
                  ->appendToBody("    include '{$moduleCfg}',");

        // Set up any controllers via a router object
        if (isset($install->controllers)) {
            $controllers = $install->controllers->asArray();
            $ctrls = array();
            foreach ($controllers as $key => $value) {
                $subs = array();
                foreach ($value as $k => $v) {
                    if (is_array($v)) {
                        $subs[] = $k;
                    }
                }
                if (count($subs) > 0) {
                    $ctls = "'{$key}' => array(" . PHP_EOL;
                    if (array_key_exists('index', $value)) {
                        $ctls .= "            '/' => '{$install->project->name}\\Controller\\" . ucfirst(String::underscoreToCamelcase(substr($key, 1))) . "\\IndexController'," . PHP_EOL;
                    }
                    foreach ($subs as $sub) {
                        $ctls .= "            '{$sub}' => '{$install->project->name}\\Controller\\" . ucfirst(String::underscoreToCamelcase(substr($key, 1))) . "\\" . ucfirst(String::underscoreToCamelcase(substr($sub, 1))) . "Controller'," . PHP_EOL;
                    }
                    $ctls .= '        )';
                    $ctrls[] = $ctls;
                } else {
                    if ($key == '/') {
                        $ctrls[] = "'{$key}' => '{$install->project->name}\\Controller\\IndexController'";
                    } else {
                        $controllerName = substr($key, 1);
                        if (array_key_exists('index', $value)) {
                            $ctrls[] = "'{$key}' => '{$install->project->name}\\Controller\\" . ucfirst(String::underscoreToCamelcase($controllerName)) . "\\IndexController'";
                        } else {
                            $ctrls[] = "'{$key}' => '{$install->project->name}\\Controller\\" . ucfirst(String::underscoreToCamelcase($controllerName)) . "Controller'";
                        }
                    }
                }
            }
            $bootstrap->appendToBody("    new Pop\\Mvc\\Router(array(");
            $i = 1;
            foreach ($ctrls as $c) {
                $end = ($i < count($ctrls)) ? ',' : null;
                $bootstrap->appendToBody("        " . $c . $end);
                $i++;
            }
            $bootstrap->appendToBody("    ))");
        }

        // Finalize and save the bootstrap file
        $bootstrap->appendToBody(");")
                  ->save();
    }

}
