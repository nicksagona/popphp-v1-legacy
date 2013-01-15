<?php

require_once '../../bootstrap.php';

use Pop\Geo\Geo;

try {
    $geo1 = new Geo('123.123.123.123');
    $geo2 = new Geo('124.124.124.124');
    //echo $geo1->distanceTo($geo2->latitude, $geo2->longitude, 4);
    echo $geo1->distanceTo($geo2, 4);
} catch (\Exception $e) {
    echo $e->getMessage();
}

