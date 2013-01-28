Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

Das MVC-Komponente, wie in der Dokumentation Ãœberblick skizziert, ist
eine Implementierung des MVC Design Pattern, mit der zusÃ¤tzlichen
Schicht aus einem Router fÃ¼r mehrere Benutzer Pfade und Steuerungen
erleichtern. Einfach gesagt, der Controller die Delegation von
Anforderungen verarbeitet, Ã¼bernimmt das Modell der Business-Logik und
der Blick bestimmt, wie die Ausgabe fÃ¼r den Benutzer angezeigt. Alle
diese Klassen innerhalb dieser Komponente sind sehr einfach zu nutzen,
sie in Ihre eigene Anwendung erweitern.

WÃ¤hrend dies aussehen kann Ã¼bermÃ¤ÃŸig komplex, wenn Sie die CLI
Teilprojekt Installation Funktion nutzen zu kÃ¶nnen, kÃ¶nnen die meisten
dieser Code geschrieben und fÃ¼r Sie installiert werden. Sie mÃ¼ssen nur
den Namen des Projekts und Einstellungen in der Installation
Konfigurationsdatei definieren. Sehen Sie sich die Projekt-Komponente
doc-Datei, um ein Beispiel eines Projekts zu installieren
Konfigurationsdatei zu bekommen.

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
