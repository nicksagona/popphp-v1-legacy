Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

La componente MVC, come indicato nella documentazione di panoramica, è
una implementazione del design pattern MVC, con l'ulteriore livello di
un router per facilitare i percorsi più utenti e controllori. In poche
parole, il controllore gestisce la delega delle richieste, il modello
gestisce la logica di business e la vista determina la modalità per
visualizzare l'output per l'utente. Tutte queste classi all'interno di
questa componente sono molto facili da estendere a sfruttare all'interno
della vostra applicazione.

Anche se questo può sembrare troppo complesso, se si utilizza la
funzione di componente CLI progetto di installazione, la maggior parte
di questo codice può essere scritto e installato per voi. Devi solo per
definire il nome del progetto e le impostazioni nel file di
configurazione di installazione. Visualizza la componente doc file di
progetto per ottenere un esempio di un progetto di installazione di file
di configurazione.

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
