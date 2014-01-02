Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

Loader组件可能是最基本的，也是最重要的组成部分流行的PHP框架。它的组件，驱动框架的自动加载功能，并可以很容易地注册自己的应用程序的自动加载你自己的类加载。这单枪匹马取代所有那些老include语句，你有所有的地方。现在，所有你需要的是一个在顶部的“bootstrap.php”require语句，你是好去。默认情况下，程序的引导文件中包含所需的参考框架的自动加载磁带机类，然后将其加载了。在程序的引导文件中，你可以很容易地执行其他加载功能，如注册您的应用程序的命名空间的自动加载磁带机，或加载一个ClassMap文件，以减少加载时间。

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

如果你需要一个ClassMap生成的文件，Loader组件的功能，可以轻松地生成一个ClassMap文件以及。

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
