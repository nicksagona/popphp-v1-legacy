<?php

require_once '../../bootstrap.php';

use Pop\Geo\Geo;

try {
    $geo1 = new Geo('123.123.123.123');
    $geo2 = new Geo('234.234.234.234');
    //echo $geo1->distanceTo($geo2->latitude, $geo2->longitude, 4);
    echo $geo1->distanceTo($geo2, 4);
    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>