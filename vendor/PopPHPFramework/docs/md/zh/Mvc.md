Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

ä¸­åˆ—å‡ºçš„æ–‡æ¡£æ¦‚è¿°ï¼ŒMVCç»„ä»¶ï¼Œæ˜¯ä¸€ä¸ªå®žçŽ°äº†MVCçš„è®¾è®¡æ¨¡å¼?ï¼Œé™„åŠ
å±‚çš„è·¯ç”±å™¨ï¼Œä»¥æ–¹ä¾¿å¤šä¸ªç”¨æˆ·çš„è·¯å¾„å’ŒæŽ§åˆ¶å™¨ã€‚ç®€å?•åœ°è¯´ï¼ŒæŽ§åˆ¶å™¨å¤„ç?†è¯·æ±‚çš„ä»£è¡¨å›¢ï¼Œè¯¥æ¨¡åž‹å¤„ç?†ä¸šåŠ¡é€»è¾‘ï¼Œå¹¶å†³å®šå¦‚ä½•æ˜¾ç¤ºè¾“å‡ºåˆ°ç”¨æˆ·çš„è§‚ç‚¹ã€‚è¿™ä¸ªç»„ä»¶å†…çš„æ‰€æœ‰è¿™äº›ç±»æ˜¯å¾ˆå®¹æ˜“çš„æ‰©å±•åˆ°åˆ©ç”¨ä»–ä»¬åœ¨è‡ªå·±çš„åº”ç”¨ç¨‹åº?ã€‚

è™½ç„¶è¿™å?¯èƒ½çœ‹èµ·æ?¥è¿‡äºŽå¤?æ?‚ï¼Œå¦‚æžœæ‚¨ä½¿ç”¨CLIå®‰è£…ç»„ä»¶é¡¹ç›®åŠŸèƒ½ï¼Œå¤§éƒ¨åˆ†ä»£ç
?å?¯ä»¥ä¹¦é?¢å’Œä¸ºæ‚¨å®‰è£…ã€‚ä½
å?ªéœ€è¦?å®šä¹‰çš„é¡¹ç›®å??ç§°ï¼Œå¹¶åœ¨å®‰è£…é…?ç½®æ–‡ä»¶çš„è®¾ç½®ã€‚æŸ¥çœ‹é¡¹ç›®çš„ç»„æˆ?éƒ¨åˆ†DOCæ–‡ä»¶ï¼Œä»¥èŽ·å¾—ä¸€ä¸ªé¡¹ç›®çš„å®‰è£…é…?ç½®æ–‡ä»¶çš„ä¸€ä¸ªä¾‹å­?ã€‚

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
