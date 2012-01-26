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
 * @package    Pop_Data
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Data;

use Pop\Data\Csv,
    Pop\Data\Json,
    Pop\Data\Sql,
    Pop\Data\Xml,
    Pop\Data\Yaml,
    Pop\File\File;

/**
 * @category   Pop
 * @package    Pop_Data
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Data
{

    /**
     * Data file stream
     * @var string
     */
    protected $_file = null;

    /**
     * Data file type
     * @var string
     */
    protected $_type = null;

    /**
     * Data stream
     * @var string
     */
    protected $_data = null;

    /**
     * Data table
     * @var string
     */
    protected $_table = null;

    /**
     * Data identifier quote
     * @var string
     */
    protected $_idQuote = null;

    /**
     * PMA compatible XML flag
     * @var boolean
     */
    protected $_pma = false;

    /**
     * Constructor
     *
     * Instantiate the data object.
     *
     * @param  string $data
     * @return void
     */
    public function __construct($data)
    {
        if ((is_string($data)) &&
            ((stripos($data, '.csv') !== false) ||
             (stripos($data, '.json') !== false) ||
             (stripos($data, '.sql') !== false) ||
             (stripos($data, '.xml') !== false) ||
             (stripos($data, '.yml') !== false) ||
             (stripos($data, '.yaml') !== false)) && file_exists($data)) {

            $file = new File($data);
            $this->_file = $file->read();
            $this->_type = ($file->ext == 'yml') ? 'Yaml' : ucfirst(strtolower($file->ext));
        } else {
            $this->_data = $data;
        }
    }

    /**
     * Get the file stream
     *
     * @return string
     */
    public function getFile()
    {
        return $this->_file;
    }

    /**
     * Get the data stream
     *
     * @return string
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Set the table name
     *
     * @param  string $table
     * @return Pop\Data\Data
     */
    public function setTable($table)
    {
        $this->_table = $table;
        return $this;
    }

    /**
     * Set the identifier quote
     *
     * @param  string $quote
     * @return Pop\Data\Data
     */
    public function setIdQuote($quote)
    {
        $this->_idQuote = $quote;
        return $this;
    }

    /**
     * Set the PMA compatible XML flag
     *
     * @param  boolean $comp
     * @return Pop\Data\Data
     */
    public function setPma($comp)
    {
        $this->_pma = (boolean)$comp;
        return $this;
    }

    /**
     * Parse the data file stream and return a PHP data object.
     *
     * @return mixed
     */
    public function parseFile()
    {
        $class = 'Pop\\Data\\' . $this->_type;
        $this->_data = $class::decode($this->_file);
        return $this->_data;
    }

    /**
     * Parse the data stream and return a file data stream.
     *
     * @param  string $to
     * @throws Exception
     * @return mixed
     */
    public function parseData($to)
    {
        $to = strtolower($to);
        $types = array('csv', 'json', 'sql', 'xml', 'yaml');

        if (!in_array($to, $types)) {
            throw new Exception('That data type is not supported.');
        }

        $class = 'Pop\\Data\\' . ucfirst($to);

        if ($to == 'sql') {
            $this->_file = $class::encode($this->_data, $this->_table, $this->_idQuote);
        } else if ($to == 'xml') {
            $this->_file = $class::encode($this->_data, $this->_table, $this->_pma);
        } else {
            $this->_file = $class::encode($this->_data);
        }

        return $this->_file;
    }

}
