<?php

require_once '../../bootstrap.php';

use Pop\Db;

/*
 * Placing a class here is highly unorthodox.
 * This is just for example purposes only.
 */
class Users extends Db\Record { }

try {
    // Define DB credentials
    $db = Db\Db::factory('Mysqli', array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    ));

    Users::setDb($db);

    $fields = array(
        'username'   => 'newuser2',
        'password'   => '123456',
        'email'      => 'new@test.com',
        'access'     => 'editor'
    );

    $user = new Users($fields);
    $user->save();
    print_r($user);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
