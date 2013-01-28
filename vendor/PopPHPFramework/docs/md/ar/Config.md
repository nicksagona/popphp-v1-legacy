Pop PHP Framework
=================

Documentation : Config
----------------------

Home

ÙŠÙˆÙ?Ø± Ø¹Ù†ØµØ± Ø§Ù„ØªÙƒÙˆÙŠÙ† ÙƒØ§Ø¦Ù† Ù‚ÙŠÙ…Ø© Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª
Ø§Ù„ØªÙŠ ÙŠØªÙ… Ø§Ø³ØªØ®Ø¯Ø§Ù…Ù‡Ø§ Ù…Ù† Ù‚Ø¨Ù„ Ø§Ù„Ù…ÙƒÙˆÙ†Ø§Øª
Ø§Ù„Ø£Ø®Ø±Ù‰ Ù…Ø«Ù„ Ù…ÙƒÙˆÙ†Ø§Øª Ø§Ù„Ù…Ø´Ø±ÙˆØ¹. Ø¹Ø§Ø¯Ø©ØŒ ÙŠØªÙ…
ØªØ¹Ø±ÙŠÙ? Ø£Ø´ÙŠØ§Ø¡ Ù…Ø«Ù„ Ø£ÙˆØ±Ø§Ù‚ Ø§Ø¹ØªÙ…Ø§Ø¯ Ù‚Ø§Ø¹Ø¯Ø©
Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ù?ÙŠ ÙƒØ§Ø¦Ù† Ø§Ù„ØªÙƒÙˆÙŠÙ† ÙˆØªÙ…Ø±ÙŠØ±Ù‡Ø§ Ø¥Ù„Ù‰
ÙƒØ§Ø¦Ù† Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ Ù„Ø§Ø³ØªØ®Ø¯Ø§Ù…Ù‡Ø§ Ø®Ù„Ø§Ù„ Ø¯ÙˆØ±Ø© Ø­ÙŠØ§Ø©
Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ Ø£Ùˆ Ø§Ù„Ø¨Ø±Ù†Ø§Ù…Ø¬ Ø§Ù„Ù†ØµÙŠ.

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
