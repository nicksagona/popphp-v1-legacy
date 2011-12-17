<?php

require_once '../../bootstrap.php';

use Pop\Code\MethodGenerator;

try {
    // Create method object and set the description
    $method = new MethodGenerator('testMethod');
    $method->setDesc('This is a test method');

    // Output the method
    echo $method . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>