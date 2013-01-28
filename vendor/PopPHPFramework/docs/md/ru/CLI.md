Pop PHP Framework
=================

Documentation : CLI
-------------------

Home

Ð˜Ð½Ñ‚ÐµÑ€Ñ„ÐµÐ¹Ñ? ÐºÐ¾Ð¼Ð°Ð½Ð´Ð½Ð¾Ð¹ Ñ?Ñ‚Ñ€Ð¾ÐºÐ¸ (CLI)
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð¾Ð¼ Ñ?Ð²Ð»Ñ?ÐµÑ‚Ñ?Ñ? Ð¾Ñ‡ÐµÐ½ÑŒ Ð¿Ð¾Ð»ÐµÐ·Ð½Ñ‹Ð¼
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð¾Ð¼, ÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ð¹ Ð¿Ð¾Ð·Ð²Ð¾Ð»Ñ?ÐµÑ‚
Ð²Ñ‹Ð¿Ð¾Ð»Ð½Ñ?Ñ‚ÑŒ Ð½ÐµÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ðµ Ð¿Ð¾Ð»ÐµÐ·Ð½Ñ‹Ðµ Ð·Ð°Ð´Ð°Ñ‡Ð¸,
Ñ‚Ð°ÐºÐ¸Ðµ ÐºÐ°Ðº:

-   Ð¾Ñ†ÐµÐ½Ð¸Ñ‚ÑŒ Ñ‚ÐµÐºÑƒÑ‰ÑƒÑŽ Ñ?Ñ€ÐµÐ´Ñƒ Ð´Ð»Ñ?
    Ð½ÐµÐ¾Ð±Ñ…Ð¾Ð´Ð¸Ð¼Ñ‹Ñ… Ð·Ð°Ð²Ð¸Ñ?Ð¸Ð¼Ð¾Ñ?Ñ‚ÐµÐ¹
-   Ð£Ñ?Ñ‚Ð°Ð½Ð¾Ð²ÐºÐ° Ð¿Ñ€Ð¾ÐµÐºÑ‚Ð° Ð¸Ð· ÑƒÑ?Ñ‚Ð°Ð½Ð¾Ð²Ð¾Ñ‡Ð½Ð¾Ð³Ð¾
    Ñ„Ð°Ð¹Ð»Ð° Ð¿Ñ€Ð¾ÐµÐºÑ‚Ð°
-   ÑƒÑ?Ñ‚Ð°Ð½Ð¾Ð²Ð¸Ñ‚ÑŒ Ñ?Ð·Ñ‹Ðº Ð¿Ð¾ ÑƒÐ¼Ð¾Ð»Ñ‡Ð°Ð½Ð¸ÑŽ
    Ð¿Ñ€Ð¸Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹
-   Ñ?Ð¾Ð·Ð´Ð°Ñ‚ÑŒ ÐºÐ»Ð°Ñ?Ñ? ÐºÐ°Ñ€Ñ‚Ðµ
-   Ð¿Ñ€Ð¾Ð²ÐµÑ€Ð¸Ñ‚ÑŒ Ñ‚ÐµÐºÑƒÑ‰ÑƒÑŽ Ð²ÐµÑ€Ñ?Ð¸ÑŽ Ñ? Ð¿Ð¾Ñ?Ð»ÐµÐ´Ð½ÐµÐ¹
    Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿Ð½Ð¾Ð¹ Ð²ÐµÑ€Ñ?Ð¸Ð¸

<!-- -->

    script/pop --check                     // Check the current configuration for required dependencies
    script/pop --help                      // Display this help
    script/pop --install file.php          // Install a project based on the install file specified
    script/pop --lang fr                   // Set the default language for the project
    script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
    script/pop --show                      // Show project install instructions
    script/pop --version                   // Display version of Pop PHP Framework and latest available

Ð’Ð¾Ñ‚ Ð¿Ñ€Ð¸Ð¼ÐµÑ€ ÑƒÑ?Ñ‚Ð°Ð½Ð¾Ð²ÐºÐ¸ Ñ„Ð°Ð¹Ð» Ð¿Ñ€Ð¾ÐµÐºÑ‚Ð°:

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
