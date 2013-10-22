<?php

require_once '../../bootstrap.php';

use Pop\Auth;

try {
    // Set the username and password
    $username = 'testuser1';
    $password = '12test34';

    // Create auth object
    $auth = new Auth\Auth(
        new Auth\Adapter\File('../assets/files/access-crypt.txt'),
        Auth\Auth::ENCRYPT_CRYPT
    );

    // Define some other auth parameters and authenticate the user
    $auth->setAttemptLimit(3)
         ->setAttempts(2)
         ->setAllowedIps('127.0.0.1')
         ->authenticate($username, $password);

    echo $auth->getResultMessage() . '<br /> ' . PHP_EOL;

    // Check if the auth attempt is valid
    if ($auth->isValid()) {
        // The user is valid so do top-secret stuff
    }
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
