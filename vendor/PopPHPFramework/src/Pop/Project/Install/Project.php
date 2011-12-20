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
    Pop\Code\MethodGenerator,
    Pop\Code\NamespaceGenerator,
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Project
{

    /**
     * Install the project class files
     *
     * @param Pop\Config $install
     * @param string     $installDir
     * @return void
     */
    public static function install($install, $installDir)
    {
        // Create the project class file
        $projectCls = new Generator(
            $install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Project.php',
            Generator::CREATE_CLASS
        );

        // Set namespace
        $ns = new NamespaceGenerator($install->project->name);
        $ns->setUse('Pop\\Project\\Project', 'P');

        // Create 'run' method
        $run = new MethodGenerator('run');
        $run->setDesc('Add any project specific code to this method for run-time use here.');
        $run->addArgument('controller', "'default'", 'string');
        $run->appendToBody('parent::run($controller);', false);
        $run->getDocblock()->setReturn('void');

        $projectCls->setNamespace($ns);
        $projectCls->code()->setParent('P')
                           ->addMethod($run);
        $projectCls->save();

        $input = self::installWeb();

        if ($input != 'n') {
            if (file_exists(__DIR__ . '/Web/index.php')) {
                $index = new Generator(__DIR__ . '/Web/index.php');
                $contents = $index->read() .
                	'// Run the project' . PHP_EOL .
                	'$project->run();' . PHP_EOL . PHP_EOL .
                	'?>' . PHP_EOL;
                file_put_contents($install->project->docroot . '/index.php', $contents);
            }
            if ($input == 'a') {
                if (file_exists(__DIR__ . '/Web/ht.access')) {
                    copy(__DIR__ . '/Web/ht.access', $install->project->docroot . '/.htaccess');
                }
            } else if ($input == 'i') {
                if (file_exists(__DIR__ . '/Web/web.config')) {
                    copy(__DIR__ . '/Web/web.config', $install->project->docroot . '/web.config');
                }
            } else {
                echo Locale::factory()->__('You will have to install your web server rewrite configuration manually.') . PHP_EOL;
            }
        }
    }

    /**
     * Install index controller and web config files prompt
     *
     * @return string
     */
    public static function installWeb()
    {
        $msg = Locale::factory()->__('Install index controller and web configuration files?') . ' ([A]pache/[I]IS/[O]ther/[N]o) ';
        echo $msg;
        $input = null;

        while (($input != 'a') && ($input != 'i') && ($input != 'o') && ($input != 'n')) {
            if (null !== $input) {
                echo $msg;
            }
            $prompt = fopen("php://stdin", "r");
            $input = fgets($prompt, 32);
            $input = substr(strtolower(rtrim($input)), 0, 1);
            fclose ($prompt);
        }

        return $input;
    }

}
