Pop PHP Framework
=================

Documentation : Config
----------------------

Home

يوفر عنصر التكوين كائن قيمة البيانات التي يتم استخدامها من قبل المكونات
الأخرى مثل مكونات المشروع. عادة، يتم تعريف أشياء مثل أوراق اعتماد قاعدة
البيانات في كائن التكوين وتمريرها إلى كائن المشروع لاستخدامها خلال دورة
حياة المشروع أو البرنامج النصي.

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
