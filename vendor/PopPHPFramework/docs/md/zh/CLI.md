Pop PHP Framework
=================

Documentation : CLI
-------------------

Home

命令行界面（CLI）组件是一个非常有用的组件，它允许你执行一些有用的任务，例如：

-   评估当前的环境下，所需的依赖关系
-   从项目的安装文件安装项目
-   设置应用程序的默认语言
-   创建一个类图
-   对可用的最新版本，检查当前版本

<!-- -->

    script/pop --check                     // Check the current configuration for required dependencies
    script/pop --help                      // Display this help
    script/pop --install file.php          // Install a project based on the install file specified
    script/pop --lang fr                   // Set the default language for the project
    script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
    script/pop --show                      // Show project install instructions
    script/pop --version                   // Display version of Pop PHP Framework and latest available

下面是一个示例项目的安装文件：

    return new Pop\Config(array(
        'project' => array(
            'name'    => 'HelloWorld',
            'base'    => __DIR__ . '/../../',
            'docroot' => __DIR__ . '/../../public'
        ),
        'databases' => array(
            'helloworld' => array(
                'type'     => 'Sqlite',
                'database' => '.hthelloworld.sqlite',
                'prefix'   => 'pop_',
                'default'  => true
            )
        ),
        'forms' => array(
            'login' => array(
                'fields' => array(
                    array(
                        'type'       => 'text',
                        'name'       => 'username',
                        'label'      => 'Username:',
                        'required'   => true,
                        'attributes' => array('size', 40),
                        'validators' => 'AlphaNumeric()'
                    ),
                    array(
                        'type'       => 'password',
                        'name'       => 'password',
                        'label'      => 'Password:',
                        'required'   => true,
                        'attributes' => array('size', 40),
                        'validators' => array('NotEmpty()', 'LengthGt(6)')
                    ),
                    array(
                        'type'       => 'submit',
                        'name'       => 'submit',
                        'value'      => 'LOGIN'
                    )
                )
            )
        ),
        'controllers' => array(
            '/' => array(
                'index'   => 'index.phtml',
                'about'   => 'about.phtml',
                'contact' => 'contact.phtml',
                'error'   => 'error.phtml'
            )
        ),
        'models' => array(
            'User'
        )
    ));

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
