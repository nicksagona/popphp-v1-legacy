<?php

require_once '../../bootstrap.php';

use Pop\Config;

try {
    $cfg1 = array(
        'db' => array(
            'name' => 'testdb',
            'host' => 'localhost',
            'user' => array(
                'username' => 'testuser',
                'password' => '12test34',
                'role'     => 'editor'
            )
        ),
        'nav' => array(
            'some' => 'nav'
        ),
        'module' => 'TestModule',
        'oldvalue' => 123456
    );

    $cfg2 = array(
        'db' => array(
            'name' => 'testdb123',
            'host' => 'localhost',
            'user' => array(
                'username' => 'testuser2',
                'password' => '45test67',
                'role'     => 'editor'
            )
        ),
        'nav' => array(
            'some' => 'nav12'
        ),
        'module' => 'TestModule',
        'newvalue' => array(
            'Some new value'
        )
    );

    $config1 = new Config($cfg1);
    $config2 = new Config($cfg2);
    $config1->merge($config2);

    print_r($config1);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

