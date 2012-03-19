Pop PHP Framework
=================

Documentation : Config
----------------------

Il componente configurazione fornisce un oggetto valore di dati che è utilizzato da altri componenti, quali il componente progetto. In genere, le cose come le credenziali del database sono definiti in un oggetto di configurazione e passò a un oggetto del progetto da utilizzare durante il ciclo di vita del progetto o script.


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
