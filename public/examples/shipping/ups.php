<?php

require_once '../../bootstrap.php';

use Pop\Shipping\Shipping;
use Pop\Shipping\Adapter\Ups;

try {
    $shipping = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));

    $shipping->shipTo(array(
        'company'  => 'Orthosynetics',
        'address1' => '3850 N. Causeway Blvd',
        'address2' => 'Suite 800',
        'city'     => 'Metairie',
        'zip'      => '70002',
        'country'  => 'US'
    ));

    $shipping->shipFrom(array(
        'company'  => 'Moc 10 Media',
        'address1' => '6069 Louis XIV St.',
        'city'     => 'New Orleans',
        'zip'      => '70124',
        'country'  => 'US'
    ));

    $shipping->setDimensions(array(
        'length' => 12,
        'height' => 3,
        'width'  => 6
    ));

    $shipping->setWeight(5);

    $shipping->send();

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
