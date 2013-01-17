Pop PHP Framework
=================

Documentation : Config
----------------------

Конфигурация компонент предоставляет данные объекта значения, используются другие компоненты, такие как проект компонента. Как правило, такие вещи, как база данных учетных данных, определенные в конфигурации объекта и передать объект проекта, который будет использоваться в течение всего жизненного цикла проекта или сценария.

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
