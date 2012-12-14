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
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Event;

use Pop\Code\FunctionGenerator,
    Pop\Code\Reflection;

/**
 * This is the Manager class for the Event component.
 *
 * @category   Pop
 * @package    Pop_Event
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.0
 */
class Manager
{

    /**
     * Constant to stop the event Manager
     * @var string
     */
    const STOP = 'Pop\Event\Manager::STOP';

    /**
     * Event listeners
     * @var array
     */
    protected $listeners = array();

    /**
     * Event results
     * @var array
     */
    protected $results = array();

    /**
     * Constructor
     *
     * Instantiate the event Manager object.
     *
     * @param  string $name
     * @param  mixed  $action
     * @param  int    $priority
     * @return \Pop\Event\Manager
     */
    public function __construct($name = null, $action = null, $priority = 0)
    {
        if ((null !== $name) && (null !== $action)) {
            $this->attach($name, $action, $priority);
        }
    }

    /**
     * Method to attach an event listener
     *
     * @param  string $name
     * @param  mixed  $action
     * @param  int    $priority
     * @return \Pop\Event\Manager
     */
    public function attach($name, $action, $priority = 0)
    {
        if (!isset($this->listeners[$name])) {
            $this->listeners[$name] = new \SplPriorityQueue();
        }
        $this->listeners[$name]->insert($action, (int) $priority);

        return $this;
    }

    /**
     * Method to return an event
     *
     * @param  string $name
     * @return mixed
     */
    public function get($name)
    {
        $listener = null;
        if (isset($this->listeners[$name])) {
            $listener = $this->listeners[$name];
        }

        return $listener;
    }

    /**
     * Method to return the event results
     *
     * @param  string $name
     * @return mixed
     */
    public function getResults($name)
    {
        return $this->results[$name];
    }

    /**
     * Method to trigger an event listener priority
     *
     * @param  string $name
     * @param  array  $args
     * @throws Exception
     * @return void
     */
    public function trigger($name, array $args = array())
    {
        if (isset($this->listeners[$name])) {
            if (!isset($this->results[$name])) {
                $this->results[$name] = array();
            }

            foreach ($this->listeners[$name] as $action) {
                if (end($this->results[$name]) == self::STOP) {
                    return;
                }

                $args['result'] = end($this->results[$name]);
                $realArgs = array();
                $params = array();

                // Get and arrange the argument values in the correct order
                // If the action is a closure object
                if ($action instanceof \Closure) {
                    $func = new FunctionGenerator('anon', $action);
                    $params = $func->getParameterNames();
                // Else, if the action is a callable class/method combination
                } else if (is_callable($action, false, $callable_name)) {
                    $cls = substr($callable_name, 0, strpos($callable_name, ':'));
                    $mthd = substr($callable_name, (strrpos($callable_name, ':') + 1));
                    $reflect = new Reflection($cls);
                    $mthdParams = $reflect->getGenerator()->code()->getMethod($mthd)->getArguments();
                    foreach ($mthdParams as $key => $value) {
                        $params[] = str_replace('$', '', $key);
                    }
                } else {
                    throw new Exception('Error: The action must be callable, i.e. a closure or class/method combination.');
                }

                foreach ($params as $value) {
                    $realArgs[$value] = $args[$value];
                }

                $this->results[$name][] = call_user_func_array($action, $realArgs);
            }
        }
    }

}
