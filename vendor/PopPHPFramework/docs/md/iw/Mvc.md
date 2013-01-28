Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

×ž×¨×›×™×‘ MVC, ×›×¤×™ ×©×ž×ª×•×?×¨ ×‘×¡×§×™×¨×ª ×”×ª×™×¢×•×“, ×”×•×?
×™×™×©×•×? ×©×œ ×ª×‘× ×™×ª ×¢×™×¦×•×‘ MVC, ×¢×? ×©×›×‘×” ×”× ×•×¡×¤×ª
×©×œ ×”× ×ª×‘ ×›×“×™ ×œ×”×§×œ ×¢×œ ×ž×©×ª×ž×© ×ž×¨×•×‘×™×? × ×ª×™×‘×™×?
×•×‘×§×¨×™×?. ×‘×ž×™×œ×™×? ×¤×©×•×˜×•×ª, ×”×‘×§×¨ ×ž×˜×¤×œ ×ž×©×œ×—×ª
×©×œ ×‘×§×©×•×ª, ×”×ž×•×“×œ ×ž×˜×¤×œ ×‘×œ×•×’×™×§×” ×”×¢×¡×§×™×ª
×•×”×”×©×§×¤×” ×§×•×‘×¢×ª ×›×™×¦×“ ×œ×”×¦×™×’ ×?×ª ×”×¤×œ×˜
×œ×ž×©×ª×ž×©. ×›×œ ×”×©×™×¢×•×¨×™×? ×”×?×œ×” ×‘×ª×•×š ×¨×›×™×‘ ×–×” ×”×?
×§×œ×™×? ×ž×?×•×“ ×œ×”×?×¨×›×” ×›×“×™ ×œ×ž× ×£ ×?×•×ª×? ×‘×ª×•×š
×”×™×™×©×•×? ×©×œ×š.

×?×ž× ×? ×–×” ×?×•×œ×™ × ×¨×?×” ×ž×•×¨×›×‘ ×ž×“×™, ×?×? ×?×ª×”
×ž×©×ª×ž×© ×‘×ª×›×•× ×ª ×”×ª×§× ×ª ×¤×¨×•×™×§×˜ ×ž×¨×›×™×‘ CLI, ×¨×•×‘
×”×§×•×“ ×”×–×” ×™×›×•×œ ×œ×”×™×•×ª ×›×ª×•×‘ ×•×™×•×ª×§×Ÿ ×¢×‘×•×¨×š.
×?×ª×” ×¤×©×•×˜ ×¦×¨×™×š ×œ×”×’×“×™×¨ ×?×ª ×©×? ×¤×¨×•×™×§×˜
×•×”×’×“×¨×•×ª ×‘×§×•×‘×¥ ×ª×¦×•×¨×ª ×”×”×ª×§× ×”. ×¦×¤×” ×‘×§×•×‘×¥ doc
×ž×¨×›×™×‘ ×¤×¨×•×™×§×˜ ×›×“×™ ×œ×§×‘×œ ×“×•×’×ž×” ×©×œ ×§×•×‘×¥
×ª×¦×•×¨×ª ×”×ª×§× ×ª ×¤×¨×•×™×§×˜.

    use Pop\Mvc\Controller,
        Pop\Mvc\Model,
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

    class MyModel extends Model
    {
        // Perhaps does something special pertaining to whatever data you are manipulating
    }

    class MyController extends Controller
    {
        // Constructor
        public function __construct(Request $request = null, Response $response = null, Project $project = null, $viewPath = null)
        {
            if (null === $viewPath) {
                $viewPath = __DIR__ . '/path/to/my/view/default';
            }

            parent::__construct($request, $response, $project, $viewPath);
        }

        // Your home page
        public function index()
        {
            $model = new MyModel(array('username' => 'myusername');
            $this->view = View::factory($this->viewPath . '/index.phtml', $model);
            $this->send();
        }

        // Your 404 page
        public function error()
        {
            $this->isError = true;
            $this->view = View::factory($this->viewPath . '/error.phtml');
            $this->send();
        }
    }

    // Create a project object, to define the project config, router and controller(s)
    $project = MyProject::factory(
        include '../some/config/project.config.php',
        include '../some/config/module.config.php',
        new Router(array(
            '/' => 'MyApp\MyController'
        ))
    );

    // Run the project
    $project->run();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
