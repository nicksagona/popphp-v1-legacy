Pop PHP Framework
=================

Documentation : CLI
-------------------

Home

ÙˆØ§Ø¬Ù‡Ø© Ø³Ø·Ø± Ø§Ù„Ø£ÙˆØ§Ù…Ø± (CLI) Ø§Ù„Ø¹Ù†ØµØ± Ù‡Ùˆ Ø¹Ù†ØµØ±
Ù…Ù?ÙŠØ¯ Ø¬Ø¯Ø§ Ø§Ù„ØªÙŠ ØªØ³Ù…Ø­ Ù„Ùƒ ØªÙ†Ù?ÙŠØ° Ø¨Ø¹Ø¶ Ø§Ù„Ù…Ù‡Ø§Ù…
Ù…Ù?ÙŠØ¯Ø© Ù…Ø«Ù„:

-   ØªÙ‚ÙŠÙŠÙ… Ø§Ù„Ø¨ÙŠØ¦Ø© Ø§Ù„Ø­Ø§Ù„ÙŠØ© Ù„ØªØ¨Ø¹ÙŠØ§Øª
    Ø§Ù„Ù…Ø·Ù„ÙˆØ¨Ø©
-   ØªØ«Ø¨ÙŠØª Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ Ù…Ù† Ù…Ø´Ø±ÙˆØ¹ Ù…Ù„Ù? Ø§Ù„ØªØ«Ø¨ÙŠØª
-   ØªØ¹ÙŠÙŠÙ† Ø§Ù„Ù„ØºØ© Ø§Ù„Ø§Ù?ØªØ±Ø§Ø¶ÙŠØ© Ù„ØªØ·Ø¨ÙŠÙ‚
-   Ø¥Ù†Ø´Ø§Ø¡ Ù…Ø®Ø·Ø· Ù?Ø¦Ø©
-   ØªØ­Ù‚Ù‚ Ù…Ù† Ø§Ù„Ù†Ø³Ø®Ø© Ø§Ù„Ø­Ø§Ù„ÙŠØ© Ø¶Ø¯ Ø¢Ø®Ø± Ù†Ø³Ø®Ø©

<!-- -->

    script/pop --check                     // Check the current configuration for required dependencies
    script/pop --help                      // Display this help
    script/pop --install file.php          // Install a project based on the install file specified
    script/pop --lang fr                   // Set the default language for the project
    script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
    script/pop --show                      // Show project install instructions
    script/pop --version                   // Display version of Pop PHP Framework and latest available

ÙˆÙ‡Ù†Ø§ ØªØ«Ø¨ÙŠØª Ù…Ù„Ù? Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ Ø³Ø¨ÙŠÙ„ Ø§Ù„Ù…Ø«Ø§Ù„:

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
