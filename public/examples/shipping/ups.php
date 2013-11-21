<?php

require_once '../../bootstrap.php';

use Pop\Shipping\Shipping;
use Pop\Shipping\Adapter\Ups;

try {
    $shipping = new Shipping(new Ups('ACCESS_KEY', 'USER_ID', 'PASSWORD'));

    $shipping->shipTo(array(
        'company'  => 'Some Company',
        'address1' => '123 Main St.',
        'address2' => 'Suite A',
        'city'     => 'Metairie',
        'zip'      => '70002',
        'country'  => 'US'
    ));

    $shipping->shipFrom(array(
        'company'  => 'Another Company',
        'address1' => '456 Main St.',
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

    $shipping->send(false);

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
