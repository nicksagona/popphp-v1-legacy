<?php

require_once '../../bootstrap.php';

use Pop\Geo\Geo;

try {
    $geo = new Geo('123.123.123.123');
    print_r($geo->getHostInfo());
} catch (\Exception $e) {
    echo $e->getMessage();
}

