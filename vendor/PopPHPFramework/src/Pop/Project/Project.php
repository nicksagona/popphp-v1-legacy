<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Project;

use Pop\Config,
    Pop\Mvc\Router;

/**
 * Project class
 *
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2014 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.7.0
 */
class Project
{

    /**
     * Project config
     * @var \Pop\Config
     */
    protected $config = null;

    /**
     * Project module configs
     * @var array
     */
    protected $modules = array();

    /**
     * Project router
     * @var \Pop\Mvc\Router
     */
    protected $router = null;

    /**
     * Project events
     * @var \Pop\Event\Manager
     */
    protected $events = null;

    /**
     * Project services
     * @var \Pop\Service\Locator
     */
    protected $services = null;

    /**
     * Constructor
     *
     * Instantiate a project object
     *
     * @param  mixed           $config
     * @param  array           $module
     * @param  \Pop\Mvc\Router $router
     * @return \Pop\Project\Project
     */
    public function __construct($config = null, array $module = null, Router $router = null)
    {
        if (null !== $config) {
            $this->loadConfig($config);
        }

        if (null !== $module) {
            $this->loadModule($module);
        }

        if (null !== $router) {
            $this->loadRouter($router);
        }

        $this->events = new \Pop\Event\Manager();
        $this->services = new \Pop\Service\Locator();

        if (isset($this->config->defaultDb)) {
            $default = $this->config->defaultDb;
            \Pop\Db\Record::setDb($this->config->databases->$default);
        }
    }

    /**
     * Static method to instantiate the project object and return itself
     * to facilitate chaining methods together.
     *
     * @param  mixed           $config
     * @param  array           $module
     * @param  \Pop\Mvc\Router $router
     * @return \Pop\Project\Project
     */
    public static function factory($config = null, array $module = null, Router $router = null)
    {
        return new static($config, $module, $router);
    }

    /**
     * Access the project config
     *
     * @return \Pop\Config
     */
    public function config()
    {
        return $this->config;
    }

    /**
     * Access a project database
     *
     * @param  string $dbname
     * @return \Pop\Db\Db
     */
    public function database($dbname)
    {
        if (isset($this->config->databases) &&
            isset($this->config->databases->$dbname) &&
            ($this->config->databases->$dbname instanceof \Pop\Db\Db)) {
            return $this->config->databases->$dbname;
        } else {
            return null;
        }
    }

    /**
     * Access a project module config
     *
     * @param  string $name
     * @return \Pop\Config
     */
    public function module($name)
    {
        $module = null;
        if (array_key_exists($name, $this->modules)) {
            $module =  $this->modules[$name];
        }
        return $module;
    }

    /**
     * Determine whether a module is loaded
     *
     * @param  string $name
     * @return boolean
     */
    public function isLoaded($name)
    {
        return (array_key_exists($name, $this->modules));
    }

    /**
     * Access all project module configs
     *
     * @return array
     */
    public function modules()
    {
        return $this->modules;
    }

    /**
     * Access the project router
     *
     * @return \Pop\Mvc\Router
     */
    public function router()
    {
        return $this->router;
    }

    /**
     * Load a project config
     *
     * @param  mixed $config
     * @throws Exception
     * @return \Pop\Project\Project
     */
    public function loadConfig($config)
    {
        // Test to see if the config is already set and changes are allowed.
        if ((null !== $this->config) && (!$this->config->changesAllowed())) {
            throw new Exception('Real-time configuration changes are not allowed.');
        }

        // Else, set the new config
        if (is_array($config)) {
            $this->config = new Config($config);
        } else if ($config instanceof Config) {
            $this->config = $config;
        } else {
            throw new Exception('The project config must be either an array or an instance of Pop\\Config.');
        }

        return $this;
    }

