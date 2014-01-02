Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

المكون MVC، على النحو المبين في وثائق نظرة عامة، هو تنفيذ لنمط التصميم
MVC، مع طبقة إضافية من جهاز توجيه لتسهيل مسارات متعددة وحدات تحكم
المستخدم. ببساطة، وحدة تحكم يعالج وفد طلبات، ونموذج يعالج منطق الأعمال
وطريقة العرض يحدد كيفية عرض الإخراج للمستخدم. جميع هذه الفئات داخل هذا
المكون من السهل جدا أن تمتد إلى الاستفادة منها في التطبيق الخاص بك.

في حين أن هذا قد تبدو معقدة للغاية، إذا كنت تستخدم المشروع مكون CLI ميزة
التثبيت، يمكن كتابة أكثر من هذا الرمز وتثبيت لك. لديك فقط لتحديد اسم
المشروع والإعدادات في ملف التكوين التثبيت. عرض ملف المشروع ثيقة المكون
للحصول على مثال لمشروع تثبيت ملف التكوين.

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
