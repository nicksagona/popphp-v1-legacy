Pop PHP Framework
=================

Documentation : Config
----------------------

Home

Le composant de configuration fournit un objet de valeur de données qui
est utilisée par d'autres composants comme le volet projet. Typiquement,
des choses comme les informations d'identification de base de données
sont définis dans l'objet de configuration et transmis à un objet de
projet à utiliser durant le cycle de vie du projet ou d'un script.

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
