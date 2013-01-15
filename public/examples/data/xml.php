<?php

require_once '../../bootstrap.php';

use Pop\Data\Type\Xml;

try {
    $users = Xml::decode(file_get_contents('../assets/files/test.xml'));
    print_r($users);

    echo '<br />' . PHP_EOL;

    $xmlStr = Xml::encode($users, 'users', false);
    echo $xmlStr;
} catch (\Exception $e) {
    echo $e->getMessage();
}

