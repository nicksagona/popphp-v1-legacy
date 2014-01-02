Pop PHP Framework
=================

Documentation : Config
----------------------

Home

Config компонент предоставляет данные объекта значение, которое
используется другими компонентами, такими как компонента проекта. Как
правило, такие вещи, как учетные данные базы данных определены в
конфигурации объекта и передал проект объекта, который будет
использоваться в течение всего жизненного цикла проекта или сценария.

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
