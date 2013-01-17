Pop PHP Framework
=================

Documentation : Config
----------------------

Die Config-Komponente stellt einen Datenwert-Objekt, das durch andere Komponenten wie die Projekt-Komponente verwendet wird. Typischerweise werden Dinge wie Datenbank-Anmeldeinformationen in einer Config Objekt definiert und an einem Projekt zum Objekt während des gesamten Lebenszyklus des Projekts oder Skript verwendet werden.

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
