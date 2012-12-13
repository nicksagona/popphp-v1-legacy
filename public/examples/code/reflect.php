<?php

require_once '../../bootstrap.php';

use Pop\Code\MethodGenerator,
    Pop\Code\Reflection;

try {
    $reflect = new Reflection('Pop\Auth\Auth');
    $code = $reflect->getGenerator();

    // Create a method object to add
    $method = new MethodGenerator('someNewMethod');
    $method->setDesc('This is a new test method')
           ->setBody("// Let's get some stuff to happen here." . PHP_EOL . "\$blah = 'Sounds like a good idea';")
           ->appendToBody("echo \$blah;", false)
           ->addArgument('test', "null", 'Pop\Filter\String')
           ->addArgument('other', "array()", 'array');

    $code->code()->addMethod($method);
    $code->output();

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
