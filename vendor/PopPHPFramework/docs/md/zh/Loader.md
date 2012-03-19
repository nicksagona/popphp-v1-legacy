Pop PHP Framework
=================

Documentation : Loader
----------------------

Loader组件可能是流行的PHP框架的最基本的，但最重要的组成部分。这是组件，驱动框架的自动装填能力，并可以很容易地与自己的应用程序自动加载器来加载自己的类注册。这单枪匹马替换所有那些旧的include语句，你曾经有过所有的地方。现在，所有你需要的是一个需要bootstrap.php'在上面的语句，你是好去。默认情况下，引导文件包含所需的参考框架的自动加载类，然后加载它。在引导文件，你可以轻松地执行其他加载功能，如登记与自动装带您的应用程序的命名空间，或装载一个ClassMap文件，以减少加载时间。

<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

如果你需要生成一个ClassMap文件，Loader组件具有的功能，可以轻松地为你生成一个classmap文件以及。

<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
