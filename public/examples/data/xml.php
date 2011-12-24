<?php

require_once '../../bootstrap.php';

use Pop\Data\Xml,
    Pop\File\File;

try {
    $xml = new File('../assets/files/test.xml');

    $users = Xml::decode($xml->read());
    print_r($users);

    echo '<br />' . PHP_EOL;

    $xmlStr = Xml::encode($users, 'users', false);
    echo $xmlStr;
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>