Pop PHP Framework
=================

Documentation : Cli
-------------------

Die Command-Line Interface (CLI)-Komponente ist eine sehr nützliche Komponente, die Sie durchführen einige hilfreiche Aufgaben wie erlaubt:

* Bewertung der aktuellen Umgebung zur erforderlichen Abhängigkeiten
* Installieren Sie ein Projekt aus einem Projekt Installationsdatei
* die voreingestellte Sprache des Antrags
* erstellen Sie eine Klasse Karte
* reconfigure ein Projekt, das verschoben wurde
* überprüfen Sie die aktuelle Version gegen die neueste verfügbare Version

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
