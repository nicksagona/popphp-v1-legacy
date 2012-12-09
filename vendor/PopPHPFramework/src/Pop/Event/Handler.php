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

/**
 * This is the Reader class for the Feed component.
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

        // Get pre-level events.
        if ($priority > 0) {
            foreach ($this->priorities as $key => $value) {
                if ($value > 0) {
                    $events[$key] = $value;
                }
            }
            arsort($events, SORT_NUMERIC);
        // Get 0-level events
        } else if ($priority == 0) {
            foreach ($this->priorities as $key => $value) {
                if ($value == 0) {
                    $events[$key] = $value;
                }
            }
        // Get post-level events
        } else if ($priority < 0) {
            foreach ($this->priorities as $key => $value) {
                if ($value < 0) {
                    $events[$key] = $value;
                }
            }
            arsort($events, SORT_NUMERIC);
        }

        print_r($events);

    }

}
