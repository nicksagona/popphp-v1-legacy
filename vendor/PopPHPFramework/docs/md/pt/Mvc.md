Pop PHP Framework
=================

Documentation : Mvc
-------------------

Home

O componente MVC, como descrito na visÃ£o geral da documentaÃ§Ã£o, Ã©
uma implementaÃ§Ã£o do padrÃ£o de projeto MVC, com a camada adicional de
um roteador para facilitar caminhos mÃºltiplos usuÃ¡rios e
controladores. Simplificando, o controlador manipula a delegaÃ§Ã£o de
pedidos, o modelo lida com a lÃ³gica de negÃ³cio ea visÃ£o determina
como exibir a saÃ­da para o usuÃ¡rio. Todas essas classes dentro deste
componente sÃ£o muito fÃ¡cil de estender para aproveitÃ¡-los dentro de
sua prÃ³pria aplicaÃ§Ã£o.

Enquanto isto pode parecer muito complexo, se vocÃª usar o componente
CLI recurso de instalaÃ§Ã£o do projeto, a maior parte deste cÃ³digo pode
ser escrito e instalados para vocÃª. VocÃª apenas tem que definir o nome
do projeto e as configuraÃ§Ãµes no arquivo de configuraÃ§Ã£o de
instalaÃ§Ã£o. Ver o Projeto componente de arquivo doc para obter um
exemplo de um projeto de arquivo de instalaÃ§Ã£o de configuraÃ§Ã£o.

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
