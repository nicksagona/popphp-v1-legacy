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
 * @category   Pop
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Router
{

    /**
     * Request object
     * @var Pop\Http\Request
     */
    protected $_request = null;

    /**
     * Current controller object
     * @var Pop\Mvc\Controller
     */
    protected $_controller = null;

    /**
     * Array of available controllers class names
     * @var array
     */
    protected $_controllers = array();

    /**
     * Constructor
     *
     * Instantiate the router object
     *
     * @param array $controllers
     * @return void
     */
    public function __construct(array $controllers)
    {
        $this->_request = new Request();
        $this->_controllers = $controllers;
    }

    /**
     * Create a Pop\Mvc\Router object
     *
     * @param array $controllers
     * @return Pop\Mvc\Router
     */
    public static function factory(array $controllers)
    {
        return new self($controllers);
    }

    /**
     * Add controllers
     *
     * @param array $controllers
     * @return Pop\Mvc\Router
     */
    public function addControllers(array $controller)
    {
        foreach ($controller as $key => $value) {
            $this->_controllers[$key] = $value;
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
        return $this->_controller;
    }

    /**
     * Get an available controller class name
     *
     * @return string
     */
    public function getController($controller)
    {
        return (isset($this->_controllers[$controller])) ? $this->_controllers[$controller] : null;
    }

    /**
     * Get array of controller class names
     *
     * @return array
     */
    public function getControllers()
    {
        return $this->_controllers;
    }

    /**
     * Route to the controller
     *
     * @param  Pop\Project\Project $project
     * @return void
     */
    public function route(Project $project)
    {
        $ctrlCls = null;

        if (array_key_exists($this->_request->getPath(0), $this->_controllers)) {
            $ctrlCls =  $this->_controllers[$this->_request->getPath(0)];
        } else if (array_key_exists('default', $this->_controllers)) {
            $ctrlCls =  $this->_controllers['default'];
        }

        if ((null !== $ctrlCls) && class_exists($ctrlCls)) {
            $this->_controller = new $ctrlCls(null, null, $project);
        }
    }

}
