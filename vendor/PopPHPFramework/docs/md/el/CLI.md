Pop PHP Framework
=================

Documentation : CLI
-------------------

Home

Î— Î´Î¹Î±ÏƒÏ?Î½Î´ÎµÏƒÎ· Î³Ï?Î±Î¼Î¼Î®Ï‚ ÎµÎ½Ï„Î¿Î»ÏŽÎ½ (CLI)
ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Ï€Î¿Î»Ï? Ï‡Ï?Î®ÏƒÎ¹Î¼Î¿
ÎµÎ¾Î¬Ï?Ï„Î·Î¼Î± Ï€Î¿Ï… ÏƒÎ±Ï‚ ÎµÏ€Î¹Ï„Ï?Î­Ï€ÎµÎ¹ Î½Î±
ÎµÎºÏ„ÎµÎ»Î­ÏƒÎµÏ„Îµ Î¼ÎµÏ?Î¹ÎºÎ­Ï‚ Ï‡Ï?Î®ÏƒÎ¹Î¼ÎµÏ‚
Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¯ÎµÏ‚, ÏŒÏ€Ï‰Ï‚:

-   Î±Î¾Î¹Î¿Î»Î¿Î³Î®ÏƒÎµÎ¹ Ï„Î¿ ÏƒÎ·Î¼ÎµÏ?Î¹Î½ÏŒ Ï€ÎµÏ?Î¹Î²Î¬Î»Î»Î¿Î½
    Î³Î¹Î± Ï„Î¹Ï‚ Î±Ï€Î±Î¹Ï„Î¿Ï?Î¼ÎµÎ½ÎµÏ‚ ÎµÎ¾Î±Ï?Ï„Î®ÏƒÎµÎ¹Ï‚
-   ÎµÎ³ÎºÎ±Ï„Î±ÏƒÏ„Î®ÏƒÎµÏ„Îµ Î­Î½Î± Ï€Ï?ÏŒÎ³Ï?Î±Î¼Î¼Î± Î±Ï€ÏŒ Î­Î½Î±
    Î±Ï?Ï‡ÎµÎ¯Î¿ ÎµÎ³ÎºÎ±Ï„Î¬ÏƒÏ„Î±ÏƒÎ·Ï‚ Ï„Î¿Ï… Î­Ï?Î³Î¿Ï…
-   Î¿Ï?Î¯ÏƒÎµÏ„Îµ Ï„Î·Î½ Ï€Ï?Î¿ÎµÏ€Î¹Î»ÎµÎ³Î¼Î­Î½Î· Î³Î»ÏŽÏƒÏƒÎ± Ï„Î·Ï‚
    Î±Î¯Ï„Î·ÏƒÎ·Ï‚
-   Î´Î·Î¼Î¹Î¿Ï…Ï?Î³Î®ÏƒÎµÏ„Îµ Î­Î½Î± Ï‡Î¬Ï?Ï„Î· Ï„Î¬Î¾Î·
-   ÎµÎ»Î­Î³Î¾ÎµÏ„Îµ Ï„Î·Î½ Ï„Ï?Î­Ï‡Î¿Ï…ÏƒÎ± Î­ÎºÎ´Î¿ÏƒÎ· ÎºÎ±Ï„Î¬
    Ï„Î·Î½ Ï„ÎµÎ»ÎµÏ…Ï„Î±Î¯Î± Î´Î¹Î±Î¸Î­ÏƒÎ¹Î¼Î· Î­ÎºÎ´Î¿ÏƒÎ·

<!-- -->

    script/pop --check                     // Check the current configuration for required dependencies
    script/pop --help                      // Display this help
    script/pop --install file.php          // Install a project based on the install file specified
    script/pop --lang fr                   // Set the default language for the project
    script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
    script/pop --show                      // Show project install instructions
    script/pop --version                   // Display version of Pop PHP Framework and latest available

Î•Î´ÏŽ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Ï€Î±Ï?Î¬Î´ÎµÎ¹Î³Î¼Î± Ï„Î¿Ï… Î­Ï?Î³Î¿Ï…
Î±Ï?Ï‡ÎµÎ¯Î¿ ÎµÎ³ÎºÎ±Ï„Î¬ÏƒÏ„Î±ÏƒÎ·Ï‚:

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
