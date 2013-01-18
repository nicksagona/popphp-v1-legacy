<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Curl
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Curl;

/**
 * @category   Pop
 * @package    Pop_Curl
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    1.2.0
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
    protected $curl = null;

    /**
     * cURL options
     * @var array
     */
    protected $options = array();

    /**
     * Constructor
     *
     * Instantiate the cURL object.
     *
     * @param  array|int $opts
     * @param  string    $val
     * @return \Pop\Curl\Curl
     */
    public function __construct($opts, $val = null)
    {
        $this->curl = curl_init();
        $this->setOption($opts, $val);
    }

    /**
     * Set cURL session option(s).
     *
     * @param  array|int $opt
     * @param  string    $vl
     * @return \Pop\Curl\Curl
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
            curl_setopt_array($this->curl, $opt);

            // Set the protected property to the cURL options.
            foreach ($opt as $k => $v) {
                $this->options[$k] = $v;
            }
        // Else, set the single option.
        } else {
            // Special case for the CURLOPT_WRITEFUNCTION, setting the
            // callback function to the internal method 'processData'.
            if ($opt == CURLOPT_WRITEFUNCTION) {
                curl_setopt($this->curl, CURLOPT_WRITEFUNCTION, array($this, 'processData'));
                $this->options[$opt] = array($this, 'processData');
            // Else, set the cURL option.
            } else {
                curl_setopt($this->curl, $opt, $vl);
                $this->options[$opt] = $vl;
            }
        }

        return $this;
    }

    /**
     * Get a cURL session option.
     *
     * @param  int $opt
     * @return string
     */
    public function getOption($opt)
    {
        return (isset($this->options[$opt])) ? $this->options[$opt] : null;
    }

    /**
     * Execute the cURL session.
     *
     * @return mixed
     */
    public function execute()
    {
        // If the CURLOPT_RETURNTRANSFER option is set, return the data.
        if (isset($this->options[CURLOPT_RETURNTRANSFER]) && ($this->options[CURLOPT_RETURNTRANSFER] == true)) {
            $output = curl_exec($this->curl);
            return ($output === false) ? $this->showError() : $output;
        // Else, execute the cURL session.
        } else {
            $result = curl_exec($this->curl);
            if ($result === false) {
                $this->showError();
            } else {
                return $result;
            }
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
     * @param  int $opt
     * @return array|string
     */
    public function getinfo($opt = null)
    {
        return (null !== $opt) ? curl_getinfo($this->curl, $opt) : curl_getinfo($this->curl);
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
    protected function showError()
    {
        throw new Exception('Error: ' . curl_errno($this->curl) . ' => ' . curl_error($this->curl) . '.');
    }

    /**
     * Close the cURL session.
     *
     * @return void
     */
    public function __destruct()
    {
        curl_close($this->curl);
    }

}