    /**
     * Load a module config
     *
     * @param  array $module
     * @throws Exception
     * @return \Pop\Project\Project
     */
    public function loadModule(array $module)
    {
        foreach ($module as $key => $value) {
            if (is_array($value)) {
                $this->modules[$key] = new Config($value);
            } else if ($value instanceof Config) {
                $this->modules[$key] = $value;
            } else {
                throw new Exception('The module config must be either an array or an instance of Pop\\Config.');
            }
        }

        return $this;
    }

    /**
     * Load a router
     *
     * @param  \Pop\Mvc\Router $router
     * @return \Pop\Project\Project
     */
    public function loadRouter(Router $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * Attach an event. Default project event name hook-points are:
     *
     *   route.pre
     *   route
     *   route.error
     *   route.post
     *
     *   dispatch.pre
     *   dispatch
     *   dispatch.send
     *   dispatch.error
     *   dispatch.post
     *
     * @param  string $name
     * @param  mixed  $action
     * @param  int    $priority
     * @return \Pop\Project\Project
     */
    public function attachEvent($name, $action, $priority = 0)
    {
        $this->events->attach($name, $action, $priority);
        return $this;
    }

    /**
     * Detach an event. Default project event name hook-points are:
     *
     *   route.pre
     *   route
     *   route.error
     *   route.post
     *
     *   dispatch.pre
     *   dispatch
     *   dispatch.error
     *   dispatch.post
     *
     * @param  string $name
     * @param  mixed  $action
     * @return \Pop\Project\Project
     */
    public function detachEvent($name, $action)
    {
        $this->events->detach($name, $action);
        return $this;
    }

    /**
     * Get the event Manager
     *
     * @return \Pop\Event\Manager
     */
    public function getEventManager()
    {
        return $this->events;
    }

    /**
     * Set a service
     *
     * @param  string $name
     * @param  mixed  $call
     * @param  mixed  $params
     * @return \Pop\Project\Project
     */
    public function setService($name, $call, $params = null)
    {
        $this->services->set($name, $call, $params);
        return $this;
    }

    /**
     * Get a service
     *
     * @param  string $name
     * @return mixed
     */
    public function getService($name)
    {
        return $this->services->get($name);
    }

    /**
     * Get the service Locator
     *
     * @return \Pop\Service\Locator
     */
    public function getServiceLocator()
    {
        return $this->services;
    }

    /**
     * Run the project.
     *
     * @return void
     */
    public function run()
    {
        // If router exists, then route the project to the appropriate controller
        if (null !== $this->router) {
            // Trigger any pre-route events, route, then trigger any post-route events
            $this->events->trigger('route.pre', array('router' => $this->router));

            // If still alive after 'route.pre'
            if ($this->events->alive()) {
                $this->router->route($this);

                // If still alive after 'route'
                if ($this->events->alive()) {
                    $this->events->trigger('route.post', array('router' => $this->router));

                    // If still alive after 'route.post' and if a controller was properly
                    // routed and created, then dispatch it
                    if (($this->events->alive()) && (null !== $this->router->controller())) {
                        // Trigger any pre-dispatch events
                        $this->events->trigger('dispatch.pre', array('router' => $this->router));

                        // If still alive after 'dispatch.pre'
                        if ($this->events->alive()) {
                            // Get the action and dispatch it
                            $action = $this->router->getAction();

                            // Dispatch the found action, the error action or trigger the dispatch error events
                            if ((null !== $action) && method_exists($this->router->controller(), $action)) {
                                $this->router->controller()->dispatch($action);
                            } else if (method_exists($this->router->controller(), $this->router->controller()->getErrorAction())) {
                                $this->router->controller()->dispatch($this->router->controller()->getErrorAction());
                            } else {
                                $this->events->trigger('dispatch.error', array('router' => $this->router));
                            }
                            // If still alive after 'dispatch'
                            if ($this->events->alive()) {
                                // Trigger any post-dispatch events
                                $this->events->trigger('dispatch.post', array('router' => $this->router));
                            }
                        }
                    }
                }
            }
        }
    }

}
