<?php

require_once '../../bootstrap.php';

use Pop\Mvc\Model;

try {
    $data = array(
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

    $model = new Model($data);
    $model->blah = 123;
    $model->something = array(1, 2, 3);
    $model->something->set('onemore', 'Hello!');
    print_r($model);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>