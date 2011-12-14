<?php

require_once '../../bootstrap.php';

use Pop\Db\Db,
    HelloWorld\Table\Users;

try {
    // Set DB object for the record object to use,
    // assumed inherited from the 'project.config.php'
    // in the 'bootstrap.php' file
    Users::setDb($db['poptest']);

    // Get the users
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