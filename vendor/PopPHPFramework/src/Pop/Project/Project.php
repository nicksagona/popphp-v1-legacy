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
     * Project config
     * @var Pop\Config
     */
    protected $_config = null;

    /**
     * Project module configs
     * @var array
     */
    protected $_modules = array();

    /**
     * Project controller
     * @var Pop\Mvc\Controller
     */
    protected $_controller = null;

    /**
     * Constructor
     *
     * Instantiate a project object
     *
     * @param  Pop\Config $config
     * @param  Pop\Config $module
     * @return void
     */
    public function __construct(Config $config, Config $module = null)
    {
        $this->_config = $config;
        if (null !== $module) {
            $this->loadModule($module);
        }
    }

    /**
     * Static method to instantiate the project object and return itself
     * to facilitate chaining methods together.
     *
     * @param  Pop\Config $config
     * @param  Pop\Config $module
     * @return Pop\Project\Project
     */
    public static function factory(Config $config, Config $module = null)
    {
        return new self($config, $module);
    }

    /**
     * Access the project config
     *
     * @return Pop\Config
     */
    public function config()
    {
        return $this->_config;
    }

    /**
     * Access a project module config
     *
     * @return Pop\Config
     */
    public function module($name)
    {
        $module = null;
        if (array_key_exists($name, $this->_modules)) {
            $module =  $this->_modules[$name];
        }
        return $module;
    }

    /**
     * Access the project controller
     *
     * @return Pop\Mvc\Controller
     */
    public function controller()
    {
        if ((null === $this->_controller) && (null !== $this->_config->controller)) {
            $this->_controller = new $this->_config->controller();
        }
        return $this->_controller;
    }

    /**
     * Load a module config
     *
     * @param  Pop\Config $module
     * @throws Exception
     * @return Pop\Project\Project
     */
    public function loadModule(Config $module)
    {
        if (!isset($module->name)) {
            throw new Exception(Locale::factory()->__('The module name must be set in the module config.'));
        }
        $this->_modules[$module->name] = $module;
        return $this;
    }

    /**
     * Run the project
     *
     * @param  Pop\Config $module
     * @throws Exception
     * @return Pop\Project\Project
     */
    public function run()
    {
        if (null !== $this->controller()) {
            $this->_controller = new $this->_config->controller();
            $this->dispatch();
        }
    }

}
