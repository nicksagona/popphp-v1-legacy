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
     * @var Pop\Config
     */
    protected $config = null;

    /**
     * Project module configs
     * @var array
     */
    protected $modules = array();

    /**
     * Project router
     * @var Pop\Mvc\Router
     */
    protected $router = null;

    /**
     * Constructor
     *
     * Instantiate a project object
     *
     * @param  Config $config
     * @param  Config $module
     * @param  Router $router
     * @return void
     */
    public function __construct(Config $config, Config $module = null, Router $router = null)
    {
        $this->config = $config;
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
     * @param  Config $config
     * @param  Config $module
     * @param  Router $router
     * @return Pop\Project\Project
     */
    public static function factory(Config $config, Config $module = null, Router $router = null)
    {
        return new static($config, $module, $router);
    }

    /**
     * Access the project config
     *
     * @return Pop\Config
     */
    public function config()
    {
        return $this->config;
    }

    /**
     * Access a project database
     *
     * @param  string $dbname
     * @return Pop\Db\Db
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
     * @return Pop\Config
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
     * @return Pop\Mvc\Router
     */
    public function router()
    {
        return $this->router;
    }

    /**
     * Load a module config
     *
     * @param  Config $module
     * @throws Exception
     * @return Pop\Project\Project
     */
    public function loadModule(Config $module)
    {
        if (!isset($module->name)) {
            throw new Exception('The module name must be set in the module config.');
        }
        $this->modules[$module->name] = $module;
        return $this;
    }

    /**
     * Load a router
     *
     * @param Router $router
     * @return Pop\Project\Project
     */
    public function loadRouter(Router $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * Run the project
     *
     * @return void
     */
    public function run()
    {
        if (null !== $this->router) {
            $this->router->route($this);
        }
    }

}
