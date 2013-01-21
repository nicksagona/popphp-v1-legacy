<?php

require_once '../../bootstrap.php';

use Pop\Service\Locator;

try {
    // Load the services config via the constructor
    $locator = new Locator(array(
        'service1' => function($locator) {
            return $locator->get('service2');
        },
        'service2' => function($locator) {
            return $locator->get('service1');
        }
    ));
    // Get the service1, but cause (and detect) a recursion loop.
    print_r($locator->get('service1'));
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
