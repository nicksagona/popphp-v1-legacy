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
    Pop\Filter\String;

/**
 * This is the Bootstrap class for the Project Install component.
 *
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.1
 */
class Bootstrap
{

    /**
     * Create the bootstrap file
     *
     * @param Pop\Config $install
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
        $bootstrap = new Generator($install->project->docroot . '/bootstrap.php');

        // Create new bootstrap file
        if (!file_exists($install->project->docroot . '/bootstrap.php')) {
            $bootstrap->appendToBody("// Require the Autoloader class file" . PHP_EOL . "require_once '{$autoload}';" . PHP_EOL)
                      ->appendToBody("// Instantiate the autoloader object" . PHP_EOL . "\$autoloader = Pop\\Loader\\Autoloader::factory();" . PHP_EOL . "\$autoloader->splAutoloadRegister();");
        }

        // Else, just append to the existing bootstrap file
        $bootstrap->appendToBody("\$autoloader->register('{$install->project->name}', '{$moduleSrc}');" . PHP_EOL)
                  ->appendToBody("// Create a project object")
                  ->appendToBody("\$project = {$install->project->name}\Project::factory(")
                  ->appendToBody("    include '{$projectCfg}',")
                  ->appendToBody("    include '{$moduleCfg}',");

        // Set up any controllers via a router object
        if (isset($install->controllers)) {
            $controllers = $install->controllers->asArray();
            $ctrls = array();
            foreach ($controllers as $key => $value) {
                $controllerName = ($key == '/') ? 'index' : substr($key, 1);
                $ctrls[] = "'{$key}' => '{$install->project->name}\Controller\\" . ucfirst(String::underscoreToCamelcase($controllerName)) . "Controller'";
                foreach ($value as $arrayKey => $arrayValue) {
                    if (is_array($arrayValue)) {
                        $subCtrl = "'{$arrayKey}' => array(" . PHP_EOL;
                        $i = 1;
                        foreach ($arrayValue as $k => $v) {
                            $subControllerName = ($k == '/') ? 'index' : substr($k, 1);
                            $end = ($i < count($arrayValue)) ? ',' : null;
                            $subCtrl .= "    '{$k}' => '{$install->project->name}\Controller\\" . ucfirst(String::underscoreToCamelcase($subControllerName)) . "Controller'" . $end;
                            $i++;
                        }
                        $subCtrl .= ")";
                        $ctrls[] = $subCtrl;
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
