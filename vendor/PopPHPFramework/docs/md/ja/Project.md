Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã?®ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã‚’ä½¿ç”¨ã?™ã‚‹ã?¨ã€?ãƒ«ãƒ¼ã‚¿ã?ªã?©ã€?ã‚³ãƒ³ãƒˆãƒ­ãƒ¼ãƒ©ã€?ãƒ‡ãƒ¼ã‚¿ãƒ™ãƒ¼ã‚¹ã?Šã‚ˆã?³ãƒ¢ã‚¸ãƒ¥ãƒ¼ãƒ«ã?ªã?©ã?®ã‚¢ãƒ—ãƒªã‚±ãƒ¼ã‚·ãƒ§ãƒ³ã?®ä»•æ§˜ã‚’æ‹¡å¼µã?—ã€?ã‚«ãƒ—ã‚»ãƒ«åŒ–ã?™ã‚‹ã?“ã?¨ã?Œã?§ã??ã‚‹ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã‚¯ãƒ©ã‚¹ã?Œå?«ã?¾ã‚Œã?¦ã?„ã?¾ã?™ã€‚ä¸€æ—¦ã€?é?©åˆ‡ã?«è¨­å®šã?•ã‚Œã€?ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã?Œ
"å®Ÿè¡Œ"ã?™ã‚‹ã?“ã?¨ã?Œã?§ã??ã€?æ­£å¸¸ã?«ã‚¢ãƒ—ãƒªã‚±ãƒ¼ã‚·ãƒ§ãƒ³ã?®æ­£ã?—ã?„é
˜åŸŸã?«ãƒ¦ãƒ¼ã‚¶ãƒ¼ã?®è¦?æ±‚ã‚’ãƒ«ãƒ¼ãƒ†ã‚£ãƒ³ã‚°ã?—ã?¾ã?™ã€‚æ‹¡å¼µã?•ã‚Œã?Ÿãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆÂ·ã‚¯ãƒ©ã‚¹Â·ãƒ•ã‚¡ã‚¤ãƒ«ã?®ä¾‹ã‚’å?‚ç…§ã?™ã‚‹ã?«ã?¯ã€?MVCã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆdocãƒ•ã‚¡ã‚¤ãƒ«ã‚’è¡¨ç¤ºã?—ã?¾ã?™ã€‚

ã?¾ã?Ÿã€?ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã?®ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?CLIã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã?®è¶³å
´ã‚’æ§‹ç¯‰ã?—ã?¦ã‚¤ãƒ³ã‚¹ãƒˆãƒ¼ãƒ«ã?™ã‚‹ã?Ÿã‚?ã?«ä½¿ç”¨ã?™ã‚‹ã‚¤ãƒ³ã‚¹ãƒˆãƒ¼ãƒ«ã‚¯ãƒ©ã‚¹ã?Œå?«ã?¾ã‚Œã?¦ã?„ã?¾ã?™ã€‚ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã?®ã‚¤ãƒ³ã‚¹ãƒˆãƒ¼ãƒ«ã€?ã‚³ãƒ³ãƒ•ã‚£ã‚®ãƒ¥ãƒ¬ãƒ¼ã‚·ãƒ§ãƒ³Â·ãƒ•ã‚¡ã‚¤ãƒ«ã?®ä¾‹ã?¯ä»¥ä¸‹ã?®é€šã‚Šã?§ã?™ã€‚

    <?php
    return new Pop\Config(array(
        'project' => array(
            'name'    => 'HelloWorld',
            'base'    => __DIR__ . '/../../',
            'docroot' => __DIR__ . '/../../public'
        ),
        'databases' => array(
            'helloworld' => array(
                'type'     => 'Mysqli',
                'database' => 'helloworld',
                'host'     => 'localhost',
                'username' => 'hello',
                'password' => '12world34',
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
                'index' => 'index.phtml',
                'error' => 'error.phtml'
            ),
            '/admin' => array(
                'index' => 'index.phtml',
                'error' => 'error.phtml'
            )
        )
    ));

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
