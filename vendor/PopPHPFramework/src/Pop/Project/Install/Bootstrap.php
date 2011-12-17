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

use Pop\File\File;

/**
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
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
        $autoload = addslashes(realpath(__DIR__ . '/../../Loader/Autoloader.php'));
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
    }

}
