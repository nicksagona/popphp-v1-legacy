<?php

require_once '../../bootstrap.php';

use Pop\Auth\Auth,
    Pop\Auth\Role,
    Pop\Auth\Adapter\AuthFile,
    Pop\Web\Session;

try {
    // Start the session
    $sess = Session::getInstance();

    // If auth object exists in session, validate it.
    if (isset($sess->auth)) {
        $sess->auth->setRequiredRole('admin')
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
    // Else, login
    } else {
        echo 'No session found. Please log in.';
    }

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>