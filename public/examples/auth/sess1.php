<?php

require_once '../../bootstrap.php';

use Pop\Auth,
    Pop\Web\Session;

try {
    // Start the session
    $sess = Session::getInstance();

    // If auth object exists in session, validate it.
    if (isset($sess->auth)) {
        $sess->auth->setRequiredRole('reader')
             ->validate();

        if ($sess->auth->isValid()) {
            echo 'The session is still valid.' . PHP_EOL . PHP_EOL;
            if ($sess->auth->isAuthorized()) {
                echo 'The user "' . $sess->auth->getUser()->getUsername() .
                     '" is authorized as a "' .  $sess->auth->getUser()->getRole()->getName() . '".';
            } else {
                echo 'The user "' . $sess->auth->getUser()->getUsername() .
                     '" is NOT authorized. The user is a "' .  $sess->auth->getUser()->getRole()->getName() .
                     '" and needs to be a "' . $sess->auth->getRequiredRole()->getName() . '".';
            }
        } else {
            echo $sess->auth->getResultMessage();
        }
    // Else authenticate the session
    } else {
        // Set the username and password
        $username = 'testuser3';
        $password = '90test12';

        // Create auth object
        $auth = new Auth\Auth(new Auth\Adapter\File('../assets/files/access_sha1.txt'), Auth\Auth::ENCRYPT_SHA1);

        // Add some roles
        $auth->addRoles(array(
            Auth\Role::factory('admin', 3),
            Auth\Role::factory('editor', 2),
            Auth\Role::factory('reader', 1)
        ));

        // Define some other auth parameters and authenticate the user
        $auth->setRequiredRole('reader')
             ->setExpiration(1) // Set session expiration to 1 minute for testing purposes
             ->setAttemptLimit(3)
             ->setAllowedIps('127.0.1.1')
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

        $sess->auth = $auth;
    }

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
