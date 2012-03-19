Pop PHP Framework
=================

Documentation : Cli
-------------------

La ligne de commande (CLI) composant est un composant très utile qui vous permet d'effectuer certaines tâches utiles telles que:


* d'évaluer l'environnement actuel des dépendances requises
</li>
* installer un projet à partir d'un fichier d'installation du projet
</li>
* définir la langue par défaut d'une demande
</li>
* créer une carte de classe
</li>
* reconfigurer un projet qui a été déplacé
</li>
* vérifier la version actuelle contre la dernière version disponible
</li>

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
