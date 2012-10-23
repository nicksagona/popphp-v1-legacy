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
    Pop\Locale\Locale,
    Pop\Project\Install;

/**
 * This is the Controllers class for the Project Install component.
 *
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.1
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
        $viewDir = $install->project->base . '/module/' . $install->project->name . '/view'; 
        
        if (!file_exists($ctrlDir)) {
            mkdir($ctrlDir);
        }
        
        if (!file_exists($viewDir)) {
            mkdir($viewDir);
        }        
        
        // Create the controller class files
        if (isset($install->controllers)) {
            $controllers = $install->controllers->asArray();

            foreach ($controllers as $key => $value) {
                // Create the folder structure and copy the view files
                $subs = Install::hasSubs($value);
                $parentDir = null;
                $subCtrlDir = $ctrlDir . '/' . ucfirst(String::underscoreToCamelcase(substr($key, 1)));
                $subViewDir = $viewDir . '/' . strtolower(substr($key, 1));
                if (!file_exists($subCtrlDir)) {
                    mkdir($subCtrlDir);
                }
                if (!file_exists($subViewDir)) {
                    mkdir($subViewDir);
                }
                if (count($subs > 0)) {
                    foreach ($subs as $sub) {
                        if (!file_exists($subViewDir . '/' . strtolower(substr($sub, 1)))) {
                            mkdir($subViewDir . '/' . strtolower(substr($sub, 1)));
                        }
                        foreach ($value[$sub] as $view) {
                            $curViewFile = $installDir . '/view/' . strtolower(substr($key, 1)) . '/' . strtolower(substr($sub, 1)) . '/' . $view;
                            if (file_exists($curViewFile)) {
                                copy($curViewFile, $subViewDir . '/' . strtolower(substr($sub, 1)) . '/' . $view);
                            }
                        }
                    }
                }
                
                // Copy the view files and create the controller classes
                foreach ($value as $action => $view) {
                    $ctrlCls = null;
                    $namespace = null;
                    $viewPath = null;
                    $methods = array();
                    $subMethods = array();
                    if (!is_array($view)) {
                        $cur = (($key == '/') ? null : $key);
                        $curViewDir = $viewDir . $cur;
                        if (!file_exists($curViewDir)) {
                            mkdir($curViewDir);
                        }
                        if (file_exists($installDir . '/view' . $cur . '/' . $view)) {
                            copy($installDir . '/view' . $cur . '/' . $view, $curViewDir . '/' . $view);
                        }
                        $ctrlCls = $subCtrlDir . '/' . ucfirst($action) . 'Controller.php';
                        $namespace = $install->project->name . '\Controller';
                        $viewPath = '/../../../view';
                        $methods[$action] = $view; 
                    } else {
                        $namespace = $install->project->name . '\Controller\\' . ucfirst(substr($action, 1));
                        $viewPath = '/../../../../view';
                        foreach ($view as $act => $vw) {
                            $subMethods[$act] = $vw;
                            $ctrlCls = $subCtrlDir . ucfirst($action) . '/' . ucfirst(substr($act, 1)) . 'Controller.php';
                        }
                        self::createController($ctrlCls, $namespace, $viewPath, $subMethods, $action . $act);
                    }
                    if (null !== $ctrlCls) {
                        self::createController($ctrlCls, $namespace, $viewPath, $methods, $action);
                    }                    
                }
                
            }

        }
    }

    /**
     * Create a new controller class file
     *
	 * @param string $ctrlCls
	 * @param string $namespace
	 * @param string $viewPath
	 * @param array  $methods
	 * @param string $action
     * @return void
     */
    public static function createController($ctrlCls, $namespace, $viewPath, $methods = array(), $action = '/')
    {
        $controllerCls = new Generator($ctrlCls, Generator::CREATE_CLASS);
        
        // Set namespace
        $ns = new NamespaceGenerator($namespace);
        $ns->setUses(array(
            'Pop\Http\Response',
            'Pop\Http\Request',
            array('Pop\Mvc\Controller', 'C'),
            'Pop\Mvc\Model',
            'Pop\Mvc\View',
            'Pop\Project\Project'
        ));
        
        // Create the constructor
        $construct = new MethodGenerator('__construct');
        $construct->setDesc('Constructor method to instantiate the controller object');
        $construct->addArguments(array(
            array('name' => 'request', 'value' => 'null', 'type' => 'Request'),
            array('name' => 'response', 'value' => 'null', 'type' => 'Response'),
            array('name' => 'project', 'value' => 'null', 'type' => 'Project'),
            array('name' => 'viewPath', 'value' => 'null', 'type' => 'string')
        ));
        
        $construct->appendToBody("if (null === \$viewPath) {")
                  ->appendToBody("    \$viewPath = __DIR__ . '{$viewPath}" . (($action != '/') ? $action : null) . "';")
                  ->appendToBody("}" . PHP_EOL);        
                  
        if ($action != '/') {
            $construct->appendToBody("if (null === \$request) {")
                      ->appendToBody("    \$request = new Request(null, '{$action}');")
                      ->appendToBody("}" . PHP_EOL);
        }
        
        $construct->appendToBody("parent::__construct(\$request, \$response, \$project, \$viewPath);", false);
        $construct->getDocblock()->setReturn('void');

        $controllerCls->setNamespace($ns);
        $controllerCls->code()->setParent('C')
                              ->addMethod($construct);    

        foreach ($methods as $key => $value) {
            $method = new MethodGenerator($key);
            $method->setDesc('Add your model data here within the \'' . $key . '()\' method to inject into the view.');

            if ($key == 'error') {
                $method->appendToBody("\$this->isError = true;");
            }

            $method->appendToBody("\$this->view = View::factory(\$this->viewPath . '/{$value}');");
            $method->appendToBody("\$this->send();", false);
            $method->getDocblock()->setReturn('void');

            $controllerCls->code()->addMethod($method);
        }
        
        // Save the controller class
        $controllerCls->save();
    }

}
