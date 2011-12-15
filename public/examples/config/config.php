<?php

require_once '../../bootstrap.php';

use Pop\Config;

try {
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

    echo 'DB Name: ' . $config->db->name . PHP_EOL;
    echo 'User: ' . $config->db->user->username . ' has the role: ' . $config->db->user->role. PHP_EOL;
    echo 'Module Name: ' . $config->module;

    echo PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

?>