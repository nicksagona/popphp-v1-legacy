Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

La composante Mvc, comme indiquÃ© dans la liste des documents, est une
implÃ©mentation du modÃ¨le de conception MVC, avec la couche
supplÃ©mentaire d'un routeur pour faciliter chemins multiples
utilisateurs et leurs contrÃ´leurs. Autrement dit, le contrÃ´leur gÃ¨re
la dÃ©lÃ©gation de la demande, le modÃ¨le gÃ¨re la logique mÃ©tier et la
vue dÃ©termine comment afficher la sortie Ã l'utilisateur. Toutes ces
classes au sein de cette composante sont trÃ¨s facile d'Ã©tendre les
exploiter dans votre propre application.

Alors que cela peut sembler trop complexe, si vous utilisez le composant
CLI projet de long mÃ©trage d'installation, la plupart de ce code peut
Ãªtre Ã©crit et installÃ© pour vous. Vous avez juste Ã dÃ©finir le nom
du projet et les paramÃ¨tres dans le fichier de configuration de
l'installation. Voir le composant de projet doc fichier pour obtenir un
exemple d'un projet de fichier de configuration installÃ©.

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
