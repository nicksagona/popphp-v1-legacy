<?php

require_once '../../bootstrap.php';

use Pop\Db\Db;
use Pop\Db\Sql;

try {
    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    );

    $db = Db::factory('Mysqli', $creds);

    // Create a non-prepared statement, escaping the value
    $sql = new Sql($db, 'users');
    $sql->select()->where()->greaterThanOrEqualTo('id', $db->adapter()->escape(5));
    $sql->select()->limit(4)->offset(1);

    echo $sql . '<br />' .  PHP_EOL;

    $db->adapter()->query($sql);

    while ($row = $db->adapter()->fetch()) {
        print_r($row);
    }


} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
