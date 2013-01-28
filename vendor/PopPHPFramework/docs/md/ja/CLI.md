Pop PHP Framework
=================

Documentation : CLI
-------------------

Home

ã‚³ãƒžãƒ³ãƒ‰ãƒ©ã‚¤ãƒ³ã‚¤ãƒ³ã‚¿ãƒ¼ãƒ•ã‚§ã‚¤ã‚¹ï¼ˆCLIï¼‰ã?®ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã‚’ä½¿ç”¨ã?™ã‚‹ã?ªã?©ã€?ã?„ã??ã?¤ã?‹ã?®æœ‰ç”¨ã?ªã‚¿ã‚¹ã‚¯ã‚’å®Ÿè¡Œã?™ã‚‹ã?“ã?¨ã?Œã?§ã??ã?¾ã?™é?žå¸¸ã?«ä¾¿åˆ©ã?ªã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?§ã?™ã€‚

-   å¿…è¦?ã?ªä¾?å­˜é–¢ä¿‚ã?®ã?Ÿã‚?ã€?ç?¾åœ¨ã?®ç’°å¢ƒã‚’è©•ä¾¡ã?™ã‚‹
-   ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã?®ã‚¤ãƒ³ã‚¹ãƒˆãƒ¼ãƒ«ãƒ•ã‚¡ã‚¤ãƒ«ã?‹ã‚‰ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã‚’ã‚¤ãƒ³ã‚¹ãƒˆãƒ¼ãƒ«ã?™ã‚‹
-   ã‚¢ãƒ—ãƒªã‚±ãƒ¼ã‚·ãƒ§ãƒ³ã?®ãƒ‡ãƒ•ã‚©ãƒ«ãƒˆã?®è¨€èªžã‚’è¨­å®šã?™ã‚‹
-   ã‚¯ãƒ©ã‚¹ãƒžãƒƒãƒ—ã‚’ä½œæˆ?
-   åˆ©ç”¨å?¯èƒ½ã?ªæœ€æ–°ã?®ãƒ?ãƒ¼ã‚¸ãƒ§ãƒ³ã?«å¯¾ã?—ã?¦ã€?ç?¾åœ¨ã?®ãƒ?ãƒ¼ã‚¸ãƒ§ãƒ³ã‚’ç¢ºèª?

<!-- -->

    script/pop --check                     // Check the current configuration for required dependencies
    script/pop --help                      // Display this help
    script/pop --install file.php          // Install a project based on the install file specified
    script/pop --lang fr                   // Set the default language for the project
    script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
    script/pop --show                      // Show project install instructions
    script/pop --version                   // Display version of Pop PHP Framework and latest available

ã?“ã?“ã?§ä¾‹ã?®ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã?®ã‚¤ãƒ³ã‚¹ãƒˆãƒ¼ãƒ«ãƒ•ã‚¡ã‚¤ãƒ«ã?¯æ¬¡ã?®ã?¨ã?Šã‚Šã?§ã?™ã€‚

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
