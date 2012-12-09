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
namespace Pop\Project;

use Pop\Config,
    Pop\Db\Db,
    Pop\Event\Handler,
    Pop\Mvc\Router,
    Pop\Record\Record;

/**
 * This is the Project class for the Project component.
 *
 * @category   Pop
 * @package    Pop_Project
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.3
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
     * @var \Pop\Event\Handler
     */
    protected $events = null;

    /**
     * Constructor
     *
     * Instantiate a project object
     *
     * @param  mixed  $config
     * @param  array  $module
     * @param  Router $router
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

        if (isset($this->config->defaultDb)) {
            $default = $this->config->defaultDb;
            Record::setDb($this->config->databases->$default);
        }
    }

    /**
     * Static method to instantiate the project object and return itself
     * to facilitate chaining methods together.
     *
     * @param  mixed  $config
     * @param  array  $module
     * @param  Router $router
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
            ($this->config->databases->$dbname instanceof Db)) {
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
     * Attach an event
     *
     * @param  string $name
     * @param  mixed  $action
     * @param  int    $priority
     * @return \Pop\Project\Project
     */
    public function attachEvent($name, $action, $priority = 0)
    {
        if (null === $this->events) {
            $this->events = new Handler();
        }

        $this->events->attach($name, $action, $priority);
        return $this;
    }

    /**
     * Detach an event
     *
     * @param  string $name
     * @return \Pop\Project\Project
     */
    public function detachEvent($name)
    {
        if (null !== $this->events) {
            $this->events->detach($name);
        }

        return $this;
    }

    /**
     * Get the event handler
     *
     * @return \Pop\Event\Handler
     */
    public function getEventHandler()
    {
        return $this->events;
    }

    /**
     * Run the project
     *
     * @param  array $args
     * @return void
     */
    public function run(array $args = null)
    {

        // Trigger any high-priority events, if any exist
        if (null !== $this->events) {
            $this->events->trigger($this, 1, $args);
        }

        // If router exists, then route the project to the appropriate controller
        // Any routed events will be triggered by the controller
        if (null !== $this->router) {
            $this->router->route($this);

            // If a controller was properly routed and created, then dispatch it
            if (null !== $this->router()->controller()) {
                $action = ($this->router()->controller()->getRequest()->getRequestUri() == '/') ? 'index' : $this->router()->getAction();
                if ((null !== $action) && method_exists($this->router()->controller(), $action)) {
                    $this->router()->controller()->dispatch($action);
                } else if (method_exists($this->router()->controller(), 'error')) {
                    $this->router()->controller()->dispatch('error');
                }
            }
        }

        // Trigger any low-priority events, if any exist
        if (null !== $this->events) {
            $this->events->trigger($this, -1, $args);
        }

    }

}
