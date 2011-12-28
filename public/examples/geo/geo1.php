<?php

require_once '../../bootstrap.php';

use Pop\Geo\Geo;

try {
    $geo = new Geo('123.123.123.123');
    print_r($geo->getHostInfo());
    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>