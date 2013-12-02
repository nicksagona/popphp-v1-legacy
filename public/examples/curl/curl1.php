<?php

require_once '../../bootstrap.php';

use Pop\Curl\Curl;

try {
    $curl = new Curl('http://www.popphp.org/license');
    $curl->execute();
    header('Content-Type: text/plain');
    echo $curl->getBody();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
