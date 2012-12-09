<?php

require_once '../../bootstrap.php';

use Pop\Event\Handler,
    Pop\Http\Request,
    Pop\Http\Response,
    Pop\Mvc\Controller,
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
        $this->view = View::factory($this->viewPath . '/index.phtml');
        $this->send();
    }

    public function users()
    {
        if ($this->request->getPath(1) == 'add') {
            $this->view = View::factory($this->viewPath . '/add.phtml');
            $this->send();
        } else {
            $this->view = View::factory($this->viewPath . '/index.phtml');
            $this->send();
        }
    }

}

try {
    $project = new Project(null, null, new Router(array(
        '/' => 'IndexController'
    )));
    $project->attachEvent('dispatch.', function () { return 'Hello, World!'; }, 0)
            ->attachEvent('render.users', function ($result, $view) { echo 'How are you doing, ' . $view . '? (The last result was: ' . $result . ')'; }, 0)
            ->attachEvent('log.users.add', function ($result, $view) { echo 'How are you doing, ' . $view . '? (The last result was: ' . $result . ')'; }, 0);

    $project->run(array('name' => 'World!'));
    //$events = new Handler('dispatch', function ($name) { return 'Hello, ' . $name; }, 2);
    //$events->attach('render', function ($result, $name) { return 'How are you doing, ' . $name . '? (The last result was: ' . $result . ')'; }, 1)
    //       ->attach('log', function ($name) { return 'Goodbye, ' . $name; }, -1);
    //
    //echo '<br />Triggering pre-events...<br />' . PHP_EOL;
    //$events->trigger($events, 1, array('name' => 'World!'));
    //
    //echo '<br />Triggering post-events...<br />' . PHP_EOL;
    //$events->trigger($events, -1, array('name' => 'World!'));

    //print_r($events);

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

