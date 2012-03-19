Pop PHP Framework
=================

Documentation : Cli
-------------------

La línea de comandos (CLI) componente es un componente muy útil que te permite realizar algunas tareas útiles tales como:


* evaluar el entorno actual de las dependencias necesarias
</li>
* instalar un proyecto de un archivo de instalación del proyecto
</li>
* establecer el idioma predeterminado de una aplicación
</li>
* crear un mapa de la clase
</li>
* volver a configurar un proyecto que se ha movido
</li>
* comprobar la versión actual con respecto a la última versión disponible
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
