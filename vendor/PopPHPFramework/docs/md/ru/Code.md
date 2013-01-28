Pop PHP Framework
=================

Documentation : Code
--------------------

Home

ÐšÐ¾Ð´ ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð¾Ð¼ Ñ?Ð²Ð»Ñ?ÐµÑ‚Ñ?Ñ? ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚
Ð³ÐµÐ½ÐµÑ€Ð°Ñ†Ð¸Ð¸ ÐºÐ¾Ð´Ð°, ÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ð¹ Ð½Ðµ Ñ‚Ð¾Ð»ÑŒÐºÐ¾
Ð¿Ð¾Ð·Ð²Ð¾Ð»Ñ?ÐµÑ‚ Ñ?Ð¾Ð·Ð´Ð°Ð²Ð°Ñ‚ÑŒ
Ñ?Ñ‚Ð°Ð½Ð´Ð°Ñ€Ñ‚Ð¸Ð·Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ñ‹Ðµ, Ñ…Ð¾Ñ€Ð¾ÑˆÐ¾
Ñ?Ñ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ð°Ñ? PHP ÐºÐ¾Ð´Ð° Ð½Ð° Ð»ÐµÑ‚Ñƒ, Ð½Ð¾
Ñ‚Ð°ÐºÐ¶Ðµ Ð¿Ð¾Ð·Ð²Ð¾Ð»Ñ?ÐµÑ‚ Ð¸Ð·Ð¼ÐµÐ½Ñ?Ñ‚ÑŒ Ð¸ Ñ€Ð°Ñ?ÑˆÐ¸Ñ€Ñ?Ñ‚ÑŒ
Ñ?ÑƒÑ‰ÐµÑ?Ñ‚Ð²ÑƒÑŽÑ‰Ð¸Ð¹ ÐºÐ¾Ð´, Ð¸Ñ?Ð¿Ð¾Ð»ÑŒÐ·ÑƒÑ? Ð¾Ñ‚Ñ€Ð°Ð¶ÐµÐ½Ð¸Ðµ
Ñ€Ð°Ñ?ÑˆÐ¸Ñ€ÐµÐ½Ð¸ÐµÐ¼ PHP.

    use Pop\Code;

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
           ->addArgument('test', "null", "Pop\Filter\String")
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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
