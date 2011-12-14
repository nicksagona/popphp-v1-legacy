<?php

require_once '../../bootstrap.php';

use Pop\Auth\Auth,
    Pop\Auth\Role,
    Pop\Auth\Adapter\AuthFile;

try {
    // Set the username and password
    $username = 'testuser3';
    $password = '90test12';

    // Create auth object
    $auth = new Auth(new AuthFile('../assets/files/access_sha1.txt'), Auth::ENCRYPT_SHA1);

    // Add some roles
    $auth->addRoles(
               array(
                   Role::factory('admin', 3),
                   Role::factory('editor', 2),
                   Role::factory('reader', 1)
               )
           );

    // Define some other auth parameters and authenticate the user
    $auth->setRequiredRole('admin')
         ->setLoginAttempts(3)
         ->setAllowedIps('127.0.0.1')
         ->authenticate($username, $password);

    echo $auth->getResultMessage() . PHP_EOL;

    // Check if the user is authorized to be in this area
    if ($auth->isValid()) {
        if ($auth->isAuthorized()) {
            echo 'The user "' . $auth->getUser()->getUsername() .
                 '" is authorized as a "' .  $auth->getUser()->getRole()->getName() . '".';
        } else {
            echo 'The user "' . $auth->getUser()->getUsername() .
                 '" is NOT authorized. The user is a "' .  $auth->getUser()->getRole()->getName() .
                 '" and needs to be a "' . $auth->getRequiredRole()->getName() . '".';
        }
    }

    echo PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>