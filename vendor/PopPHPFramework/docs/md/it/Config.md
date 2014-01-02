Pop PHP Framework
=================

Documentation : Config
----------------------

Home

Il componente Config fornisce un oggetto valore di dati che viene
utilizzato da altri componenti come il componente di progetto. In
genere, le cose come credenziali del database sono definiti in un
oggetto di configurazione e passato a un oggetto di progetto da
utilizzare durante il ciclo di vita del progetto o dello script.

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
