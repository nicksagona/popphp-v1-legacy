<?php

require_once '../../bootstrap.php';

use Pop\Auth;

try {
    $acl = Auth\Acl::factory(array(
        array('admin', 3),
        array('editor', 2),
        array('reader', 1)
    ));

    $user = $acl->getRole('editor');

    if ($acl->isAuthorized($user, 'admin')) {
        echo 'The user is authorized.' . PHP_EOL;
    } else {
        echo 'The user is NOT authorized.' . PHP_EOL;
    }
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
