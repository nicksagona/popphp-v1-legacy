Pop PHP Framework
=================

Documentation : Code
--------------------

Home

ã‚³ãƒ¼â€‹â€‹ãƒ‰ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã‚’ä½¿ç”¨ã?™ã‚‹ã?¨ã€?ã??ã?®å
´ã?§æ¨™æº–åŒ–ã?•ã‚Œã€?ã‚ˆã??æ§‹é€
åŒ–ã?•ã‚Œã?ŸPHPã‚³ãƒ¼ãƒ‰ã‚’ç”Ÿæˆ?ã?™ã‚‹ã?“ã?¨ã?Œã?§ã??ã?¾ã?™ã?Œã€?ã??ã‚Œã?«åŠ
ã?ˆã?¦ã€?PHPã?®ãƒªãƒ•ãƒ¬ã‚¯ã‚·ãƒ§ãƒ³ã?®æ‹¡å¼µæ©Ÿèƒ½ã‚’æ´»ç”¨ã?™ã‚‹ã?“ã?¨ã?§ã€?æ—¢å­˜ã?®ã‚³ãƒ¼ãƒ‰ã‚’å¤‰æ›´ã?—ã€?æ‹¡å¼µã?™ã‚‹ã?“ã?¨ã?Œã?§ã??ã?¾ã?™ã?
ã?‘ã?§ã?ªã??ã€?ã‚³ãƒ¼ãƒ‰ç”Ÿæˆ?ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?§ã?™ã€‚

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
