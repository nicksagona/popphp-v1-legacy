<?php
require_once '../../../bootstrap.php';

use Pop\Http\Request,
    Pop\Http\Response,
    Pop\Mvc\Controller,
    Pop\Mvc\Model,
    Pop\Mvc\View;

/*
 * Placing a class here is highly unorthodox.
 * This is just for example purposes only.
 */
class TestController extends Controller {

    public function __construct(Request $request = null, Response $response = null, $viewPath = null) {
        if (is_null($viewPath)) {
            $viewPath = __DIR__ . '/view';
        }
        parent::__construct($request, $response, $viewPath);
        if ($this->_request->getRequestUri() == '/') {
            $this->index();
        } else if (!is_null($this->_request->getPath(0)) && method_exists($this, $this->_request->getPath(0))) {
            $path = $this->_request->getPath(0);
            $this->$path();
        } else {
            $this->error();
        }
    }

    public static function init(Request $request = null, Response $response = null, $viewPath = null)
    {
        return new self($request, $response, $viewPath);
    }

    public function index()
    {
        $page = array('title' => 'Home Page', 'header' => 'This is the home page.');
        $this->_view = View::factory($this->_viewPath . '/home.php', new Model($page));
        $this->dispatch();
    }

    public function blog()
    {
        $page = array('title' => 'Blog | Some Article', 'header' => 'This is the blog page.');
        $this->_view = View::factory($this->_viewPath . '/blog.php', new Model($page));
        $this->dispatch();
    }

    public function error()
    {
        $page = array('title' => 'Error | 404', 'header' => 'This is the error page.');
        $this->_view = View::factory($this->_viewPath . '/error.php', new Model($page));
        $this->dispatch(404);
    }
}

try {
    TestController::init();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

?>