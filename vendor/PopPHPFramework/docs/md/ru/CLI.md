Pop PHP Framework
=================

Documentation : Cli
-------------------

Интерфейс командной строки (CLI) компонент является очень полезным компонентом, который позволяет выполнять некоторые полезные задачи, такие как:


* оценки текущей среды для необходимых зависимостей
</li>
* Установка проекта из установочного файла проекта
</li>
* установить язык по умолчанию для приложений
</li>
* Создание класса карты
</li>
* перенастроить проект, который был перемещен
</li>
* проверить текущую версию на последнюю доступную версию
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
