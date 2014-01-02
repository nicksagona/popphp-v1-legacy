Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

Die Loader-Komponente ist wahrscheinlich die einfachste, aber wichtigste
Komponente des Pop PHP Framework. Es ist die Komponente, die das
Framework Autoloader-Funktionen antreibt, und Ihre eigene Anwendung kann
leicht mit dem Autoloader eigene Klassen zu laden registriert werden.
Dieser Alleingang ersetzt alle diese alten include-Anweisungen verwendet
werden, um auf der ganzen Ort zu haben. Jetzt ist alles was Sie brauchen
ein fordern Aussage der 'bootstrap.php' an der Spitze und du bist gut zu
gehen. Standardmäßig enthält die Bootstrap-Datei den gewünschten Verweis
auf das Framework Autoloader Klasse und dann lädt es auf. Innerhalb der
Bootstrap-Datei, können Sie leicht andere Ladefunktionen, wie Sie Ihre
Anwendung registrieren Namensraum mit dem Autoloader oder Laden einer
classmap Datei Ladezeit verringern.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

Und wenn Sie einen classmap Datei generiert benötigen, hat der
Loader-Komponente die Funktionalität auf einfache Weise eine classmap
Datei für Sie als gut.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
