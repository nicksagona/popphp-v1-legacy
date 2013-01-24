<?php

require_once '../../bootstrap.php';

use Pop\Code;

try {
    // Create the code generator object
    $code = new Code\Generator('../tmp/MyInterface.php', Code\Generator::CREATE_INTERFACE);
    $code->setDocblock(new Code\Generator\DocblockGenerator('This is my test interface file'))
         ->getDocblock()->setTag('category', 'Pop')
                        ->setTag('package', 'Pop_Code')
                        ->setTag('author', 'Joe Author');

    // Create namespace object
    $ns = new Code\Generator\NamespaceGenerator('Some\Other');
    $ns->setUse('Some\Other\Thing')
       ->setUse('Some\Other\Blah', 'B')
       ->setUse('Some\Other\Another');

    // Create a method object
    $method = new Code\Generator\MethodGenerator('testMethod');
    $method->setDesc('This is a test method')
           ->addArgument('test', "null", '\Pop\Filter\String')
           ->addArgument('other', "array()", 'array');

    // Create another method object
    $method2 = new Code\Generator\MethodGenerator('anotherMethod');
    $method2->setDesc('This is another test method')
            ->addArgument('someParam', "array()", 'array');
    // Add code pieces to the code file

    $code->setNamespace($ns);
    $code->code()->setDocblock(new Code\Generator\DocblockGenerator('This is my test interface'))
                 ->getDocblock()->setTag('category', 'Pop')
                                ->setTag('package', 'Pop_Code')
                                ->setTag('author', 'Joe Author');

    $code->code()->addMethod($method)
                 ->addMethod($method2);

    // Render and save the interface
    $code->save();
    echo 'Interface saved.';
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
