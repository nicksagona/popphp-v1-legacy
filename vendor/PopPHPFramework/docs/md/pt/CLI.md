Pop PHP Framework
=================

Documentation : Cli
-------------------

A linha de comando interface do componente (CLI) é um componente muito útil que permite executar algumas tarefas úteis, tais como:

* avaliar o ambiente atual para as dependências necessárias
* instalar um projeto de um arquivo de instalação do projeto
* definir o idioma de uma aplicação
* criar um mapa de classe
* reconfigurar um projeto que foi movido
* verificar a versão atual com a última versão disponível

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
