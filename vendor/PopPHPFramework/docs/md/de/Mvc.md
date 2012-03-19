Pop PHP Framework
=================

Documentation : Mvc
-------------------

Das MVC-Komponente, wie in der Dokumentation Überblick skizziert, ist eine Implementierung des MVC Design Pattern, mit der zusätzlichen Schicht aus einem Router, um mehrere Benutzer Pfade und Controllern zu erleichtern. Einfach gesagt, die Steuerung der Übertragung der Anforderungen verarbeitet, behandelt das Modell der Business-Logik und der Blick fest, wie die Ausgabe an den Benutzer anzuzeigen. Alle diese Klassen innerhalb dieser Komponente sind sehr einfach zu nutzen, um sie innerhalb der eigenen Anwendung zu erweitern.

Dies mag zwar aussehen zu komplex, wenn Sie die CLI-Teilprojekt Installation Funktion nutzen zu können, können die meisten dieser Code geschrieben und für Sie installiert werden. Sie müssen nur den Namen des Projekts und Einstellungen in der Konfigurationsdatei install definieren. Sehen Sie sich die Projekt-Komponente doc-Datei, um ein Beispiel für ein Projekt zu installieren Konfigurationsdatei zu bekommen.

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
