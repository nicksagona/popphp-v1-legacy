Pop PHP Framework
=================

Documentation : Mvc
-------------------

Η συνιστώσα MVC, όπως περιγράφεται στην επισκόπηση τεκμηρίωση, είναι μια υλοποίηση του προτύπου σχεδιασμού MVC, με το πρόσθετο στρώμα του δρομολογητή για να διευκολυνθούν οι πολλαπλές διαδρομές των χρηστών και των ελεγκτών. Με απλά λόγια, ο ελεγκτής χειρίζεται την αντιπροσωπεία των αιτήσεων, το μοντέλο χειρίζεται την επιχειρηματική λογική και η θέα καθορίζει τον τρόπο εμφάνισης της εξόδου για τον χρήστη. Όλες αυτές οι κατηγορίες στο πλαίσιο αυτής της συνιστώσας είναι πολύ εύκολο να επεκτείνουν την επιρροή τους στην δική σας εφαρμογή.

Ενώ αυτό μπορεί να φαίνονται υπερβολικά περίπλοκη, εάν χρησιμοποιείτε το στοιχείο CLI χαρακτηριστικό του έργου εγκατάστασης, το μεγαλύτερο μέρος αυτού του κώδικα μπορεί να γραφτεί και να εγκατασταθεί για εσάς. Απλά πρέπει να καθορίσει το όνομα του έργου και τις ρυθμίσεις στο αρχείο ρυθμίσεων εγκατάστασης. Δείτε το στοιχείο doc αρχείο έργου για να πάρετε ένα παράδειγμα ενός έργου εγκατάστασης του αρχείου ρυθμίσεων.

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
