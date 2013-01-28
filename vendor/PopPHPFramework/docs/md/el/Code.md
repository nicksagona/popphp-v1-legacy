Pop PHP Framework
=================

Documentation : Code
--------------------

Home

Î¤Î¿ ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ ÎšÏŽÎ´Î¹ÎºÎ±Ï‚ ÎµÎ¯Î½Î±Î¹ Î­Î½Î±
ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ Ï€Î±Ï?Î±Î³Ï‰Î³Î® ÎºÏŽÎ´Î¹ÎºÎ± Ï€Î¿Ï… ÏŒÏ‡Î¹ Î¼ÏŒÎ½Î¿
ÏƒÎ±Ï‚ ÎµÏ€Î¹Ï„Ï?Î­Ï€ÎµÎ¹ Î½Î± Î´Î·Î¼Î¹Î¿Ï…Ï?Î³Î®ÏƒÎµÏ„Îµ
Ï„Ï…Ï€Î¿Ï€Î¿Î¹Î·Î¼Î­Î½ÎµÏ‚, Î¬Ï?Ï„Î¹Î± Î´Î¿Î¼Î·Î¼Î­Î½Î¿ ÎºÏŽÎ´Î¹ÎºÎ± PHP
on the fly, Î±Î»Î»Î¬ ÏƒÎ±Ï‚ ÎµÏ€Î¹Ï„Ï?Î­Ï€ÎµÎ¹ ÎµÏ€Î¯ÏƒÎ·Ï‚ Î½Î±
Ï„Ï?Î¿Ï€Î¿Ï€Î¿Î¹Î®ÏƒÎµÎ¹ ÎºÎ±Î¹ Î½Î± ÎµÏ€ÎµÎºÏ„ÎµÎ¯Î½ÎµÎ¹
Ï…Ï€Î¬Ï?Ï‡Î¿Î½Ï„Î± ÎºÏŽÎ´Î¹ÎºÎ± Î¼Îµ Ï„Î· Î¼ÏŒÏ‡Î»ÎµÏ…ÏƒÎ·
ÎµÏ€Î­ÎºÏ„Î±ÏƒÎ· Î‘Î½Ï„Î±Î½Î¬ÎºÎ»Î±ÏƒÎ· Ï„Î·Ï‚ PHP.

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
