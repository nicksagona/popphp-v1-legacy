Pop PHP Framework
=================

Documentation : Mvc
-------------------

La componente MVC, come indicato nella panoramica documentazione, è una implementazione del design pattern MVC, con lo strato supplementare di un router per facilitare i percorsi per utenti multipli e controllori. In poche parole, il regolatore gestisce la delega delle richieste, il modello gestisce la logica di business e la vista determina come per visualizzare l'output per l'utente. Tutte queste classi all'interno di questa componente sono molto facili da estendere a sfruttare all'interno della vostra applicazione.


Anche se questo può sembrare troppo complesso, se si utilizza la funzione di componente CLI progetto di installazione, la maggior parte di questo codice può essere scritto e installato per voi. Devi solo definire il nome del progetto e le impostazioni nel file di configurazione di installazione. Vista la componente file di progetto doc per ottenere un esempio di un progetto installare file di configurazione.


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
