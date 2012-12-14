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
    Pop\Http\Request,
    Pop\Project\Project;

/**
 * This is the Controller class for the Mvc component.
 *
 * @category   Pop
 * @package    Pop_Mvc
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.1.0
 */
class Controller
{

    /**
     * Request
     * @var \Pop\Http\Request
     */
    protected $request = null;

    /**
     * Response
     * @var \Pop\Http\Response
     */
    protected $response = null;

    /**
     * Project config object
     * @var \Pop\Project\Project
     */
    protected $project = null;

    /**
     * Data model object
     * @var \Pop\Mvc\Model
     */
    protected $model = null;

    /**
     * View object
     * @var \Pop\Mvc\View
     */
    protected $view = null;

    /**
     * View path
     * @var string
     */
    protected $viewPath = null;

    /**
     * Constructor
     *
     * Instantiate the controller object
     *
     * @param Request  $request
     * @param Response $response
     * @param Project  $project
     * @param string   $viewPath
     * @return \Pop\Mvc\Controller
     */
    public function __construct(Request $request = null, Response $response = null, Project $project = null, $viewPath = null)
    {
        $this->request = (null !== $request) ? $request : new Request();
        $this->response = (null !== $response) ? $response : new Response(200, array('Content-Type' => 'text/html'));

        if (null !== $project) {
            $this->project = $project;
        }

        if (null !== $viewPath) {
            $this->viewPath = $viewPath;
        }
    }

    /**
     * Set the request object
     *
     * @param  Request $request
     * @return \Pop\Mvc\Controller
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * Set the response object
     *
     * @param  Response $response
     * @return \Pop\Mvc\Controller
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Set the response object
     *
     * @param  Project $project
     * @return \Pop\Mvc\Controller
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * Set the response object
     *
     * @param  string $viewPath
     * @return \Pop\Mvc\Controller
     */
    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
        return $this;
    }

    /**
     * Get the request object
     *
     * @return \Pop\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the response object
     *
     * @return \Pop\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get the project object
     *
     * @return \Pop\Project\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Get the view object
     *
     * @return \Pop\Mvc\View
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Get the view path
     *
     * @return string
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }

    /**
     * Dispatch the controller based on the action
     *
     * @param  string $action
     * @throws \Pop\Mvc\Exception
     * @return \Pop\Mvc\Controller
     */
    public function dispatch($action = 'index')
    {
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            throw new Exception('That action is not defined in the controller.');
        }
    }

    /**
     * Finalize the request and send the response.
     *
     * @param  int    $code
     * @param  array  $headers
     * @throws \Pop\Mvc\Exception
     * @return void
     */
    public function send($code = 200, array $headers = null)
    {
        if (null === $this->view) {
            throw new Exception('The view object is not defined.');
        }

        if (!($this->view instanceof View)) {
            throw new Exception('The view object is not an instance of Pop\Mvc\View.');
        }

        $this->response->setCode($code);

        if (null !== $headers) {
            foreach ($headers as $name => $value) {
                $this->response->setHeader($name, $value);
            }
        }

        // Trigger any dispatch events, then send the response
        $this->project->getEventManager()->trigger('dispatch', array('controller' => $this));
        $this->response->setBody($this->view->render(true));
        $this->response->send();
    }

}
