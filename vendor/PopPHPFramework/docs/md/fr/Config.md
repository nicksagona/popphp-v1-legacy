Pop PHP Framework
=================

Documentation : Config
----------------------

Le composant de configuration fournit un objet de valeur des données qui est utilisée par d'autres composants tels que la composante du projet. En règle générale, des choses comme les informations d'identification de base de données sont définies dans un objet de configuration et transmis à un objet du projet qui sera utilisé pendant le cycle de vie du projet ou d'un script.

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
