<?php

require_once '../../bootstrap.php';

use Pop\Code\PropertyGenerator;

try {
    // Create property object as a constant property and set the description
    $const = new PropertyGenerator('SOME_CONSTANT', 'int', 0, 'const');
    $const->setDesc('This is a test constant');

    // Create property object as a static property and set the description
    $prop = new PropertyGenerator('testProp', 'string', 'test', 'protected');
    $prop->setDesc('This is a test property')
         ->setStatic(true);

    // Output the properties
    echo $const . PHP_EOL . PHP_EOL;
    echo $prop . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>