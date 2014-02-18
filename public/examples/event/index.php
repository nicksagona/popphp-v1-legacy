<?php

require_once '../../bootstrap.php';

use Pop\Http\Request;
use Pop\Http\Response;
use Pop\Mvc\Controller;
use Pop\Mvc\Router;
use Pop\Mvc\View;
use Pop\Project\Project;

class IndexController extends Controller
{
    public function __construct(Request $request = null, Response $response = null, Project $project = null, $viewPath = null)
    {
        // Set the view path
        if (null === $viewPath) {
            $viewPath = __DIR__;
        }

        // Create a request
        if (null === $request) {
            $request = new Request();
        }

        parent::__construct($request, $response, $project, $viewPath);
    }

    public function index()
    {
        $this->view = View::factory(
            $this->viewPath . '/index.phtml',
            array(
                'title' => 'Test Event',
                'subtitle' => 'Home Page',
                'content' => 'This is the home page'
            )
        );
        $this->send();
    }

    public function users()
    {
        $this->view = View::factory(
            $this->viewPath . '/index.phtml',
            array(
                'title' => 'Test Event',
                'subtitle' => 'Users Page',
                'content' => 'This is the users page'
            )
        );
        $this->send();
    }

    public function error()
    {
        $this->view = View::factory(
            $this->viewPath . '/index.phtml',
            array(
                'title' => 'Test Event',
                'subtitle' => 'Error Page',
                'content' => 'Page not found.'
            )
        );
        $this->send(404);
    }

}

try {
    $project = new Project(null, null, new Router(array(
        '/' => 'IndexController'
    )));
    $project->attachEvent(
        'dispatch',
        function ($controller) {
            if ($controller->getRequest()->getRequestUri() == '/') {
                $controller->getView()->set('subtitle', 'This is the REVISED Home Page Subtitle.');
                return 'Hello World! This is the home page!';
            }
        }
    );
    $project->attachEvent(
        'dispatch',
        function ($controller, $result) {
            if ($controller->getRequest()->getRequestUri() == '/') {
                $controller->getView()->set('content', $result);
            }
        }
    );
    $project->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}

