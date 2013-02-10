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

    $db = Db::factory('Mysqli', $creds);

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
    //$sql->select(array('name' => 'username', 'email'))
    //    ->join('user_data', array('id', 'user_id'), 'LEFT JOIN')
    //    ->where()->equalTo('username', 'testuser4')
    //             ->like('email', '%@test.com');

    //$sql->select()->groupBy('username')
    //              ->having()->like('username', '%test%');
    $sql->select()->where()->between('id', 2, 6);
    $sql->select()->limit(3)
                  ->offset(1)
                  ->orderBy('id', 'DESC');

    //$subSql2 = new Sql($db, 'users', 'users_table2');
    //$subSql2->select();

    //$subSql1 = new Sql($db, $subSql2, 'users_table1');
    //$subSql1->select();

    //$sql = new Sql($db, $subSql1);
    //$sql->select(array('username'))->where()->like('username', '%test%');

    echo $sql;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
