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
    $creds = array(
        'database' => 'poptest',
        'host'     => 'localhost',
        'username' => 'popuser',
        'password' => '12pop34'
    );

    Users::setDb(Db::factory('Mysqli', $creds));
    $users = Users::findAll();
    print_r($users->rows);
    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>