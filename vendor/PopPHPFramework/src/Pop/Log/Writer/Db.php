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
namespace Pop\Log\Writer;

/**
 * This is the Db writer class for the Log component.
 *
 * @category   Pop
 * @package    Pop_Log
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.0.3
 */
class Db implements WriterInterface
{

    /**
     * Table record object that represents the log table in the database
     * @var \Pop\Record\Record
     */
    protected $table = null;

    /**
     * Constructor
     *
     * Instantiate the DB writer object.
     *
     * @param  \Pop\Record\Record $table
     * @return \Pop\Log\Writer\Db
     */
    public function __construct(\Pop\Record\Record $table)
    {
        $this->table = $table;
    }

    /**
     * Method to write to the log
     *
     * @param  array $logEntry
     * @return \Pop\Log\Writer\Db
     */
    public function writeLog(array $logEntry)
    {
        $this->table->setValues($logEntry)
                    ->save();

        return $this;
    }

}
