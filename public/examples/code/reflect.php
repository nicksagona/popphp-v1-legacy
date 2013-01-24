<?php

require_once '../../bootstrap.php';

use Pop\Code;

try {
    $reflect = new Code\Reflection('Pop\Compress\Zlib');
    $code = $reflect->generator();

    // Create a method object to add to the class
    $method = new Code\Generator\MethodGenerator('someNewMethod');
    $method->setDesc('This is a new test method')
           ->setBody("// Let's get some stuff to happen here." . PHP_EOL . "\$blah = 'Sounds like a good idea';")
           ->appendToBody("echo \$blah;", false)
           ->addArgument('test', "null", '\Pop\Filter\String')
           ->addArgument('other', "array()", 'array');

    $code->code()->addMethod($method);
    $code->output();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
