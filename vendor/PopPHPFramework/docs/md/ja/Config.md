Pop PHP Framework
=================

Documentation : Config
----------------------

Home

configã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆÂ·ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?ªã?©ã?®ä»–ã?®ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?«ã‚ˆã?£ã?¦åˆ©ç”¨ã?•ã‚Œã?¦ã?„ã‚‹ãƒ‡ãƒ¼ã‚¿å€¤ã‚ªãƒ–ã‚¸ã‚§ã‚¯ãƒˆã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚é€šå¸¸ã€?ãƒ‡ãƒ¼ã‚¿ãƒ™ãƒ¼ã‚¹ã?®è³‡æ
¼ã?®ã‚ˆã?†ã?ªã‚‚ã?®ã?¯ã€?configã‚ªãƒ–ã‚¸ã‚§ã‚¯ãƒˆã?§å®šç¾©ã?•ã‚Œã?Ÿãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã‚„ã‚¹ã‚¯ãƒªãƒ—ãƒˆã?®ãƒ©ã‚¤ãƒ•ã‚µã‚¤ã‚¯ãƒ«ä¸­ã?«ä½¿ç”¨ã?™ã‚‹ãƒ—ãƒ­ã‚¸ã‚§ã‚¯ãƒˆã‚ªãƒ–ã‚¸ã‚§ã‚¯ãƒˆã?«æ¸¡ã?•ã‚Œã?¾ã?™ã€‚

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
