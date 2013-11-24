<?php

require_once '../../bootstrap.php';

use Pop\Shipping\Shipping;
use Pop\Shipping\Adapter\Fedex;

try {
    $shipping = new Shipping(new Fedex('KEY', 'PASSWORD', 'ACCT_NUM', 'METER_NUM'));

    $shipping->shipTo(array(
        'company'  => 'Some Company',
        'address1' => '123 Main St.',
        'address2' => 'Suite A',
        'city'     => 'Metairie',
        'state'    => 'LA',
        'zip'      => '70002',
        'country'  => 'US'
    ));

    $shipping->shipFrom(array(
        'company'  => 'My Company',
        'address1' => '456 Main St.',
        'city'     => 'New Orleans',
        'state'    => 'LA',
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

    if ($shipping->isSuccess()) {
        foreach ($shipping->getRates() as $rate => $cost) {
            echo $rate . ': $' . $cost . '<br />' . PHP_EOL;
        }
    } else {
        echo $shipping->getResponseCode() . ' : ' . $shipping->getResponseMessage() . '<br />' . PHP_EOL;
    }
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
