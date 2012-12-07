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
    protected $listeners = array(
        'global' => array(
            'pre'  => array(),
            'post' => array()
        ),
        'routes' => array(
            'pre'  => array(),
            'post' => array()
        )
    );

    /**
     * Constructor
     *
     * Instantiate the event handler object.
     *
     * @param  string $name
     * @param  mixed  $action
     * @return \Pop\Event\Handler
     */
    public function __construct($name = null, $action = null)
    {
        if ((null !== $name) && (null !== $action)) {
            $this->attach($name, $action);
        }
    }

    /**
     * Method to attach an event listener
     *
     * @param  string $name
     * @param  mixed  $action
     * @return \Pop\Event\Handler
     */
    public function attach($name, $action)
    {
        $listenerName = $this->parseName($name);

        if ($listenerName['type'] == 'global') {
            $this->listeners['global'][$listenerName['order']][$listenerName['name']] = $action;
        } else {
            $this->listeners['routes'][$listenerName['order']][$listenerName['type']][$listenerName['name']] = $action;
        }

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
        $listenerName = $this->parseName($name);

        if ($listenerName['type'] == 'global') {
            if (isset($this->listeners['global'][$listenerName['order']][$listenerName['name']])) {
                unset($this->listeners['global'][$listenerName['order']][$listenerName['name']]);
            }
        } else {
            if (isset($this->listeners['routes'][$listenerName['order']][$listenerName['type']][$listenerName['name']])) {
                unset($this->listeners['routes'][$listenerName['order']][$listenerName['type']][$listenerName['name']]);
            }
        }

        return $this;
    }

    /**
     * Method to return an event listener
     *
     * @param  string $name
     * @return mixed
     */
    public function getListener($name)
    {
        $listener = null;
        $listenerName = $this->parseName($name);

        if ($listenerName['type'] == 'global') {
            if (isset($this->listeners['global'][$listenerName['order']][$listenerName['name']])) {
                $listener = $this->listeners['global'][$listenerName['order']][$listenerName['name']];
            }
        } else {
            if (isset($this->listeners['routes'][$listenerName['order']][$listenerName['type']][$listenerName['name']])) {
                $listener = $this->listeners['routes'][$listenerName['order']][$listenerName['type']][$listenerName['name']];
            }
        }

        return $listener;
    }

    /**
     * Method to see if the event handler has global events
     *
     * @param  string $order
     * @return boolean
     */
    public function hasGlobal($order)
    {
        $result = false;

        if (($order == 'pre') || ($order == 'post')) {
            $result = (count($this->listeners['global'][$order]) > 0);
        }

        return $result;
    }

    /**
     * Method to see if the event handler has routed events
     *
     * @param  string $order
     * @return boolean
     */
    public function hasRoutes($order)
    {
        $result = false;

        if (($order == 'pre') || ($order == 'post')) {
            $result = (count($this->listeners['routes'][$order]) > 0);
        }

        return $result;
    }

    /**
     * Method to parse listener name
     *
     * @param  string $name
     * @return array
     */
    protected function parseName($name)
    {
        $nameAry = explode('.', $name);
        $parsedName = array();

        switch (count($nameAry)) {
            case 4:
                $parsedName['name'] = $nameAry[0];
                $parsedName['order'] = (($nameAry[1] == 'pre') || ($nameAry[1] == 'post')) ? $nameAry[1] : 'pre';
                $parsedName['type'] = ($nameAry[2] != '') ? '/' . $nameAry[2] : '/';
                $parsedName['type'] .= ($nameAry[3] != '') ? '/' . $nameAry[3] : '/';
                break;

            case 3:
                $parsedName['name'] = $nameAry[0];
                $parsedName['order'] = (($nameAry[1] == 'pre') || ($nameAry[1] == 'post')) ? $nameAry[1] : 'pre';
                $parsedName['type'] = ($nameAry[2] != '') ? '/' . $nameAry[2] : '/';
                break;

            case 2:
                $parsedName['name'] = $nameAry[0];
                $parsedName['order'] = (($nameAry[1] == 'pre') || ($nameAry[1] == 'post')) ? $nameAry[1] : 'pre';
                $parsedName['type'] = 'global';
                break;

            default:
                $parsedName['name'] = $nameAry[0];
                $parsedName['order'] = 'pre';
                $parsedName['type'] = 'global';
        }

        return $parsedName;
    }

}
