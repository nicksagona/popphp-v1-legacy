Pop PHP Framework
=================

Documentation : Mvc
-------------------

المكون MVC، على النحو المبين في وثائق عامة، هو تنفيذ نمط تصميم MVC، مع طبقة إضافية من جهاز توجيه لتسهيل مسارات متعددة وحدات تحكم المستخدم. ببساطة، وحدة تحكم يعالج وفد من الطلبات، ونموذج يتعامل مع منطق العمل والنظرة يحدد كيفية عرض الإخراج للمستخدم. كل من هذه الفئات ضمن هذا المكون من السهل جدا أن تمتد إلى الاستفادة منها في التطبيق الخاص.

في حين أن هذا قد تبدو معقدة للغاية، إذا كنت تستخدم المشروع مكون CLI ميزة التثبيت، يمكن كتابة أكثر من هذا الرمز وتثبيت لك. لديك فقط لتحديد اسم المشروع والإعدادات في ملف التكوين التثبيت. عرض ملف مشروع الوثيقة مكون للحصول على مثال لمشروع تثبيت ملف التكوين.

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
