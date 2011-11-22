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
 * @package    Pop_Http
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Http_Response
 *
 * @category   Pop
 * @package    Pop_Http
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Http_Response
{

    /**
     * Response codes & messages
     * @var array
     */
    protected static $_responseCodes = array(
                                           // Informational 1xx
                                           100 => 'Continue',
                                           101 => 'Switching Protocols',

                                           // Success 2xx
                                           200 => 'OK',
                                           201 => 'Created',
                                           202 => 'Accepted',
                                           203 => 'Non-Authoritative Information',
                                           204 => 'No Content',
                                           205 => 'Reset Content',
                                           206 => 'Partial Content',

                                           // Redirection 3xx
                                           300 => 'Multiple Choices',
                                           301 => 'Moved Permanently',
                                           302 => 'Found',
                                           303 => 'See Other',
                                           304 => 'Not Modified',
                                           305 => 'Use Proxy',
                                           307 => 'Temporary Redirect',

                                           // Client Error 4xx
                                           400 => 'Bad Request',
                                           401 => 'Unauthorized',
                                           402 => 'Payment Required',
                                           403 => 'Forbidden',
                                           404 => 'Not Found',
                                           405 => 'Method Not Allowed',
                                           406 => 'Not Acceptable',
                                           407 => 'Proxy Authentication Required',
                                           408 => 'Request Timeout',
                                           409 => 'Conflict',
                                           410 => 'Gone',
                                           411 => 'Length Required',
                                           412 => 'Precondition Failed',
                                           413 => 'Request Entity Too Large',
                                           414 => 'Request-URI Too Long',
                                           415 => 'Unsupported Media Type',
                                           416 => 'Requested Range Not Satisfiable',
                                           417 => 'Expectation Failed',

                                           // Server Error 5xx
                                           500 => 'Internal Server Error',
                                           501 => 'Not Implemented',
                                           502 => 'Bad Gateway',
                                           503 => 'Service Unavailable',
                                           504 => 'Gateway Timeout',
                                           505 => 'HTTP Version Not Supported',
                                           509 => 'Bandwidth Limit Exceeded'
                                       );

    /**
     * HTTP version
     * @var string
     */
    protected $_version = '1.1';

    /**
     * Response codes
     * @var int
     */
    protected $_code = null;

    /**
     * Response message
     * @var string
     */
    protected $_message = null;

    /**
     * Response headers
     * @var array
     */
    protected $_headers = array();

    /**
     * Response body
     * @var string
     */
    protected $_body = null;

    /**
     * Language object
     * @var Pop_Locale
     */
    protected $_lang = null;

    /**
     * Constructor
     *
     * Instantiate the response object.
     *
     * @param  int    $code
     * @param  array  $headers
     * @param  string $body
     * @param  string $message
     * @param  string $version
     * @throws Exception
     * @return void
     */
    public function __construct($code, array $headers, $body = null, $message = null, $version = '1.1')
    {
        $this->_lang = new Pop_Locale();

        if (!array_key_exists($code, self::$_responseCodes)) {
            throw new Exception($this->_lang->__("That header code '%1' is not allowed.", $code));
        } else {
            $this->_code = $code;
            $this->_message = (null !== $message) ? $message : self::$_responseCodes[$code];
            $this->_body = $body;
            $this->_version = $version;

            foreach ($headers as $name => $value) {
                $this->_headers[$name] = $value;
            }
        }
    }

    /**
     * Parse a response and create a new response object,
     * either from a URL or a full response string
     *
     * @param  string $response
     * @throws Exception
     * @return Pop_Http_Response
     */
    public static function parse($response)
    {
        $headers = array();

        // If a URL, use a stream to get the header and URL contents
        if ((strtolower(substr($response, 0, 7)) == 'http://') || (strtolower(substr($response, 0, 8)) == 'https://')) {
            $stream = fopen($response, 'r');
            $meta = stream_get_meta_data($stream);
            $body = stream_get_contents($stream);

            $firstLine = $meta['wrapper_data'][0];
            unset($meta['wrapper_data'][0]);
            $allHeadersAry = $meta['wrapper_data'];
            $bodyStr = $body;
        // Else, if a response string, parse the headers and contents
        } else if (substr($response, 0, 5) == 'HTTP/'){
            if (strpos($response, "\r") !== false) {
                $headerStr = substr($response, 0, strpos($response, "\r\n\r\n"));
                $bodyStr = substr($response, (strpos($response, "\r\n\r\n") + 4));
            } else {
                $headerStr = substr($response, 0, strpos($response, "\n\n"));
                $bodyStr = substr($response, (strpos($response, "\n\n") + 2));
            }

            $firstLine = trim(substr($headerStr, 0, strpos($headerStr, "\n")));
            $firstLine = substr($firstLine, (strpos($firstLine, '/') + 1));
            $allHeaders = trim(substr($headerStr, strpos($headerStr, "\n")));
            $allHeadersAry = explode("\n", $allHeaders);
        } else {
            throw new Exception(Pop_Locale::load()->__('The response was not properly formatted.'));
        }

        // Get the version, code and message
        $version = substr($firstLine, 0, strpos($firstLine, ' '));
        preg_match('/\d\d\d/', $firstLine, $match);
        $code = $match[0];
        $message = str_replace($version . ' ' . $code . ' ', '', $firstLine);

        // Get the headers
        foreach ($allHeadersAry as $hdr) {
            $name = substr($hdr, 0, strpos($hdr, ':'));
            $value = substr($hdr, (strpos($hdr, ' ') + 1));
            $headers[trim($name)] = trim($value);
        }

        // If the body content is encoded, decode the body content
        if (array_key_exists('Content-Encoding', $headers)) {
            if (isset($headers['Transfer-Encoding']) && ($headers['Transfer-Encoding'] == 'chunked')) {
                $bodyStr = self::decodeChunkedBody($bodyStr);
            }
            $body = self::decodeBody($bodyStr, $headers['Content-Encoding']);
        } else {
            $body = $bodyStr;
        }

        return new Pop_Http_Response($code, $headers, $body, $message, $version);
    }

    /**
     * Send redirect
     *
     * @param  string $url
     * @param  string $version
     * @throws Exception
     * @return void
     */
    public static function redirect($url, $version = '1.1')
    {
        if (headers_sent()) {
            throw new Exception(Pop_Locale::load()->__('The headers have already been sent.'));
        } else {
            header("HTTP/{$version} 302 Found");
            header("Location: {$url}");
        }
    }

    /**
     * Get response message from code
     *
     * @param  array $code
     * @throws Exception
     * @return string
     */
    public static function getMessageFromCode($code)
    {
        if (!array_key_exists($code, self::$_responseCodes)) {
            throw new Exception(Pop_Locale::load()->__("That header code '%1' is not allowed.", $code));
        } else {
            return self::$_responseCodes[$code];
        }
    }

    /**
     * Encode the body data.
     *
     * @param  string $body
     * @param  string $encode
     * @throws Exception
     * @return string
     */
    public static function encodeBody($body, $encode)
    {
        switch ($encode) {
            // GZIP compression
            case 'gzip':
                if (!function_exists('gzencode')) {
                    throw new Exception(Pop_Locale::load()->__('Gzip compression is not available.'));
                } else {
                    $encodedBody = gzencode($body);
                }
                break;

            // Deflate compression
            case 'deflate':
                if (!function_exists('gzdeflate')) {
                    throw new Exception(Pop_Locale::load()->__('Deflate compression is not available.'));
                } else {
                    $encodedBody = gzdeflate($body);
                }
                break;

            // Unknown compression
            default:
                $encodedBody = $body;

        }

        return $encodedBody;
    }

    /**
     * Decode the body data.
     *
     * @param  string $body
     * @param  string $decode
     * @throws Exception
     * @return string
     */
    public static function decodeBody($body, $decode)
    {
        switch ($decode) {
            // GZIP compression
            case 'gzip':
                if (!function_exists('gzinflate')) {
                    throw new Exception(Pop_Locale::load()->__('Gzip compression is not available.'));
                } else {
                    $decodedBody = gzinflate(substr($body, 10));
                }
                break;

            // Deflate compression
            case 'deflate':
                if (!function_exists('gzinflate')) {
                    throw new Exception(Pop_Locale::load()->__('Deflate compression is not available.'));
                } else {
                    $zlibHeader = unpack('n', substr($body, 0, 2));
                    $decodedBody = ($zlibHeader[1] % 31 == 0) ? gzuncompress($body) : gzinflate($body);
                }
                break;

            // Unknown compression
            default:
                $decodedBody = $body;

        }

        return $decodedBody;
    }

    /**
     * Decode a chunked transfer-encoded body and return the decoded text
     *
     * @param string $body
     * @return string
     */
    public static function decodeChunkedBody($body)
    {
        $decoded = '';

        while($body != '') {
            $lf_pos = strpos($body, "\012");
            if($lf_pos === false) {
                $decoded .= $body;
                break;
            }
            $chunk_hex = trim(substr($body, 0, $lf_pos));
            $sc_pos = strpos($chunk_hex, ';');
            if($sc_pos !== false)
                $chunk_hex = substr($chunk_hex, 0, $sc_pos);
            if($chunk_hex == '') {
                $decoded .= substr($body, 0, $lf_pos);
                $body = substr($body, $lf_pos + 1);
                continue;
            }
            $chunk_len = hexdec($chunk_hex);
            if($chunk_len) {
                $decoded .= substr($body, $lf_pos + 1, $chunk_len);
                $body = substr($body, $lf_pos + 2 + $chunk_len);
            } else {
                $body = '';
            }
        }

        return $decoded;
    }

    /**
     * Determine if the response is successful
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        $type = floor($this->_code / 100);
        return (($type == 3) || ($type == 2) || ($type == 1)) ? true : false;
    }

    /**
     * Determine if the response is a redirect
     *
     * @return boolean
     */
    public function isRedirect()
    {
        $type = floor($this->_code / 100);
        return ($type == 3) ? true : false;
    }

    /**
     * Determine if the response is an error
     *
     * @return boolean
     */
    public function isError()
    {
        $type = floor($this->_code / 100);
        return (($type == 5) || ($type == 4)) ? true : false;
    }

    /**
     * Get the response code
     *
     * @return int
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Get the response message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * Get the response body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * Get the response headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * Get the response headers
     *
     * @param  string $name
     * @return string
     */
    public function getHeader($name)
    {
        return (isset($this->_headers[$name])) ? $this->_headers[$name] : null;
    }

    /**
     * Get the response headers as a string
     *
     * @return string
     */
    public function getHeadersAsString($status = true, $br = "\n")
    {
        $headers = '';

        if ($status) {
            $headers = "HTTP/{$this->_version} {$this->_code} {$this->_message}{$br}";
        }

        foreach ($this->_headers as $name => $value) {
            $headers .= "{$name}: {$value}{$br}";
        }

        return $headers;
    }

    /**
     * Set the response code
     *
     * @param  int $code
     * @throws Exception
     * @return Pop_Http_Response
     */
    public function setCode($code)
    {
        if (!array_key_exists($code, self::$_responseCodes)) {
            throw new Exception($this->_lang->__("That header code '%1' is not allowed.", $code));
        } else {
            $this->_code = $code;
            $this->_message = self::$_responseCodes[$code];
        }

        return $this;
    }

    /**
     * Set the response message
     *
     * @param  string $message
     * @return Pop_Http_Response
     */
    public function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }

    /**
     * Set the response body
     *
     * @param  string $body
     * @return Pop_Http_Response
     */
    public function setBody($body = null)
    {
        $this->_body = $body;
        return $this;
    }

    /**
     * Set a response header
     *
     * @param  string $name
     * @param  string $value
     * @throws Exception
     * @return Pop_Http_Response
     */
    public function setHeader($name, $value)
    {
        $this->_headers[$name] = $value;
        return $this;
    }

    /**
     * Set response headers
     *
     * @param  array $headers
     * @throws Exception
     * @return Pop_Http_Response
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $name => $value) {
            $this->_headers[$name] = $value;
        }

        return $this;
    }

    /**
     * Set IE SSL headers to fix file cache issues in IE over SSL.
     *
     * @return Pop_Http_Response
     */
    public function setSslHeaders()
    {
        $this->_headers['Expires'] = 0;
        $this->_headers['Cache-Control'] = 'private, must-revalidate';
        $this->_headers['Pragma'] = 'cache';

        return $this;
    }

    /**
     * Send response
     *
     * @throws Exception
     * @return void
     */
    public function send()
    {
        if (headers_sent()) {
            throw new Exception($this->_lang->__('The headers have already been sent.'));
        } else {
            header("HTTP/{$this->_version} {$this->_code} {$this->_message}");
            foreach ($this->_headers as $name => $value) {
                header($name . ": " . $value);
            }

            $body = $this->_body;
            if (array_key_exists('Content-Encoding', $this->_headers)) {
                $body = self::encodeBody($body, $this->_headers['Content-Encoding']);
                $this->_headers['Content-Length'] = strlen($body);
            }

            echo $body;
        }
    }

    /**
     * Return entire response as a string
     *
     * @return string
     */
    public function __toString()
    {
        $body = $this->_body;

        if (array_key_exists('Content-Encoding', $this->_headers)) {
            $body = self::encodeBody($body, $this->_headers['Content-Encoding']);
            $this->_headers['Content-Length'] = strlen($body);
        }

        return $this->getHeadersAsString() . "\n" . $body;
    }

}
