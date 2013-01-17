Pop PHP Framework
=================

Documentation : Loader
----------------------

The Loader component is probably the most basic, yet most important component of the Pop PHP Framework. It's the component that drives the framework's autoloading capabilities, and your own application can easily be registered with the autoloader to load your own classes. This singlehandedly replaces all of those old include statements you used to have all over the place. Now, all you need is one require statement of the 'bootstrap.php' at the top and you're good to go. By default, the bootstrap file contains the required reference to the framework's Autoloader class and then loads it up. Within the bootstrap file, you can easily perform other loading functions, such as registering your application's namespace with the autoloader, or loading a classmap file to decrease load time.

<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

And if you need a classmap file generated, the Loader component has the functionality to easily generate a classmap file for you as well.

<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
