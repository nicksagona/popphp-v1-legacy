<?php

require_once '../../bootstrap.php';

use Pop\Auth\Role;

try {
    $reader = Role::factory('reader', 1)->addChild(
        Role::factory('editor', 2)->addChild(
            Role::factory('publisher', 3)->addChild(
                Role::factory('admin', 4)
            )
        )
    );

    print_r($reader);

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
