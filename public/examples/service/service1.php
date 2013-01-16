<?php

require_once '../../bootstrap.php';

use Pop\Service\Locator;

try {
    // Load the services config via the constructor
    $locator = new Locator(array(
        'config' => array(
            'class'  => 'Pop\Config',
            'params' => array(array('test' => 123), true)
        ),
        'color' => array(
            'class'  => 'Pop\Color\Color',
            'params' => function() { return array(new \Pop\Color\Rgb(255, 0, 0)); }
        )
    ));

    // Services have not been loaded/instantiated yet
    print_r($locator);

    // Get the services as you need them
    print_r($locator->get('config'));
    print_r($locator->get('color'));

    // Now the services are loaded/instantiated within the locator object
    print_r($locator);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
