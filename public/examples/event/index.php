<?php

require_once '../../bootstrap.php';

use Pop\Event\Handler,
    Pop\Http\Request,
    Pop\Http\Response,
    Pop\Mvc\Controller,
    Pop\Mvc\Model,
    Pop\Mvc\Router,
    Pop\Mvc\View,
    Pop\Project\Project;

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
        $this->view = View::factory($this->viewPath . '/index.phtml', new Model(array('title' => 'Test Event', 'subtitle' => 'Home Page', 'content' => 'This is the home page')));
        $this->send();
    }

    public function users()
    {
        if ($this->request->getPath(1) == 'add') {
            $this->view = View::factory($this->viewPath . '/index.phtml', new Model(array('title' => 'Test Event', 'subtitle' => 'Users Page &gt; Add User', 'content' => 'This is the add users page')));
            $this->send();
        } else {
            $this->view = View::factory($this->viewPath . '/index.phtml', new Model(array('title' => 'Test Event', 'subtitle' => 'Users Page', 'content' => 'This is the users page')));
            $this->send();
        }
    }

    public function error()
    {
        $this->view = View::factory($this->viewPath . '/index.phtml', new Model(array('title' => 'Test Event', 'subtitle' => 'Error Page', 'content' => 'Page not found.')));
        $this->send(404);
    }

}

try {
    $project = new Project(null, null, new Router(array(
        '/' => 'IndexController'
    )));
    $project->attachEvent('render.users', function ($view) { $view->getModel()->set('subtitle', 'This is the REVISED user subtitle.'); }, 0)
            ->attachEvent('render.users.add', function ($view) { $view->getModel()->set('subtitle', 'This is the REVISED user ADD subtitle.'); }, 0)
            ->attachEvent('log.users.*', function ($view) { $view->getModel()->set('content', 'This is the global REVISED user content.'); }, 0);

    $project->run(array('name' => 'World!'));
} catch (\Exception $e) {
    echo $e->getMessage();
}

