<?php

use Pop\Code\Generator;
require_once '../../bootstrap.php';

use Pop\Code\DocblockGenerator,
    Pop\Code\InterfaceGenerator,
    Pop\Code\MethodGenerator,
    Pop\Code\NamespaceGenerator;

try {
    // Create the code generator object
    $code = new Generator('../tmp/MyInterface.php', Generator::FILE_INTERFACE);
    $code->setDocblock(new DocblockGenerator('This is my test interface file'))
         ->getDocblock()->setTag('category', 'Pop')
                        ->setTag('package', 'Pop_Code')
                        ->setTag('author', 'Nick Sagona, III');

    // Create namespace object
    $ns = new NamespaceGenerator('Some\\Other');
    $ns->setUse('Some\\Other\\Thing')
       ->setUse('Some\\Other\\Blah', 'B')
       ->setUse('Some\\Other\\Another');

    // Create a method object
    $method = new MethodGenerator('testMethod');
    $method->setDesc('This is a test method')
           ->addArgument('test', "null", "Pop\\Filter\\String")
           ->addArgument('other', "array()", 'array');

    // Add code pieces to the code file
    $code->code()->setNamespace($ns);
    $code->code()->setDocblock(new DocblockGenerator('This is my test interface'))
                 ->getDocblock()->setTag('category', 'Pop')
                                ->setTag('package', 'Pop_Code')
                                ->setTag('author', 'Nick Sagona, III');

    $code->code()->addMethod($method);

    // Render and save the interface
    $code->save();
    echo 'Interface saved.' . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>