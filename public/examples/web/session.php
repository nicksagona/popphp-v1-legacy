<?php

require_once '../../bootstrap.php';

use Pop\Web\Session;

try {
    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);
    $sess_id = $sess->getId();
    echo $sess_id . PHP_EOL . PHP_EOL;

    // Destroy a session and all its data
    //$sess->kill();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}

