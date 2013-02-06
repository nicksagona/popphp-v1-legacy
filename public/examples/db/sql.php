<?php

require_once '../../bootstrap.php';

use Pop\Db\Db,
    Pop\Db\Sql;

try {
    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34',
        'type'     => 'mysql'
    );

    //$creds = array(
    //    'database' => 'phirecms',
    //    'host'     => 'localhost',
    //    'username' => 'postgres',
    //    'password' => '12post34',
    //    'type'     => 'pgsql'
    //);

    //$creds = array(
    //    'database' => '/home/nick/Projects/PopPHP/vendor/PopPHPFramework/tests/PopTest/tmp/test.sqlite',
    //    'type' => 'sqlite'
    //);

    // Create SQL object
    $sql = new Sql(Db::factory('Mysqli', $creds), 'users');
    print_r($sql);

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
