Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

La composante Mvc, comme indiqué dans la liste des documents, est une
implémentation du modèle de conception MVC, avec la couche
supplémentaire d'un routeur pour faciliter chemins multiples
utilisateurs et leurs contrôleurs. Autrement dit, le contrôleur gère la
délégation de la demande, le modèle gère la logique métier et la vue
détermine comment afficher la sortie à l'utilisateur. Toutes ces classes
au sein de cette composante sont très facile d'étendre les exploiter
dans votre propre application.

Alors que cela peut sembler trop complexe, si vous utilisez le composant
CLI projet de long métrage d'installation, la plupart de ce code peut
être écrit et installé pour vous. Vous avez juste à définir le nom du
projet et les paramètres dans le fichier de configuration de
l'installation. Voir le composant de projet doc fichier pour obtenir un
exemple d'un projet de fichier de configuration installé.

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
