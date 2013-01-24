<?php

require_once '../../bootstrap.php';

use Pop\Code;

try {
    // Create the code generator object
    $code = new Code\Generator('MyClass.php', Code\Generator::CREATE_CLASS);
    $code->setDocblock(new Code\Generator\DocblockGenerator('This is my test class file'))
         ->getDocblock()->setTag('category', 'Pop')
                        ->setTag('package', 'Pop_Code')
                        ->setTag('author', 'Joe Author');

    // Create namespace object
    $ns = new Code\Generator\NamespaceGenerator('Some\Other');
    $ns->setUse('Some\Other\Thing')
       ->setUse('Some\Other\Blah', 'B')
       ->setUse('Some\Other\Another');

    // Create property object
    $prop = new Code\Generator\PropertyGenerator('_testProp', 'string', 'test', 'protected');
    $prop->setDesc('This is a test property');

    // Create a method object
    $method = new Code\Generator\MethodGenerator('__construct');
    $method->setDesc('This is a test method')
           ->setBody("// Let's get some stuff to happen here." . PHP_EOL . "\$blah = 'Sounds like a good idea';")
           ->appendToBody("echo \$blah;", false)
           ->addArgument('test', "null", "Pop\\Filter\\String")
           ->addArgument('other', "array()", 'array');

    // Add code pieces to the code file
    $code->setNamespace($ns);
    $code->code()->setDocblock(new Code\Generator\DocblockGenerator('This is my test class'))
                 ->getDocblock()->setTag('category', 'Pop')
                                ->setTag('package', 'Pop_Code')
                                ->setTag('author', 'Joe Author');

    $code->code()->addProperty($prop);
    $code->code()->addMethod($method);

    // Render and output the code
    $code->output();
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
