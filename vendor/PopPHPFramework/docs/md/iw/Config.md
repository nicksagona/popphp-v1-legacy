Pop PHP Framework
=================

Documentation : Config
----------------------

Home

×ž×¨×›×™×‘ ×”×ª×¦×•×¨×” ×ž×¡×¤×§ ×?×•×‘×™×™×§×˜ ×¢×¨×š × ×ª×•× ×™×?
×©×”×•×? ×ž× ×•×¦×œ ×¢×œ ×™×“×™ ×¨×›×™×‘×™×? ×?×—×¨×™×? ×›×’×•×Ÿ
×¨×›×™×‘ ×”×¤×¨×•×™×§×˜. ×‘×“×¨×š ×›×œ×œ, ×“×‘×¨×™×? ×›×ž×• ×?×™×©×•×¨×™
×ž×¡×“ × ×ª×•× ×™×? ×ž×•×’×“×¨×™×? ×‘×?×•×‘×™×™×§×˜ config ×•×¢×‘×¨×•
×œ×?×•×‘×™×™×§×˜ ×¤×¨×•×™×§×˜ ×œ×©×ž×© ×‘×ž×”×œ×š ×ž×—×–×•×¨ ×”×—×™×™×?
×©×œ ×¤×¨×•×™×§×˜ ×?×• ×”×ª×¡×¨×™×˜.

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
