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
 * @package    Pop_Curl
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Curl;

/**
 * @category   Pop
 * @package    Pop_Curl
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Curl
{

    /**
     * cURL return data
     * @var string
     */
    public $data = null;

    /**
     * cURL resource
     * @var cURL resource
     */
    protected $_curl = null;

    /**
     * cURL options
     * @var array
     */
    protected $_options = array();

    /**
     * Constructor
     *
     * Instantiate the cURL object.
     *
     * @param  array|const $opts
     * @param  string $val
     * @return void
     */
    public function __construct($opts, $val = null)
    {
        $this->_curl = curl_init();
        $this->setOption($opts, $val);
    }

    /**
     * Set cURL session option(s).
     *
     * @param  array|const $opt
     * @param  mixed $vl
     * @return Pop\Curl\Curl
     */
    public function setOption($opt, $vl = null)
    {
        // If an array of options is passed.
        if (is_array($opt)) {
            // Special case for the CURLOPT_WRITEFUNCTION, setting the
            // callback function to the internal method 'processData'.
            if (array_key_exists(CURLOPT_WRITEFUNCTION, $opt) !== false) {
                $opt[CURLOPT_WRITEFUNCTION] = array($this, 'processData');
            }

            // Set the cURL options in the array.
            curl_setopt_array($this->_curl, $opt);

            // Set the protected property to the cURL options.
            foreach ($opt as $k => $v) {
                $this->_options[$k] = $v;
            }
        // Else, set the single option.
        } else {
            // Special case for the CURLOPT_WRITEFUNCTION, setting the
            // callback function to the internal method 'processData'.
            if ($opt == CURLOPT_WRITEFUNCTION) {
                curl_setopt($this->_curl, CURLOPT_WRITEFUNCTION, array($this, 'processData'));
                $this->_options[$opt] = array($this, 'processData');
            // Else, set the cURL option.
            } else {
                curl_setopt($this->_curl, $opt, $vl);
                $this->_options[$opt] = $vl;
            }
        }

        return $this;
    }

    /**
     * Get a cURL session option.
     *
     * @param  const $opt
     * @return string
     */
    public function getOption($opt)
    {
        return (isset($this->_options[$opt])) ? $this->_options[$opt] : null;
    }

    /**
     * Execute the cURL session.
     *
     * @return mixed
     */
    public function execute()
    {
        // If the CURLOPT_RETURNTRANSFER option is set, return the data.
        if (isset($this->_options[CURLOPT_RETURNTRANSFER]) && ($this->_options[CURLOPT_RETURNTRANSFER] == true)) {
            $output = curl_exec($this->_curl);
            return ($output === false) ? $this->_showError() : $output;
        // Else, execute the cURL session.
        } else if (curl_exec($this->_curl) === false) {
            $this->_showError();
        }
    }

    /**
     * Process the cURL data
     *
     * @param  resource $ch
     * @param  string $dt
     * @return int
     */
    public function processData($ch, $dt)
    {
        $this->data .= $dt;
        return strlen($dt);
    }

    /**
     * Return the cURL session last info.
     *
     * @return array|string
     */
    public function getinfo($opt = null)
    {
        return (null !== $opt) ? curl_getinfo($this->_curl, $opt) : curl_getinfo($this->_curl);
    }

    /**
     * Return the cURL version.
     *
     * @return array
     */
    public function version()
    {
        return curl_version();
    }

    /**
     * Throw an exception upon a cURL error.
     *
     * @throws Exception
     * @return void
     */
    protected function _showError()
    {
        throw new Exception('Error: ' . curl_errno($this->_curl) . ' => ' . curl_error($this->_curl) . '.');
    }

    /**
     * Close the cURL session.
     *
     * @return void
     */
    public function __destruct()
    {
        curl_close($this->_curl);
    }

}
