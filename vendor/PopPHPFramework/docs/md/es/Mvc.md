Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

El componente MVC, tal como se indica en el resumen de la documentación,
es una implementación del patrón de diseño MVC, con la capa adicional de
un router para facilitar múltiples caminos de usuario y controladores.
En pocas palabras, el controlador se encarga de la delegación de
solicitudes, el modelo se encarga de la lógica de negocio y la vista
determina cómo mostrar el resultado al usuario. Todas estas clases
dentro de este componente es muy fácil de extender a aprovecharlas
dentro de su propia aplicación.

Si bien esto puede parecer demasiado complejo, si se utiliza el
componente CLI proyecto de largometraje de la instalación, la mayor
parte de este código puede ser escrito e instalado por usted. Sólo
tienes que definir el nombre del proyecto y la configuración del archivo
de configuración de instalación. Ver el componente del Proyecto doc
archivo para obtener un ejemplo de un proyecto de instalación de archivo
de configuración.

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
