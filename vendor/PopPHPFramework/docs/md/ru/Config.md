Pop PHP Framework
=================

Documentation : Config
----------------------

Home

Config ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚ Ð´Ð°Ð½Ð½Ñ‹Ðµ
Ð¾Ð±ÑŠÐµÐºÑ‚Ð° Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ðµ, ÐºÐ¾Ñ‚Ð¾Ñ€Ð¾Ðµ Ð¸Ñ?Ð¿Ð¾Ð»ÑŒÐ·ÑƒÐµÑ‚Ñ?Ñ?
Ð´Ñ€ÑƒÐ³Ð¸Ð¼Ð¸ ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð°Ð¼Ð¸, Ñ‚Ð°ÐºÐ¸Ð¼Ð¸ ÐºÐ°Ðº
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð° Ð¿Ñ€Ð¾ÐµÐºÑ‚Ð°. ÐšÐ°Ðº Ð¿Ñ€Ð°Ð²Ð¸Ð»Ð¾, Ñ‚Ð°ÐºÐ¸Ðµ
Ð²ÐµÑ‰Ð¸, ÐºÐ°Ðº ÑƒÑ‡ÐµÑ‚Ð½Ñ‹Ðµ Ð´Ð°Ð½Ð½Ñ‹Ðµ Ð±Ð°Ð·Ñ‹ Ð´Ð°Ð½Ð½Ñ‹Ñ…
Ð¾Ð¿Ñ€ÐµÐ´ÐµÐ»ÐµÐ½Ñ‹ Ð² ÐºÐ¾Ð½Ñ„Ð¸Ð³ÑƒÑ€Ð°Ñ†Ð¸Ð¸ Ð¾Ð±ÑŠÐµÐºÑ‚Ð° Ð¸
Ð¿ÐµÑ€ÐµÐ´Ð°Ð» Ð¿Ñ€Ð¾ÐµÐºÑ‚ Ð¾Ð±ÑŠÐµÐºÑ‚Ð°, ÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ð¹ Ð±ÑƒÐ´ÐµÑ‚
Ð¸Ñ?Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ñ‚ÑŒÑ?Ñ? Ð² Ñ‚ÐµÑ‡ÐµÐ½Ð¸Ðµ Ð²Ñ?ÐµÐ³Ð¾
Ð¶Ð¸Ð·Ð½ÐµÐ½Ð½Ð¾Ð³Ð¾ Ñ†Ð¸ÐºÐ»Ð° Ð¿Ñ€Ð¾ÐµÐºÑ‚Ð° Ð¸Ð»Ð¸ Ñ?Ñ†ÐµÐ½Ð°Ñ€Ð¸Ñ?.

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
