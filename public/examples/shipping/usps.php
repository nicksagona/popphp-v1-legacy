<?php

require_once '../../bootstrap.php';

use Pop\Shipping\Shipping;
use Pop\Shipping\Adapter\Usps;

try {
    $shipping = new Shipping(new Usps('USERNAME', 'PASSWORD', true));

    $shipping->shipTo(array(
        'zip'      => '70002'
    ));

    $shipping->shipFrom(array(
        'zip'      => '70124'
    ));

    $shipping->setDimensions(array(
        'length' => 12,
        'height' => 3,
        'width'  => 6
    ));

    $shipping->setWeight(5.4);

    $shipping->send(false);

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
