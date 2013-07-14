<?php

require_once '../../bootstrap.php';

use Pop\Paginator\Paginator;

try {
    $rows = array(
        array('id' => 1, 'name' => 'Test1', 'email' => 'test1@email.com'),
        array('id' => 2, 'name' => 'Test2', 'email' => 'test2@email.com'),
        array('id' => 3, 'name' => 'Test3', 'email' => 'test3@email.com'),
        array('id' => 4, 'name' => 'Test4', 'email' => 'test4@email.com'),
        array('id' => 5, 'name' => 'Test5', 'email' => 'test5@email.com'),
        array('id' => 6, 'name' => 'Test6', 'email' => 'test6@email.com'),
        array('id' => 7, 'name' => 'Test7', 'email' => 'test7@email.com'),
        array('id' => 8, 'name' => 'Test8', 'email' => 'test8@email.com'),
        array('id' => 9, 'name' => 'Test9', 'email' => 'test9@email.com'),
        array('id' => 10, 'name' => 'Test10', 'email' => 'test10@email.com'),
        array('id' => 11, 'name' => 'Test11', 'email' => 'test11@email.com'),
        array('id' => 12, 'name' => 'Test12', 'email' => 'test12@email.com'),
        array('id' => 13, 'name' => 'Test13', 'email' => 'test13@email.com'),
        array('id' => 14, 'name' => 'Test14', 'email' => 'test14@email.com'),
        array('id' => 15, 'name' => 'Test15', 'email' => 'test15@email.com'),
        array('id' => 16, 'name' => 'Test16', 'email' => 'test16@email.com')
    );

    $header = <<<HEADER
<table class="paged-table" cellpadding="0" cellspacing="0">
    <tr><td colspan="2">[{page_links}]</td></tr>
    <tr><td><strong>Name</strong></td><td><strong>Email</strong></td></tr>

HEADER;

    $rowTemplate = <<<TMPL
    <tr><td><a href="./edit-user.php?id=[{id}]">[{name}]</a></td><td>[{email}]</td></tr>

TMPL;

    $footer = <<<FOOTER
    <tr><td colspan="2">[{page_links}]</td></tr>
</table>

FOOTER;

    $pages = new Paginator($rows, 3, 3);
    $pages->setHeader($header)
          ->setRowTemplate($rowTemplate)
          ->setFooter($footer);
    echo $pages;
} catch (\Exception $e) {
    echo $e->getMessage();
}

