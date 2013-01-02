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
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Mvc;

use Pop\Http\Request,
    Pop\Project\Project;

/**
 * This is the Router class for the Mvc component.
 *
 * @category   Pop
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.1
 */
class Router
{

    /**
     * Project object
     * @var \Pop\Project\Project
     */
    protected $project = null;

    /**
     * Request object
     * @var \Pop\Http\Request
     */
    protected $request = null;

    /**
     * Current controller class name string
     * @var string
     */
    protected $controllerClass = null;

    /**
     * Current controller object
     * @var \Pop\Mvc\Controller
     */
    protected $controller = null;

    /**
     * Array of available controllers class names
     * @var array
     */
    protected $controllers = array();

    /**
     * Constructor
     *
     * Instantiate the router object
     *
     * @param  array             $controllers
     * @param  \Pop\Http\Request $request
     * @return \Pop\Mvc\Router
     */
    public function __construct(array $controllers, $request = null)
    {
        $this->request = (null !== $request) ? $request : new Request();
        $this->controllers = $controllers;
    }

    /**
     * Create a Pop\Mvc\Router object
     *
     * @param  array             $controllers
     * @param  \Pop\Http\Request $request
     * @return \Pop\Mvc\Router
     */
    public static function factory(array $controllers, $request = null)
    {
        return new self($controllers, $request);
    }

    /**
     * Add controllers
     *
     * @param  array $controller
     * @return \Pop\Mvc\Router
     */
    public function addControllers(array $controller)
    {
        foreach ($controller as $key => $value) {
            $this->controllers[$key] = $value;
        }
        return $this;
    }

    /**
     * Get the project object
     *
     * @return \Pop\Project\Project
     */
    public function project()
    {
        return $this->project;
    }

    /**
     * Get the request object
     *
     * @return \Pop\Http\Request
     */
    public function request()
    {
        return $this->request;
    }

    /**
     * Get the controller class name string
     *
     * @return string
     */
    public function getControllerClass()
    {
        return $this->controllerClass;
    }

    /**
     * Get the current controller object
     *
     * @return \Pop\Mvc\Controller
     */
    public function controller()
    {
        return $this->controller;
    }

    /**
     * Get an available controller class name
     *
     * @param  string $controller
     * @return string
     */
    public function getController($controller)
    {
        return (isset($this->controllers[$controller])) ? $this->controllers[$controller] : null;
    }

    /**
     * Get array of controller class names
     *
     * @return array
     */
    public function getControllers()
    {
        return $this->controllers;
    }

    /**
     * Get action from request within the current controller
     *
     * @return string
     */
    public function getAction()
    {
        $action = null;
        if ((null !== $this->controller) && (null !== $this->controller->getRequest())) {
            $action = $this->controller->getRequest()->getPath(0);
        }
        return $action;
    }

    /**
     * Route to the controller
     *
     * @param  Project $project
     * @return void
     */
    public function route(Project $project = null)
    {
        $this->project = $project;

        // If a non-default route exists
        if (($this->request->getPath(0) != '') && (array_key_exists('/' . $this->request->getPath(0), $this->controllers))) {
            $route = '/' . $this->request->getPath(0);

            // If the route has multiple options
            if (is_array($this->controllers[$route])) {
                if (($this->request->getPath(1) != '') && (array_key_exists('/' . $this->request->getPath(1), $this->controllers[$route]))) {
                    $this->controllerClass = $this->controllers[$route]['/' . $this->request->getPath(1)];
                } else if (isset($this->controllers[$route]['/'])){
                    $this->controllerClass = $this->controllers[$route]['/'];
                }
            // Else, use the defined route
            } else {
                $this->controllerClass = $this->controllers[$route];
            }
        // Else, use the default route
        } else if (array_key_exists('/', $this->controllers)) {
            $this->controllerClass = $this->controllers['/'];
        }

        // If found, create the controller object
        if ((null !== $this->controllerClass) && class_exists($this->controllerClass)) {
            $this->controller = new $this->controllerClass(null, null, $project);
            $this->project->getEventManager()->trigger('route', array('router' => $this));
        // Else, trigger any route error events
        } else {
            $this->project->getEventManager()->trigger('route.error', array('router' => $this));
        }
    }

}
