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
        $run->appendToBody('parent::run();', false);

        $projectCls->setNamespace($ns);
        $projectCls->code()->setParent('P')
                           ->addMethod($run);
        $projectCls->save();

        // Create the controller class file
        if (isset($install->controller)) {
            if (!file_exists($install->project->base . '/module/' . $install->project->name . '/view')) {
                mkdir($install->project->base . '/module/' . $install->project->name . '/view');
            }
            $controllerCls = new Generator(
                $install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Controller.php',
                Generator::CREATE_CLASS
            );

            // Set namespace
            $ns = new NamespaceGenerator($install->project->name);
            $ns->setUses(
                array(
                    'Pop\\Http\\Response',
                    'Pop\\Http\\Request',
                    array('Pop\\Mvc\\Controller', 'C'),
                    'Pop\\Mvc\\Model',
                    'Pop\\Mvc\\View'
                )
            );

            $construct = new MethodGenerator('__construct');
            $construct->setDesc('Constructer method to instantiate the controller object');
            $construct->addArguments(
                array(
                    array('name' => 'request', 'value' => 'null', 'type' => 'Request'),
                    array('name' => 'response', 'value' => 'null', 'type' => 'Response'),
                    array('name' => 'viewPath', 'value' => 'null')
                )
            );
            $construct->appendToBody("if (null === \$viewPath) {")
                      ->appendToBody("    \$viewPath = __DIR__ . '/../../view';")
                      ->appendToBody("}")
                      ->appendToBody("parent::__construct(\$request, \$response, \$viewPath);")
                      ->appendToBody("if (\$this->_request->getRequestUri() == '/') {")
                      ->appendToBody("    \$this->index();")
                      ->appendToBody("} else if (!is_null(\$this->_request->getPath(0)) && method_exists(\$this, \$this->_request->getPath(0))) {")
                      ->appendToBody("    \$path = \$this->_request->getPath(0);")
                      ->appendToBody("    \$this->\$path();")
                      ->appendToBody("} else {")
                      ->appendToBody("    \$this->_isError = true;")
                      ->appendToBody("    \$this->error();")
                      ->appendToBody("}", false);

            $controllerCls->setNamespace($ns);
            $controllerCls->code()->setParent('C')
                                  ->addMethod($construct);

            $views = $install->controller->asArray();
            foreach ($views as $key => $value) {
                if (file_exists($installDir . '/view/' . $value)) {
                    copy($installDir . '/view/' . $value, $install->project->base . '/module/' . $install->project->name . '/view/' . $value);
                }

                $method = new MethodGenerator($key);
                $method->setDesc('Add your model data here within the \'' . $key . '()\' method to inject into the view.');
                $method->appendToBody("\$this->_view = View::factory(\$this->_viewPath . '/{$value}');", false);

                $controllerCls->code()->addMethod($method);
            }
            $controllerCls->save();
        }

        $input = self::installWeb();

        if ($input != 'n') {
            if (file_exists(__DIR__ . '/Web/index.php')) {
                copy(__DIR__ . '/Web/index.php', $install->project->docroot . '/index.php');
            }
            if ($input == 'a') {
                if (file_exists(__DIR__ . '/Web/ht.access')) {
                    copy(__DIR__ . '/Web/ht.access', $install->project->docroot . '/.htaccess');
                }
            } else {
                if (file_exists(__DIR__ . '/Web/web.config')) {
                    copy(__DIR__ . '/Web/web.config', $install->project->docroot . '/web.config');
                }
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
        $msg = Locale::factory()->__('Install index controller and web configuration files?') . ' ([A]pache/[I]IS/[N]o) ';
        echo $msg;
        $input = null;

        while (($input != 'a') && ($input != 'i') && ($input != 'n')) {
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
