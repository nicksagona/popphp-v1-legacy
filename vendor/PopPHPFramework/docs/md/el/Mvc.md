Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

Η συνιστώσα MVC, όπως περιγράφεται στην επισκόπηση τεκμηρίωση, είναι μια
υλοποίηση του προτύπου σχεδίασης MVC, με το επιπλέον στρώμα του
δρομολογητή για να διευκολυνθούν οι πολλαπλές διαδρομές των χρηστών και
των ελεγκτών. Με απλά λόγια, ο ελεγκτής χειρίζεται την αντιπροσωπεία των
αιτήσεων, το μοντέλο χειρίζεται την επιχειρηματική λογική και η θέα
καθορίζει τον τρόπο για να εμφανίσετε την έξοδο στο χρήστη. Όλα αυτά τα
μαθήματα σε αυτό το στοιχείο είναι πολύ εύκολο να επεκτείνουν τη
μόχλευση τους μέσα στην ίδια την αίτησή σας.

Ενώ αυτό μπορεί να φαίνεται υπερβολικά περίπλοκη, εάν χρησιμοποιείτε το
στοιχείο CLI χαρακτηριστικό του έργου εγκατάστασης, το μεγαλύτερο μέρος
αυτού του κώδικα μπορεί να γραφτεί και να εγκατασταθούν για σας. Απλά
πρέπει να καθορίσετε το όνομα του έργου και τις ρυθμίσεις στο αρχείο
ρυθμίσεων εγκατάστασης. Δείτε το συστατικό doc αρχείο έργου για να
πάρετε ένα παράδειγμα ενός έργου εγκατάστασης αρχείο ρυθμίσεων.

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
