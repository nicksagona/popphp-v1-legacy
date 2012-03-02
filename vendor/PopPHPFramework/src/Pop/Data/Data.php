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
 * This is the Data class for the Data component.
 *
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
    protected $file = null;

    /**
     * Data file type
     * @var string
     */
    protected $type = null;

    /**
     * Data stream
     * @var string
     */
    protected $data = null;

    /**
     * Data table
     * @var string
     */
    protected $table = null;

    /**
     * Data identifier quote
     * @var string
     */
    protected $idQuote = null;

    /**
     * PMA compatible XML flag
     * @var boolean
     */
    protected $pma = false;

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
            $this->file = $file->read();
            $this->type = ($file->ext == 'yml') ? 'Yaml' : ucfirst(strtolower($file->ext));
        } else {
            $this->data = $data;
        }
    }

    /**
     * Get the file stream
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Get the data stream
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the table name
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get the ID quote
     *
     * @return string
     */
    public function getIdQuote()
    {
        return $this->idQuote;
    }

    /**
     * Get the PMA flag
     *
     * @return boolean
     */
    public function getPma()
    {
        return $this->pma;
    }

    /**
     * Set the table name
     *
     * @param  string $table
     * @return Pop\Data\Data
     */
    public function setTable($table)
    {
        $this->table = $table;
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
        $this->idQuote = $quote;
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
        $this->pma = (boolean)$comp;
        return $this;
    }

    /**
     * Parse the data file stream and return a PHP data object.
     *
     * @return mixed
     */
    public function parseFile()
    {
        $class = 'Pop\\Data\\' . $this->type;
        $this->data = $class::decode($this->file);
        return $this->data;
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
            $this->file = $class::encode($this->data, $this->table, $this->idQuote);
        } else if ($to == 'xml') {
            $this->file = $class::encode($this->data, $this->table, $this->pma);
        } else {
            $this->file = $class::encode($this->data);
        }

        return $this->file;
    }

}
