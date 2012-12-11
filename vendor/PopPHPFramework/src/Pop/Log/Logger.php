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
 * @package    Pop_Log
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Log;

/**
 * This is the Logger class for the Log component.
 *
 * @category   Pop
 * @package    Pop_Log
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.3
 */
class Logger
{

    /**
     * Constants for message priorities
     * @var int
     */
    const EMERG  = 0;
    const ALERT  = 1;
    const CRIT   = 2;
    const ERR    = 3;
    const WARN   = 4;
    const NOTICE = 5;
    const INFO   = 6;
    const DEBUG  = 7;

    /**
     * Message priority short codes
     * @var array
     */
    protected $priorities = array(
        0 => 'EMERG',
        1 => 'ALERT',
        2 => 'CRIT',
        3 => 'ERR',
        4 => 'WARN',
        5 => 'NOTICE',
        6 => 'INFO',
        7 => 'DEBUG',
    );

    /**
     * Log writers
     * @var array
     */
    protected $writers = array();

    /**
     * Constructor
     *
     * Instantiate the logger object.
     *
     * @return \Pop\Log\Logger
     */
    public function __construct()
    {

    }

    /**
     * Method to add a log writer
     *
     * @return \Pop\Log\Logger
     */
    public function addWriter()
    {
        return $this;
    }

    /**
     * Method to get a log writer
     *
     * @param  string $name
     * @return mixed
     */
    public function getWriter($name)
    {
        return (isset($this->writers[$name])) ? $this->writers[$name] : null;
    }

    /**
     * Method to get all log writers
     *
     * @return array
     */
    public function getWriters()
    {
        return $this->writers;
    }

    /**
     * Method to remove a log writer
     *
     * @param  string $name
     * @return \Pop\Log\Logger
     */
    public function removeWriter($name)
    {
        if (isset($this->writers[$name])) {
            unset($this->writers[$name]);
        }
        return $this;
    }

    /**
     * Method to add a log entry
     *
     * @return \Pop\Log\Logger
     */
    public function log()
    {
        return $this;
    }

}
