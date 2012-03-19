Pop PHP Framework
=================

Documentation : Config
----------------------

מרכיב Config מספק נתוני ערך האובייקט הוא מנוצל על ידי רכיבים אחרים, כגון רכיב Project. בדרך כלל, דברים כמו אישורי מסד נתונים מוגדרים אובייקט config והעביר לאובייקט הפרויקט לשמש במהלך מחזור החיים של הפרויקט או התסריט.

<pre>
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
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
