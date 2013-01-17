Pop PHP Framework
=================

Documentation : Loader
----------------------

Die Loader-Komponente ist wahrscheinlich der Grund-, noch die wichtigste Komponente des Pop PHP Framework. Es ist die Komponente, die den Rahmen der Autoloading Möglichkeiten treibt, und eine eigene Anwendung kann leicht mit dem Autoloader, eigene Klassen zu laden registriert werden. Dieser Alleingang ersetzt alle diese alten Sie umfassen auch Aussagen verwendet werden, um alle über den Ort zu haben. Nun brauchen Sie nur ein erfordern Aussage der 'bootstrap.php' an der Spitze und du bist gut zu gehen. Standardmäßig enthält die Bootstrap-Datei den gewünschten Verweis auf das Framework Autoloader-Klasse und lädt ihn auf. Innerhalb der Bootstrap-Datei, können Sie problemlos durchführen Weitere Lade-Funktionen wie Registrierung Ihrer Anwendung des Namespaces mit dem Autoloader oder Laden einer Datei zu classmap Ladezeit zu verringern.

<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

Und wenn Sie eine Datei generiert classmap müssen, hat der Loader-Komponente die Funktionen zum einfachen Erzeugen eines classmap Datei auch für Sie.

<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
