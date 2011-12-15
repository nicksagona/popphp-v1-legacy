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
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Mvc;

use Pop\Http\Response,
    Pop\Http\Request;

/**
 * @category   Pop
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9
 */
class Controller
{

    /**
     * Request
     * @var Pop\Http\Request
     */
    protected $_request = null;

    /**
     * Response
     * @var Pop\Http\Response
     */
    protected $_response = null;

    /**
     * Data model object
     * @var Pop\Mvc\Model
     */
    protected $_model = null;

    /**
     * View object
     * @var Pop\Mvc\View
     */
    protected $_view = null;

    /**
     * View path
     * @var string
     */
    protected $_viewPath = null;

    /**
     * Constructor
     *
     * Instantiate the controller object
     *
     * @param Pop\Http\Request  $request
     * @param Pop\Http\Response $response
     * @param string            $viewPath
     * @return void
     */
    public function __construct(Pop\Http\Request $request = null, Pop\Http\Response $response = null, $viewPath = null)
    {
        $this->_request = (null !== $request) ? $request : new Request();
        $this->_response = (null !== $response) ? $response : new Response(200, array('Content-Type' => 'text/html'));

        if (null !== $viewPath) {
            $this->_viewPath = $viewPath;
        }
    }

    /**
     * Set the request object
     *
     * @param  Pop\Http\Request
     * @return Pop\Mvc\Controller
     */
    public function setRequest(Pop\Http\Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * Set the response object
     *
     * @param  Pop\Http\Response
     * @return Pop\Mvc\Controller
     */
    public function setResponse(Pop\Http\Response $response)
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * Set the response object
     *
     * @param  string $viewPath
     * @return Pop\Mvc\Controller
     */
    public function setViewPath($viewPath)
    {
        $this->_viewPath = $viewPath;
        return $this;
    }

    /**
     * Get the request object
     *
     * @return Pop\Http\Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Get the repsonse object
     *
     * @return Pop\Http\Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Get the view path
     *
     * @return string
     */
    public function getViewPath()
    {
        return $this->_viewPath;
    }

    /**
     * Finalize the request and send the response.
     *
     * @param  int    $code
     * @param  array  $headers
     * @return void
     */
    public function dispatch($code = 200, array $headers = null)
    {
        $this->_response->setCode($code);

        if (null !== $headers) {
            foreach ($headers as $name => $value) {
                $this->_response->setHeader($name, $value);
            }
        }

        $this->_response->setBody($this->_view->render(true));
        $this->_response->send();
    }

}
