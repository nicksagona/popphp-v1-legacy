<?php

require_once '../../bootstrap.php';

use Pop\Code\ClassGenerator,
    Pop\Code\DocblockGenerator,
    Pop\Code\Generator,
    Pop\Code\MethodGenerator,
    Pop\Code\NamespaceGenerator,
    Pop\Code\PropertyGenerator;

try {
    // Create the code generator object
    $code = new Generator('code.php');
    $code->setBody("// Let's get some stuff to happen here." . PHP_EOL . "\$blah = 'Sounds like a good idea';")
         ->appendToBody("echo \$blah;", false)
         ->setClose(true);

    // Render and output the code
    $code->output();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>