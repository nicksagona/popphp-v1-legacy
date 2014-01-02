Pop PHP Framework
=================

Documentation : Config
----------------------

Home

configコンポーネントは、プロジェクト·コンポーネントなどの他のコンポーネントによって利用されているデータ値オブジェクトを提供します。通常、データベースの資格のようなものは、configオブジェクトで定義されたプロジェクトやスクリプトのライフサイクル中に使用するプロジェクトオブジェクトに渡されます。

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
