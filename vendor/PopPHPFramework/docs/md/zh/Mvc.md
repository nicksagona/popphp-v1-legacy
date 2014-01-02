Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

中列出的文档概述，MVC组件，是一个实现了MVC的设计模式，附加层的路由器，以方便多个用户的路径和控制器。简单地说，控制器处理请求的代表团，该模型处理业务逻辑，并决定如何显示输出到用户的观点。这个组件内的所有这些类是很容易的扩展到利用他们在自己的应用程序。

虽然这可能看起来过于复杂，如果您使用CLI安装组件项目功能，大部分代码可以书面和为您安装。你只需要定义的项目名称，并在安装配置文件的设置。查看项目的组成部分DOC文件，以获得一个项目的安装配置文件的一个例子。

    use Pop\Mvc\Controller,
        Pop\Mvc\Router,
        Pop\Mvc\View,
        Pop\Project\Project;

    // Define your project class
    class MyProject extends Project
    {
        // Extend the parent 'run' method to establish router paths
        public function run()
        {
            parent::run();
        }
    }

    class MyModel
    {
        // Perhaps does something special pertaining to whatever data you are manipulating
    }

    class MyController extends Controller
    {
        // Constructor
        public function __construct(Request $request = null, Response $response = null, Project $project = null, $viewPath = null)
        {
            if (null === $viewPath) {
                $viewPath = __DIR__ . '/path/to/my/view';
            }

            parent::__construct($request, $response, $project, $viewPath);
        }

        // Your home page
        public function index()
        {
            $model = new MyModel(array('username' => 'myusername');
            $this->view = View::factory($this->viewPath . '/index.phtml', $model->getmyData()); // This would return an array into the view object
            $this->send();
        }

        // Your 404 page
        public function error()
        {
            $this->view = View::factory($this->viewPath . '/error.phtml');
            $this->send(404);
        }
    }

    // Create a project object, to define the project config, router and controller(s)
    $project = MyProject::factory(
        include '../some/config/project.php',
        include '../some/config/module.php',
        new Router(array(
            '/' => 'MyApp\MyController'
        ))
    );

    // Run the project
    $project->run();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
