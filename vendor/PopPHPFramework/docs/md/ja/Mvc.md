Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

としてドキュメント概要を説明してMVCコンポーネントは、複数のユーザー·パスおよびコントローラを容易にするためにルータの追加の層で、MVCデザインパターンの実装です。簡単に言えば、コントローラは要求の委任を処理し、モデルは、ビジネスロジックを処理し、ビューには、ユーザーが出力を表示する方法を決定します。このコンポーネント内のこれらのクラスはすべて、あなた自身のアプリケーション内でそれらを活用して拡張することが非常に簡単です。

あなたはCLIコンポーネントプロジェクトのインストール機能を使用する場合、これは、過度に複雑に見えるかもしれませんが、このコードのほとんどは、あなたのために書かれており、インストールすることができます。あなただけのプロジェクト名とインストール構成ファイルの設定を定義する必要があります。プロジェクトインストール構成ファイルの例を取得するプロジェクトコンポーネントdocファイルを表示します。

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
