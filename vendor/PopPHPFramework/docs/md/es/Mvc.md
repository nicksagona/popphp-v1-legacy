Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

El componente MVC, tal como se indica en el resumen de la
documentaciÃ³n, es una implementaciÃ³n del patrÃ³n de diseÃ±o MVC, con
la capa adicional de un router para facilitar mÃºltiples caminos de
usuario y controladores. En pocas palabras, el controlador se encarga de
la delegaciÃ³n de solicitudes, el modelo se encarga de la lÃ³gica de
negocio y la vista determina cÃ³mo mostrar el resultado al usuario.
Todas estas clases dentro de este componente es muy fÃ¡cil de extender a
aprovecharlas dentro de su propia aplicaciÃ³n.

Si bien esto puede parecer demasiado complejo, si se utiliza el
componente CLI proyecto de largometraje de la instalaciÃ³n, la mayor
parte de este cÃ³digo puede ser escrito e instalado por usted. SÃ³lo
tienes que definir el nombre del proyecto y la configuraciÃ³n del
archivo de configuraciÃ³n de instalaciÃ³n. Ver el componente del
Proyecto doc archivo para obtener un ejemplo de un proyecto de
instalaciÃ³n de archivo de configuraciÃ³n.

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
