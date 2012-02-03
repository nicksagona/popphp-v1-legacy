<?php

require_once '../../bootstrap.php';

use Pop\Db\Db,
    Pop\Record\Record;

/*
 * Placing a class here is highly unorthodox.
 * This is just for example purposes only.
 */
class Users extends Record { }

try {
    // Define DB credentials
    $db = Db::factory('Mysqli', array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    ));

    Users::setDb($db);

    $fields = array(
        'username' => 'newuser',
        'password' => '123456',
        'email'    => 'test@test.com',
        'access'   => 'admin'
    );

    $user = new Users($fields);
    $user->save();
    print_r($user);

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>