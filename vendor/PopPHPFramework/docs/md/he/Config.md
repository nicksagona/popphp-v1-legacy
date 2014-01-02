Pop PHP Framework
=================

Documentation : Config
----------------------

Home

מרכיב התצורה מספק אובייקט ערך נתונים שהוא מנוצל על ידי רכיבים אחרים כגון
רכיב הפרויקט. בדרך כלל, דברים כמו אישורי מסד נתונים מוגדרים באובייקט
config ועברו לאובייקט פרויקט לשמש במהלך מחזור החיים של פרויקט או התסריט.

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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
