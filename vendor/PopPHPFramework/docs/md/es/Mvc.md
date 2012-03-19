Pop PHP Framework
=================

Documentation : Mvc
-------------------

El componente de MVC, tal como se indica en el resumen de la documentación, es una implementación del patrón de diseño MVC, con la capa adicional de un router para facilitar varias rutas de acceso de usuario y los controladores. En pocas palabras, el controlador se encarga de la delegación de las solicitudes, el modelo se encarga de la lógica de negocio y el punto de vista determina cómo se muestran los resultados al usuario. Todas estas clases dentro de este componente son muy fáciles de extender a aprovecharlas dentro de su propia aplicación.

Si bien esto puede parecer demasiado complejo, si se utiliza el componente de la CLI proyecto de largometraje de la instalación, la mayor parte de este código se puede escribir e instalado por usted. Sólo tienes que definir el nombre del proyecto y la configuración en el fichero de configuración de instalación. Ver el componente del proyecto doc para obtener un ejemplo de un proyecto de instalar el archivo de configuración.

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
