<?php

require_once '../../bootstrap.php';

use Pop\Service\Locator;

try {
    $locator = new Locator();

    // Load the services manually via the setter
    $locator->set('config', 'Pop\Config', array(array('test' => 123)))
            ->set('color', 'Pop\Color\Color', array(new \Pop\Color\Rgb(255, 0, 0)));

    // Get a service
    print_r($locator->get('config'));

    // Remove a service
    $locator->remove('color');

    print_r($locator);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
