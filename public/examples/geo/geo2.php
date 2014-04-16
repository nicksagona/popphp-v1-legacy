<?php

require_once '../../bootstrap.php';

use Pop\Geo\Geo;

try {
    $geo1 = new Geo(array(
        'latitude'  => '30.006003',
        'longitude' => '-90.10947'
    ));
    $geo2 = new Geo(array(
        'latitude'  => '32.919104',
        'longitude' => '-96.77497'
    ));
    echo $geo1->distanceTo($geo2, 2) . ' miles between New Orleans, LA and Dallas, TX.<br />';

    echo Geo::calculateDistance(
        array(
            'latitude'  => '32.919104',
            'longitude' => '-96.77497'
        ),
        array(
            'latitude'  => '30.006003',
            'longitude' => '-90.10947'
        ), 2, true
    ) . ' kilometers between New Orleans, LA and Dallas, TX.';
} catch (\Exception $e) {
    echo $e->getMessage();
}

