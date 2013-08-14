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

    // Create a prepared statement
    $sql = new Sql($db, 'users');
    $sql->select()->where()->greaterThanOrEqualTo('id', '?');
    $sql->select()->limit(4)->offset(1);

    echo $sql . '<br />' .  PHP_EOL;

    // Prepare the statement, bind the parameters and execute
    $db->adapter()->prepare($sql);
    $db->adapter()->bindParams(array('id' => 5));
    $db->adapter()->execute();

    foreach ($db->adapter()->fetchResult() as $row) {
        print_r($row);
    }
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
