<?php

require_once '../../bootstrap.php';

use Pop\Data\Data;

try {
    echo 'From a CSV file<br />-------------------<br />' . PHP_EOL;
    $data = new Data('../assets/files/test.csv');
    $obj = $data->parseFile();
    print_r($obj);

    echo PHP_EOL . '<br /><br />' . PHP_EOL;
    echo 'From a JSON file<br />-------------------<br />' . PHP_EOL;
    $data = new Data('../assets/files/test.json');
    $obj = $data->parseFile();
    print_r($obj);

    echo PHP_EOL . '<br /><br />' . PHP_EOL;
    echo 'From a SQL file<br />-------------------<br />' . PHP_EOL;
    $data = new Data('../assets/files/test.sql');
    $obj = $data->parseFile();
    print_r($obj);

    echo PHP_EOL . '<br /><br />' . PHP_EOL;
    echo 'From an XML file<br />-------------------<br />' . PHP_EOL;
    $data = new Data('../assets/files/test.xml');
    $obj = $data->parseFile();
    print_r($obj);

    echo PHP_EOL . '<br /><br />' . PHP_EOL;
    echo 'From a YML file<br />-------------------<br />' . PHP_EOL;
    $data = new Data('../assets/files/test.yml');
    $obj = $data->parseFile();
    print_r($obj);
} catch (\Exception $e) {
    echo $e->getMessage();
}

