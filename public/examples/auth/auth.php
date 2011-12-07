<?php

require_once '../../bootstrap.php';

use Pop\Auth\Auth,
    Pop\Auth\Adapter\AuthFile,
    Pop\Web\Session;

try {

    // Start a session to record login attempts
    $sess = Session::getInstance();
    //$sess->kill();

    // If the auth object already exists, access it
    if (isset($sess->auth)) {
        $sess->auth->authenticate('testuser1', '12test35');
    // Else, create a new auth object
    } else {
        $auth = new Auth(new AuthFile('../assets/files/access.txt'));
        $auth->setLoginAttempts(4)
             ->authenticate('testuser1', '12test35');

        $sess->auth = $auth;
    }

    echo $sess->auth->getResultMessage() . PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>