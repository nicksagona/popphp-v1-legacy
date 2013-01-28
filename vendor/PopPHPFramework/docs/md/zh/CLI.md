Pop PHP Framework
=================

Documentation : CLI
-------------------

Home

å‘½ä»¤è¡Œç•Œé?¢ï¼ˆCLIï¼‰ç»„ä»¶æ˜¯ä¸€ä¸ªé?žå¸¸æœ‰ç”¨çš„ç»„ä»¶ï¼Œå®ƒå…?è®¸ä½
æ‰§è¡Œä¸€äº›æœ‰ç”¨çš„ä»»åŠ¡ï¼Œä¾‹å¦‚ï¼š

-   è¯„ä¼°å½“å‰?çš„çŽ¯å¢ƒä¸‹ï¼Œæ‰€éœ€çš„ä¾?èµ–å…³ç³»
-   ä»Žé¡¹ç›®çš„å®‰è£…æ–‡ä»¶å®‰è£…é¡¹ç›®
-   è®¾ç½®åº”ç”¨ç¨‹åº?çš„é»˜è®¤è¯­è¨€
-   åˆ›å»ºä¸€ä¸ªç±»å›¾
-   å¯¹å?¯ç”¨çš„æœ€æ–°ç‰ˆæœ¬ï¼Œæ£€æŸ¥å½“å‰?ç‰ˆæœ¬

<!-- -->

    script/pop --check                     // Check the current configuration for required dependencies
    script/pop --help                      // Display this help
    script/pop --install file.php          // Install a project based on the install file specified
    script/pop --lang fr                   // Set the default language for the project
    script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
    script/pop --show                      // Show project install instructions
    script/pop --version                   // Display version of Pop PHP Framework and latest available

ä¸‹é?¢æ˜¯ä¸€ä¸ªç¤ºä¾‹é¡¹ç›®çš„å®‰è£…æ–‡ä»¶ï¼š

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
