Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

è¯¥é¡¹ç›®çš„ç»„ä»¶åŒ…å?«çš„é¡¹ç›®ç±»ä¸­ï¼Œä½
å?¯ä»¥æ‰©å±•å’Œå°?è£…æ‚¨çš„åº”ç”¨ç¨‹åº?çš„è§„èŒƒï¼Œå¦‚è·¯ç”±å™¨ï¼ŒæŽ§åˆ¶å™¨ï¼Œæ•°æ?®åº“å’Œæ¨¡å?—ã€‚å?Žï¼Œæ­£ç¡®è®¾ç½®ï¼Œè¯¥é¡¹ç›®å?¯ä»¥åœ¨â€œè¿?è¡Œâ€?å’Œç”¨æˆ·çš„è¦?æ±‚ï¼Œæˆ?åŠŸåœ°è·¯ç”±åˆ°æ­£ç¡®çš„åŒºåŸŸï¼Œæ‚¨çš„åº”ç”¨ç¨‹åº?ã€‚æŸ¥çœ‹MVCç»„ä»¶docæ–‡ä»¶çš„æ‰©å±•é¡¹ç›®çš„ç±»æ–‡ä»¶ä¸­çœ‹åˆ°çš„ä¸€ä¸ªä¾‹å­?ã€‚

æ­¤å¤–ï¼Œè¯¥é¡¹ç›®éƒ¨åˆ†åŒ…å?«å®‰è£…ç±»çš„CLIç»„ä»¶ç”¨æ?¥æž„å»ºå’Œå®‰è£…å·¥ç¨‹è„šæ‰‹æž¶ã€‚ä¸€ä¸ªé¡¹ç›®å®‰è£…é…?ç½®æ–‡ä»¶çš„ä¸€ä¸ªç¤ºä¾‹æ˜¯å¦‚ä¸‹ã€‚

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
