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
    Pop\Filter\String,
    Pop\Locale\Locale;

/**
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Controllers
{

    /**
     * Install the controller class files
     *
     * @param Pop\Config $install
     * @param string     $installDir
     * @return void
     */
    public static function install($install, $installDir)
    {
        echo Locale::factory()->__('Creating controller class files...') . PHP_EOL;

        // Make the controller folder
        $ctrlDir = $install->project->base . '/module/' . $install->project->name . '/src/' . $install->project->name . '/Controller';
        if (!file_exists($ctrlDir)) {
            mkdir($ctrlDir);
        }

        // Create the controller class files
        if (isset($install->controllers)) {
            $controllers = $install->controllers->asArray();
            foreach ($controllers as $controller => $views) {
                // Create the '/view' folder for the controller
                if (!file_exists($install->project->base . '/module/' . $install->project->name . '/view/' . $controller)) {
                    mkdir($install->project->base . '/module/' . $install->project->name . '/view/' . $controller);
                }

                // Create new controller class file
                $controllerCls = new Generator(
                    $install->project->base . '/module/' . $install->project->name .
                        '/src/' . $install->project->name . '/Controller/' .
                         ucfirst(String::factory($controller)->underscoreToCamelcase()) . 'Controller.php',
                    Generator::CREATE_CLASS
                );

                // Set namespace
                $ns = new NamespaceGenerator($install->project->name . '\\Controller');
                $ns->setUses(
                    array(
                        'Pop\\Http\\Response',
                        'Pop\\Http\\Request',
                        array('Pop\\Mvc\\Controller', 'C'),
                        'Pop\\Mvc\\Model',
                        'Pop\\Mvc\\View'
                    )
                );

                // Create the constructor
                $construct = new MethodGenerator('__construct');
                $construct->setDesc('Constructer method to instantiate the controller object');
                $construct->addArguments(
                    array(
                        array('name' => 'request', 'value' => 'null', 'type' => 'Request'),
                        array('name' => 'response', 'value' => 'null', 'type' => 'Response'),
                        array('name' => 'viewPath', 'value' => 'null', 'type' => 'string')
                    )
                );

                $construct->appendToBody("if (null === \$viewPath) {")
                          ->appendToBody("    \$viewPath = __DIR__ . '/../../../view/{$controller}';")
                          ->appendToBody("}" . PHP_EOL)
                          ->appendToBody("parent::__construct(\$request, \$response, \$viewPath);");

                if (array_key_exists('index', $views) && array_key_exists('error', $views)) {
                    $construct->appendToBody("if (\$this->_request->getRequestUri() == '/') {")
                              ->appendToBody("    \$this->index();")
                              ->appendToBody("} else {")
                              ->appendToBody("    \$this->_isError = true;")
                              ->appendToBody("    \$this->error();")
                              ->appendToBody("}", false);
                } else if (array_key_exists('index', $views)) {
                    $construct->appendToBody("if (\$this->_request->getRequestUri() == '/') {")
                              ->appendToBody("    \$this->index();")
                              ->appendToBody("}", false);
                }

                $construct->getDocblock()->setReturn('void');

                $controllerCls->setNamespace($ns);
                $controllerCls->code()->setParent('C')
                                      ->addMethod($construct);

                // Create methods named after each view
                foreach ($views as $key => $value) {
                    if (!file_exists($install->project->base . '/module/' . $install->project->name . '/view/' . $controller)) {
                        mkdir($install->project->base . '/module/' . $install->project->name . '/view/' . $controller);
                    }
                    if (file_exists($installDir . '/view/' . $controller . '/' . $value)) {
                        copy($installDir . '/view/' . $controller . '/' . $value, $install->project->base . '/module/' . $install->project->name . '/view/' . $controller . '/' . $value);
                    }

                    $method = new MethodGenerator($key);
                    $method->setDesc('Add your model data here within the \'' . $key . '()\' method to inject into the view.');
                    $method->appendToBody("\$this->_view = View::factory(\$this->_viewPath . '/{$value}');");
                    $method->appendToBody("\$this->dispatch();", false);
                    $method->getDocblock()->setReturn('void');

                    $controllerCls->code()->addMethod($method);
                }

                // Save the new controller class file
                $controllerCls->save();
            }
        }
    }

}
