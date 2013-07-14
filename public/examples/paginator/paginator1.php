<?php

require_once '../../bootstrap.php';

use Pop\Paginator\Paginator;

try {
    $rows = array(
        array('name' => 'Test1', 'email' => 'test1@email.com'),
        array('name' => 'Test2', 'email' => 'test2@email.com'),
        array('name' => 'Test3', 'email' => 'test3@email.com'),
        array('name' => 'Test4', 'email' => 'test4@email.com'),
        array('name' => 'Test5', 'email' => 'test5@email.com'),
        array('name' => 'Test6', 'email' => 'test6@email.com'),
        array('name' => 'Test7', 'email' => 'test7@email.com'),
        array('name' => 'Test8', 'email' => 'test8@email.com'),
        array('name' => 'Test9', 'email' => 'test9@email.com'),
        array('name' => 'Test10', 'email' => 'test10@email.com'),
        array('name' => 'Test11', 'email' => 'test11@email.com'),
        array('name' => 'Test12', 'email' => 'test12@email.com'),
        array('name' => 'Test13', 'email' => 'test13@email.com'),
        array('name' => 'Test14', 'email' => 'test14@email.com'),
        array('name' => 'Test15', 'email' => 'test15@email.com'),
        array('name' => 'Test16', 'email' => 'test16@email.com')
    );

    $pages = new Paginator($rows, 3, 3);
    echo $pages;
} catch (\Exception $e) {
    echo $e->getMessage();
}

