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
     * Constructor
     *
     * Instantiate the service locator object.
     *
     * @param  string $name
     * @param  mixed  $class
     * @param  array  $params
     * @throws Exception
     * @return \Pop\Service\Locator
     */
    public function __construct($name, $class, array $params = null)
    {
        $this->set($name, $class, $params);
    }

    /**
     * Static method to instantiate the locator object and return itself
     * to facilitate chaining methods together.
     *
     * @param  string $name
     * @param  mixed  $class
     * @param  array  $params
     * @return \Pop\Service\Locator
     */
    public static function factory($name, $class, array $params = null)
    {
        return new self($name, $class, $params);
    }

    /**
     * Set a service object. It will overwrite any previous
     * service with the same name.
     *
     * @param  string $name
     * @param  mixed  $class
     * @param  array  $params
     * @throws Exception
     * @return \Pop\Service\Locator
     */
    public function set($name, $class, array $params = null)
    {
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

        $this->services[$name] = $obj;
    }

    /**
     * Get a service object.
     *
     * @param  string $name
     * @return mixed
     */
    public function get($name)
    {
        return (isset($this->services[$name])) ? $this->services[$name] : null;
    }

}
