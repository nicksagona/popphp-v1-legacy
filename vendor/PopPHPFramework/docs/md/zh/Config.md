Pop PHP Framework
=================

Documentation : Config
----------------------

Home

配置组件提供的数据值对象，该对象使用的其他组件，如项目的组成部分。通常情况下，在配置对象定义的数据库凭据之类的东西，并通过项目对象在其生命周期的项目或脚本。

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
