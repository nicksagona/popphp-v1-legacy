Pop PHP Framework
=================

Documentation : Cli
-------------------

The command-line interface (CLI) component is a very useful component that allows you perform some helpful tasks such as:

* evaluate the current environment for required dependencies</li>
* install a project from a project installation file</li>
* set the default language of an application</li>
* create a class map</li>
* reconfigure a project that has been moved</li>
* check the current version against the latest available version</li>

<pre>
script/pop --check                     // Check the current configuration for required dependencies
script/pop --help                      // Display this help
script/pop --install file.php          // Install a project based on the install file specified
script/pop --lang fr                   // Set the default language for the project
script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
script/pop --reconfig projectfolder    // Reconfigure the project based on the new location of the project
script/pop --show                      // Show project install instructions
script/pop --version                   // Display version of Pop PHP Framework and latest available
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
