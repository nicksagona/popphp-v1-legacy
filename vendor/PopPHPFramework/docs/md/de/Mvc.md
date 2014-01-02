Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

Das MVC-Komponente, wie in der Dokumentation Überblick skizziert, ist
eine Implementierung des MVC Design Pattern, mit der zusätzlichen
Schicht aus einem Router für mehrere Benutzer Pfade und Steuerungen
erleichtern. Einfach gesagt, der Controller die Delegation von
Anforderungen verarbeitet, übernimmt das Modell der Business-Logik und
der Blick bestimmt, wie die Ausgabe für den Benutzer angezeigt. Alle
diese Klassen innerhalb dieser Komponente sind sehr einfach zu nutzen,
sie in Ihre eigene Anwendung erweitern.

Während dies aussehen kann übermäßig komplex, wenn Sie die CLI
Teilprojekt Installation Funktion nutzen zu können, können die meisten
dieser Code geschrieben und für Sie installiert werden. Sie müssen nur
den Namen des Projekts und Einstellungen in der Installation
Konfigurationsdatei definieren. Sehen Sie sich die Projekt-Komponente
doc-Datei, um ein Beispiel eines Projekts zu installieren
Konfigurationsdatei zu bekommen.

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
