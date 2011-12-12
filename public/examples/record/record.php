<?php

require_once '../../bootstrap.php';

use Pop\Db\Db,
    HelloWorld\Table\Users;

try {
    // Define DB credentials
    $creds = array(
                 'database' => 'poptest',
                 'host'     => 'localhost',
                 'username' => 'popuser',
                 'password' => '12pop34'
             );

    // Set DB object for the record object
    Users::setDb(Db::factory('Mysql', $creds));

    // Get the users and
    $users = Users::findAll('id ASC');

    // Output the results
    foreach ($users->rows as $user) {
        echo 'ID: ' . $user->id . PHP_EOL;
        echo 'Username: ' . $user->username . PHP_EOL;
        echo 'Password: ' . $user->password . PHP_EOL;
        echo 'Email: ' . $user->email . PHP_EOL;
        echo 'Access: ' . $user->access . PHP_EOL . PHP_EOL;
    }
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>