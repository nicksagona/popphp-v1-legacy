Pop PHP Framework
=================

Documentation : Config
----------------------

O componente de configuração fornece um objeto valor de dados que é utilizado por outros componentes, tais como o componente do projecto. Normalmente, coisas como credenciais de banco de dados são definidos em um objeto de configuração e passado para um objeto de projeto a ser usado durante o ciclo de vida do projeto ou script.


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
