Pop PHP Framework
=================

Documentation : Config
----------------------

عنصر التكوين يوفر كائن قيمة البيانات التي يتم استخدامها من قبل المكونات الأخرى مثل عنصر من عناصر المشروع. عادة، يتم تعريف الأشياء مثل أوراق اعتماد قاعدة البيانات في كائن التكوين ومرر إلى كائن مشروع ليتم استخدامها خلال دورة حياة المشروع أو البرنامج النصي.

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
