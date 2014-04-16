<?php

require_once '../../bootstrap.php';

use Pop\Geo\Geo;

try {
    $geo = new Geo(array(
        'host' => '123.123.123.123'
    ));
    print_r($geo->getHostInfo());
} catch (\Exception $e) {
    echo $e->getMessage();
}

