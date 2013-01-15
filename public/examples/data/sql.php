<?php

require_once '../../bootstrap.php';

use Pop\Data\Type\Sql;

try {
    $users = Sql::decode(file_get_contents('../assets/files/test.sql'));
    print_r($users);

    echo '<br />' . PHP_EOL;

    $sqlStr = Sql::encode($users, 'users');
    echo $sqlStr;
} catch (\Exception $e) {
    echo $e->getMessage();
}

