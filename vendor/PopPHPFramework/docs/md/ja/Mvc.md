Pop PHP Framework
=================

Documentation : Mvc
-------------------

としてのドキュメントの概要で説明されているのMVCコンポーネントは、複数のユーザーのパスとコントローラを容易にするためにルータの追加の層では、MVCデザインパターンの実装です。簡単に言えば、コントローラは要求の委任を処理し、モデルはビジネスロジックを処理し、ビューには、ユーザーに出力を表示する方法を決定します。このコンポーネント内のこれらのクラスはすべて、あなた自身のアプリケーション内で活用し、それらに拡張することは非常に簡単です。

あなたは、CLIコンポーネントプロジェクトのインストール機能を使用する場合、これは、過度に複雑に見えるかもしれませんが、このコードのほとんどはあなたのために書かれており、インストールすることができます。あなただけのプロジェクト名と、インストール設定ファイルの設定を定義する必要があります。プロジェクトのインストール設定ファイルの例を取得するためにプロジェクトのコンポーネントのdocファイルを表示します。

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
