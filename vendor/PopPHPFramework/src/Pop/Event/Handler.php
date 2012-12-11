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

use Pop\Code\FunctionGenerator;

/**
 * This is the Handler class for the Event component.
 *
 * @category   Pop
 * @package    Pop_Event
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.3
 */
class Handler
{

    /**
     * Constant to stop the event handler
     * @var string
     */
    const STOP = 'Pop\Event\Handler::STOP';

    /**
     * Event listeners
     * @var array
     */
    protected $listeners = array();

    /**
     * Event listener priorities
     * @var array
     */
    protected $priorities = array();

    /**
     * Event results
     * @var array
     */
    protected $results = array();

    /**
     * Constructor
     *
     * Instantiate the event handler object.
     *
     * @param  string $name
     * @param  mixed  $action
     * @param  int    $priority
     * @return \Pop\Event\Handler
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
     * @return \Pop\Event\Handler
     */
    public function attach($name, $action, $priority = 0)
    {
        $this->listeners[$name] = $action;
        $this->priorities[$name] = $priority;

        return $this;
    }

    /**
     * Method to attach an event listener
     *
     * @param  string $name
     * @return \Pop\Event\Handler
     */
    public function detach($name)
    {
        if (isset($this->listeners[$name])) {
            unset($this->listeners[$name]);
        }

        if (isset($this->priorities[$name])) {
            unset($this->priorities[$name]);
        }

        return $this;
    }

    /**
     * Method to return an event listener
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
     * Method to return an event listener priority
     *
     * @param  string $name
     * @return int
     */
    public function getPriority($name)
    {
        $priority = null;
        if (isset($this->priorities[$name])) {
            $priority = $this->priorities[$name];
        }

        return $priority;
    }

    /**
     * Method to return the last event result
     *
     * @param  string $name
     * @return mixed
     */
    public function getResult($name)
    {
        return $this->results[$name];
    }

    /**
     * Method to trigger an event listener priority
     *
     * @param  mixed $obj
     * @param  int   $priority
     * @param  array $args
     * @return void
     */
    public function trigger($obj, $priority = 0, array $args = null)
    {
        $events = array();

        // Get high-priority events.
        if ($priority > 0) {
            foreach ($this->priorities as $key => $value) {
                if ($value > 0) {
                    $events[$key] = $value;
                }
            }
            arsort($events, SORT_NUMERIC);
        // Get routed events
        } else if ($priority == 0) {
            foreach ($this->priorities as $key => $value) {
                if ($value == 0) {
                    $events[$key] = $value;
                }
            }
        // Get low-priority events
        } else if ($priority < 0) {
            foreach ($this->priorities as $key => $value) {
                if ($value < 0) {
                    $events[$key] = $value;
                }
            }
            arsort($events, SORT_NUMERIC);
        }

        foreach ($events as $f => $p) {
            if (end($this->results) == self::STOP) {
                return;
            }

            $args['result'] = end($this->results);

            // Get and arrange the argument values in the correct order
            $func = new FunctionGenerator('anon', $this->listeners[$f]);
            $params = $func->getParameterNames();
            $realArgs = array();
            foreach ($params as $value) {
                $realArgs[$value] = $args[$value];
            }

            // Fire the event listener and store the result
            // If the trigger object is a controller object
            if ($obj instanceof \Pop\Mvc\Controller) {
                $uri = str_replace('/', '.', $obj->getRequest()->getRequestUri());
                if (substr($uri, -1) == '.') {
                    $uri = substr($uri, 0, -1);
                }
                // Check for wildcard match
                if (substr($f, -1) == '*') {
                    $fChk = substr($f, strpos($f, '.'));
                    $fChk = substr($fChk, 0, -1);
                    if (substr($fChk, -1) == '.') {
                        $fChk = substr($fChk, 0, -1);
                    }
                    if (substr($uri, 0, strlen($fChk)) == $fChk) {
                        $this->results[$f] = call_user_func_array($this->listeners[$f], $realArgs);
                    }
                // Check for direct match
                } else {
                    if (substr($f, 0 - strlen($uri)) == $uri) {
                        $this->results[$f] = call_user_func_array($this->listeners[$f], $realArgs);
                    }
                }
            // Else, if the trigger object is a project object
            } else {
                $this->results[$f] = call_user_func_array($this->listeners[$f], $realArgs);
            }
        }

    }

}
