<?php

require_once '../../bootstrap.php';

use Pop\Data\Sql,
    Pop\File\File;

try {
    $sql = new File('../assets/files/test.sql');
    $users = Sql::decode($sql->read());
    print_r($users);

    echo '<br />' . PHP_EOL;

    $sqlStr = Sql::encode($users, 'users');
    echo $sqlStr;
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>