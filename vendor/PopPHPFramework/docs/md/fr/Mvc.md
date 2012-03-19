Pop PHP Framework
=================

Documentation : Mvc
-------------------

La composante Mvc, comme indiqué dans la vue d'ensemble de la documentation, est une mise en œuvre du modèle de conception MVC, avec la couche supplémentaire d'un routeur afin de faciliter les chemins multi-utilisateurs et les contrôleurs. Autrement dit, le contrôleur gère la délégation de la demande, le modèle gère la logique métier et la vue détermine la façon d'afficher la sortie à l'utilisateur. Toutes ces classes au sein de cette composante sont très faciles à étendre à les exploiter dans votre propre application.


Bien que ceci peut sembler trop complexe, si vous utilisez le composant CLI projet de long métrage d'installation, la plupart de ce code peut être écrit et installé pour vous. Vous avez juste à définir le nom du projet et les paramètres dans le fichier de configuration d'installation. Voir le volet du projet doc fichier pour obtenir un exemple d'un projet de fichier de configuration d'installer.


<pre>
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

        if ($this->router()->controller()->getRequest()->getRequestUri() == '/') {
            $this->router()->controller()->dispatch();
        } else if (method_exists($this->router()->controller(), $this->router()->getAction())) {
            $this->router()->controller()->dispatch($this->router()->getAction());
        } else if (method_exists($this->router()->controller(), 'error')) {
            $this->router()->controller()->dispatch('error');
        }
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
        'default' => 'MyApp\\MyController'
    ))
);

// Run the project
$project->run();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
