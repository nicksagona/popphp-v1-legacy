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
        'pre'  => array(),
        'post' => array()
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
        $this->listeners[$listenerName['order']][$listenerName['name']][$listenerName['suffix']] = $action;

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
        if (isset($this->listeners[$listenerName['order']][$listenerName['name']])) {
            unset($this->listeners[$listenerName['order']][$listenerName['name']]);
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

        if (isset($this->listeners[$listenerName['order']][$listenerName['name']][$listenerName['suffix']])) {
            $listener = $this->listeners[$listenerName['order']][$listenerName['name']][$listenerName['suffix']];
        }

        return $listener;
    }

    /**
     * Method to return an event listener by prefix
     *
     * @param  string $prefix
     * @return array
     */
    public function getListenersByPrefix($prefix)
    {
        $listeners = array();

        if (array_key_exists($prefix, $this->listeners['pre'])) {
            $listeners['pre'] = $this->listeners['pre'][$prefix];
        } else if (array_key_exists($prefix, $this->listeners['post'])) {
            $listeners['post'] = $this->listeners['post'][$prefix];
        }

        return $listeners;
    }

    /**
     * Method to return an event listener by suffix
     *
     * @param  string $suffix
     * @return array
     */
    public function getListenersBySuffix($suffix)
    {
        $listeners = array();

        foreach ($this->listeners['pre'] as $key => $value) {
            foreach ($value as $k => $v) {
                if (($k != '0') && ($k == $suffix)) {
                    if (!isset($listeners['pre'])) {
                        $listeners['pre'] = array();
                    }
                    $listeners['pre'][] = $v;
                }
            }
        }

        foreach ($this->listeners['post'] as $key => $value) {
            foreach ($value as $k => $v) {
                if (($k != '0') && ($k == $suffix)) {
                    if (!isset($listeners['post'])) {
                        $listeners['post'] = array();
                    }
                    $listeners['post'][] = $v;
                }
            }
        }

        return $listeners;
    }

    /**
     * Method to see if the event handler has pre events
     *
     * @return boolean
     */
    public function hasPre()
    {
        return (count($this->listeners['pre']) > 0);
    }

    /**
     * Method to see if the event handler has post events
     *
     * @return boolean
     */
    public function hasPost()
    {
        return (count($this->listeners['post']) > 0);
    }

    /**
     * Method to parse listener name
     *
     * @param  string $name
     * @throws \Pop\Event\Exception
     * @return array
     */
    protected function parseName($name)
    {
        $nameAry = explode('.', $name);
        $parsedName = array();

        if (count($nameAry) < 2) {
            throw new Exception('Error: The event name must contain at least two parts.');
        }

        if (($nameAry[1] != 'pre') && ($nameAry[1] != 'post')) {
            throw new Exception('Error: The second part of the event name must be \'pre\' or \'post\'.');
        }

        switch (count($nameAry)) {
            case 4:
                $parsedName['name'] = $nameAry[0];
                $parsedName['order'] = $nameAry[1];
                $parsedName['suffix'] = '.' . $nameAry[2] . '.' . $nameAry[3];
                break;

            case 3:
                $parsedName['name'] = $nameAry[0];
                $parsedName['order'] = $nameAry[1];
                $parsedName['suffix'] = '.' . $nameAry[2];
                break;

            default:
                $parsedName['name'] = $nameAry[0];
                $parsedName['order'] = $nameAry[1];
                $parsedName['suffix'] = 0;
        }

        return $parsedName;
    }

}
