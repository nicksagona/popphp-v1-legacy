Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

Компонент MVC, как указано в документации описание, является реализацией
шаблона проектирования MVC, с дополнительным слоем маршрутизатор для
облегчения несколькими путями пользователей и контроллеров. Проще
говоря, контроллер обрабатывает запросы делегации, модель обрабатывает
бизнес-логики и представления определяет, как отображать результат
пользователю. Все эти классы в рамках этого компонента очень легко
распространяется использовать их в ваших собственных приложениях.

Хотя это может показаться слишком сложным, если вы используете проект
CLI установки компонента функция, большая часть этого кода может быть
написана и установлена ​​для вас. Вы просто должны определить имя
проекта и настройки в файл конфигурации установки. Просмотр проекта
компонент Doc файл, чтобы получить пример проекта установки файла
конфигурации.

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
