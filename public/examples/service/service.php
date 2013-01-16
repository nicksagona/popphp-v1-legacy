<?php

require_once '../../bootstrap.php';

use Pop\Service\Locator;

try {
    $locator = Locator::factory('config', 'Pop\Config', array(array('test' => 123)));
    $locator->set('color', new \Pop\Color\Color(new \Pop\Color\Rgb(255, 0, 0)));
    print_r($locator->get('config'));
    print_r($locator->get('color'));
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
