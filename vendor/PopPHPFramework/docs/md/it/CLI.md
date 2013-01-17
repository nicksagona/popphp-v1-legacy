Pop PHP Framework
=================

Documentation : Cli
-------------------

La riga di comando (CLI) componente è un componente molto utile che permette di eseguire alcune attività utili, quali:

* valutare l'ambiente delle dipendenze richieste
* installare un progetto da un file di installazione di progetto
* impostare la lingua predefinita di un'applicazione
* creare una mappa di classe
* riconfigurare un progetto che è stato spostato
* controllare la versione corrente contro l'ultima versione disponibile

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
