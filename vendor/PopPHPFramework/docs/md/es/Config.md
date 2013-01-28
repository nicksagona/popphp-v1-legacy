Pop PHP Framework
=================

Documentation : Config
----------------------

Home

El componente de configuraciÃ³n proporciona un objeto de valor de datos
que es utilizado por otros componentes tales como el componente del
proyecto. Por lo general, las cosas como las credenciales de la base de
datos se definen en un objeto de configuraciÃ³n y se pasa a un objeto de
proyecto que se utilizarÃ¡n durante el ciclo de vida del proyecto o
guiÃ³n.

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
