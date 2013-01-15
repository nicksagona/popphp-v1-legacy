<?php

require_once '../../bootstrap.php';

use Pop\Data\Data;

try {

    $data = new Data('../assets/files/test.csv');
    $csv = $data->parseFile();

    $data = new Data('../assets/files/test.json');
    $json = $data->parseFile();

    $data = new Data('../assets/files/test.sql');
    $sql = $data->parseFile();

    $data = new Data('../assets/files/test.xml');
    $xml = $data->parseFile();

    $data = new Data('../assets/files/test.yml');
    $yml = $data->parseFile();

    echo 'CSV data to XML file<br />-------------------<br />' . PHP_EOL;
    $data = new Data($csv);
    $obj = $data->parseData('xml');
    echo $obj;

    echo PHP_EOL . '<br /><br />' . PHP_EOL;
    echo 'SQL data to CSV file<br />-------------------<br />' . PHP_EOL;
    $data = new Data($sql);
    $obj = $data->parseData('csv');
    echo $obj;

    echo PHP_EOL . '<br /><br />' . PHP_EOL;
    echo 'SQL data to YAML file<br />-------------------<br />' . PHP_EOL;
    $data = new Data($sql);
    $obj = $data->parseData('yaml');
    echo $obj;

    echo PHP_EOL . '<br /><br />' . PHP_EOL;
    echo 'XML data to SQL file<br />-------------------<br />' . PHP_EOL;
    $data = new Data($xml);
    $data->setTable('users')
         ->setIdQuote('`');
    $obj = $data->parseData('sql');
    echo $obj;

    echo PHP_EOL . '<br /><br />' . PHP_EOL;
    echo 'YAML data to JSON file<br />-------------------<br />' . PHP_EOL;
    $data = new Data($yml);
    $obj = $data->parseData('json');
    echo $obj;
} catch (\Exception $e) {
    echo $e->getMessage();
}

