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
    $users = Users::findAll('id ASC', array('username' => '%test%'), '3, 4');
    print_r($users->rows);

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
