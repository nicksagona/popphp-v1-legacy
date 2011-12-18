<?php

require_once '../../bootstrap.php';

use Pop\Code\MethodGenerator;

try {
    // Create method object and set the description
    $method = new MethodGenerator('testMethod');
    $method->setDesc('This is a test method')
           ->setBody("// Let's get some stuff to happen here." . PHP_EOL . "\$blah = 'Sounds like a good idea';")
           ->appendToBody("echo \$blah;")
           ->addArgument('test', "null", "Pop\\Filter\\String")
           ->addArgument('other', "array()", 'array');

    // Output the method
    echo $method . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>