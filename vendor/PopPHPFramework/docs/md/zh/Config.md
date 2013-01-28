Pop PHP Framework
=================

Documentation : Config
----------------------

Home

é…?ç½®ç»„ä»¶æ??ä¾›çš„æ•°æ?®å€¼å¯¹è±¡ï¼Œè¯¥å¯¹è±¡ä½¿ç”¨çš„å…¶ä»–ç»„ä»¶ï¼Œå¦‚é¡¹ç›®çš„ç»„æˆ?éƒ¨åˆ†ã€‚é€šå¸¸æƒ…å†µä¸‹ï¼Œåœ¨é…?ç½®å¯¹è±¡å®šä¹‰çš„æ•°æ?®åº“å‡­æ?®ä¹‹ç±»çš„ä¸œè¥¿ï¼Œå¹¶é€šè¿‡é¡¹ç›®å¯¹è±¡åœ¨å…¶ç”Ÿå‘½å‘¨æœŸçš„é¡¹ç›®æˆ–è„šæœ¬ã€‚

    use Pop\Config;

    $cfg = array(
        'db' => array(
            'name' => 'testdb',
            'host' => 'localhost',
            'user' => array(
                'username' => 'testuser',
                'password' => '12test34',
                'role'     => 'editor'
            )
        ),
        'module' => 'TestModule'
    );

    $config = new Config($cfg);

    echo 'DB Name: ' . $config->db->name;
    echo 'User: ' . $config->db->user->username . ' has the role: ' . $config->db->user->role;
    echo 'Module Name: ' . $config->module;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
