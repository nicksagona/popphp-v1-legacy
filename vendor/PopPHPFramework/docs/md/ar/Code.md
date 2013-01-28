Pop PHP Framework
=================

Documentation : Code
--------------------

Home

Ø§Ù„Ø¹Ù†ØµØ± Ù‡Ùˆ Ø¹Ù†ØµØ± Ø±Ù…Ø² Ø§Ù„Ø¬ÙŠÙ„ Ø§Ù„ØªØ¹Ù„ÙŠÙ…Ø§Øª
Ø§Ù„Ø¨Ø±Ù…Ø¬ÙŠØ© Ø§Ù„ØªÙŠ Ù„Ø§ ÙŠØ³Ù…Ø­ Ù„Ùƒ Ù„ØªÙˆÙ„ÙŠØ¯ Ù…ÙˆØ­Ø¯Ø©ØŒ
Ø±Ù…Ø² PHP Ø¬ÙŠØ¯Ø© Ø§Ù„ØªÙ†Ø¸ÙŠÙ… Ø¹Ù„Ù‰ Ø§Ù„Ø·Ø§ÙŠØ±ØŒ ÙˆÙ„ÙƒÙ†
Ø£ÙŠØ¶Ø§ ÙŠØ³Ù…Ø­ Ù„Ùƒ Ù„ØªØ¹Ø¯ÙŠÙ„ ÙˆØªÙˆØ³ÙŠØ¹ Ù†Ø·Ø§Ù‚
Ø§Ù„ØªØ¹Ù„ÙŠÙ…Ø§Øª Ø§Ù„Ø¨Ø±Ù…Ø¬ÙŠØ© Ø§Ù„Ù…ÙˆØ¬ÙˆØ¯Ø© Ù…Ù† Ø®Ù„Ø§Ù„
Ø§Ù„Ø§Ø³ØªÙ?Ø§Ø¯Ø© Ù…Ù† ØªÙ…Ø¯ÙŠØ¯ PHP ÙˆØ§Ù„ØªØ£Ù…Ù„.

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
