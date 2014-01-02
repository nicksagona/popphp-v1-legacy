Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

מרכיב MVC, כפי שמתואר בסקירת התיעוד, הוא יישום של תבנית עיצוב MVC, עם
שכבה הנוספת של הנתב כדי להקל על משתמש מרובים נתיבים ובקרים. במילים
פשוטות, הבקר מטפל משלחת של בקשות, המודל מטפל בלוגיקה העסקית וההשקפה
קובעת כיצד להציג את הפלט למשתמש. כל השיעורים האלה בתוך רכיב זה הם קלים
מאוד להארכה כדי למנף אותם בתוך היישום שלך.

אמנם זה אולי נראה מורכב מדי, אם אתה משתמש בתכונת התקנת פרויקט מרכיב CLI,
רוב הקוד הזה יכול להיות כתוב ויותקן עבורך. אתה פשוט צריך להגדיר את שם
פרויקט והגדרות בקובץ תצורת ההתקנה. צפה בקובץ doc מרכיב פרויקט כדי לקבל
דוגמה של קובץ תצורת התקנת פרויקט.

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
