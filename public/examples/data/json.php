<?php

require_once '../../bootstrap.php';

use Pop\Data\Json;

try {
    $var = array('This is a string', 123, 'This is another string');

    $json = Json::encode($var);
    echo $json . '<br />' . PHP_EOL;

    $php = Json::decode($json);
    print_r($php);
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>