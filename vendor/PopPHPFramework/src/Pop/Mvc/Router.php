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
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
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
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.2
 */
class Router
{

    /**
     * Request object
     * @var Pop\Http\Request
     */
    protected $request = null;

    /**
     * Current controller object
     * @var Pop\Mvc\Controller
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
     * @param array            $controllers
     * @param Pop\Http\Request $request
     * @return void
     */
    public function __construct(array $controllers, $request = null)
    {
        $this->request = (null !== $request) ? $request : new Request();
        $this->controllers = $controllers;
    }

    /**
     * Create a Pop\Mvc\Router object
     *
     * @param array            $controllers
     * @param Pop\Http\Request $request
     * @return Pop\Mvc\Router
     */
    public static function factory(array $controllers, $request = null)
    {
        return new self($controllers, $request);
    }

    /**
     * Add controllers
     *
     * @param array $controller
     * @return Pop\Mvc\Router
     */
    public function addControllers(array $controller)
    {
        foreach ($controller as $key => $value) {
            $this->controllers[$key] = $value;
        }
        return $this;
    }

    /**
     * Get the controller object
     *
     * @return Pop\Mvc\Controller
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
        if (null !== $this->controller) {
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
    public function route(Project $project)
    {
        $ctrlCls = null;

        // If a non-default route exists
        if (($this->request->getPath(0) != '') && (array_key_exists('/' . $this->request->getPath(0), $this->controllers))) {
            $route = '/' . $this->request->getPath(0);

            // If the route has multiple options
            if (is_array($this->controllers[$route])) {
                if (($this->request->getPath(1) != '') && (array_key_exists('/' . $this->request->getPath(1), $this->controllers[$route]))) {
                    $ctrlCls = $this->controllers[$route]['/' . $this->request->getPath(1)];
                } else if (isset($this->controllers[$route]['/'])){
                    $ctrlCls = $this->controllers[$route]['/'];
                }
            // Else, use the defined route
            } else {
                $ctrlCls = $this->controllers[$route];
            }
        // Else, use the default route
        } else if (array_key_exists('/', $this->controllers)) {
            $ctrlCls = $this->controllers['/'];
        }

        // Create the controller
        if ((null !== $ctrlCls) && class_exists($ctrlCls)) {
            $this->controller = new $ctrlCls(null, null, $project);
        }
    }

}
