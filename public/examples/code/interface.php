<?php

use Pop\Code\Generator;
require_once '../../bootstrap.php';

use Pop\Code\DocblockGenerator,
    Pop\Code\InterfaceGenerator,
    Pop\Code\MethodGenerator,
    Pop\Code\NamespaceGenerator;

try {
    // Create the code generator object
    $code = new Generator('../tmp/MyInterface.php', Generator::CREATE_INTERFACE);
    $code->setDocblock(new DocblockGenerator('This is my test interface file'))
         ->getDocblock()->setTag('category', 'Pop')
                        ->setTag('package', 'Pop_Code')
                        ->setTag('author', 'Joe Author');

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

    // Create another method object
    $method2 = new MethodGenerator('anotherMethod');
    $method2->setDesc('This is another test method')
            ->addArgument('someParam', "array()", 'array');
    // Add code pieces to the code file

    $code->setNamespace($ns);
    $code->code()->setDocblock(new DocblockGenerator('This is my test interface'))
                 ->getDocblock()->setTag('category', 'Pop')
                                ->setTag('package', 'Pop_Code')
                                ->setTag('author', 'Joe Author');

    $code->code()->addMethod($method)
                 ->addMethod($method2);

    // Render and save the interface
    $code->save();
    echo 'Interface saved.' . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
