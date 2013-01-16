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
 * @package    Pop_Event
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Service;

/**
 * This is the Locator class for the Service component.
 *
 * @category   Pop
 * @package    Pop_Service
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.2.0
 */
class Locator
{

    /**
     * Services
     * @var array
     */
    protected $services = array();

    /**
     * Services that are instantiated
     * @var array
     */
    protected $loaded = array();

    /**
     * Constructor
     *
     * Instantiate the service locator object.
     * Valid $services argument are ('params' are optional):
     *
     *     $services = array(
     *         'service => array(
     *             'class'  => 'SomeClass',
     *             'params' => array(...)
     *         ),
     *         ...
     *     );
     *
     * @param  array $services
     * @throws Exception
     * @return \Pop\Service\Locator
     */
    public function __construct(array $services = null)
    {
        if (null !== $services) {
            foreach ($services as $name => $service) {
                if (!isset($service['class'])) {
                    throw new Exception('Error: The $services configuration parameter was not valid.');
                }
                $params = (isset($service['params'])) ? $service['params'] : null;
                $this->set($name, $service['class'], $params);
            }
        }
    }

    /**
     * Load a service object. It will overwrite
     * any previous service with the same name.
     *
     * @param  string $name
     * @param  mixed  $class
     * @param  array  $params
     * @throws Exception
     * @return \Pop\Service\Locator
     */
    public function set($name, $class, array $params = null)
    {
        $this->services[$name] = array(
            'class'  => $class,
            'params' => $params
        );
        return $this;
    }

    /**
     * Get a service object.
     *
     * @param  string $name
     * @return mixed
     */
    public function get($name)
    {
        if (!isset($this->services[$name])) {
            return null;
        } else {
            if (!isset($this->loaded[$name])) {
                $this->load($name);
            }
            return $this->loaded[$name];
        }
    }

    /**
     * Remove a service
     *
     * @param  string $name
     * @return \Pop\Service\Locator
     */
    public function remove($name)
    {
        if (isset($this->services[$name])) {
            unset($this->services[$name]);
        }
        if (isset($this->loaded[$name])) {
            unset($this->loaded[$name]);
        }
        return $this;
    }

    /**
     * Load a service object. It will overwrite
     * any previous service with the same name.
     *
     * @param  string $name
     * @throws Exception
     * @return \Pop\Service\Locator
     */
    protected function load($name)
    {
        if (!isset($this->services[$name])) {
            throw new Exception('Error: The service \'' . $name . '\' is not set.');
        }

        $class = $this->services[$name]['class'];
        $params = $this->services[$name]['params'];

        if (is_string($class)) {
            if (null !== $params) {
                $reflect  = new \ReflectionClass($class);
                $obj = $reflect->newInstanceArgs($params);
            } else {
                $obj = new $class();
            }
        } else if (is_object($class)) {
            $obj = $class;
        } else {
            throw new Exception('Error: The $class parameter must be an object or a callable string.');
        }

        $this->loaded[$name] = $obj;
        return $this;
    }

}
