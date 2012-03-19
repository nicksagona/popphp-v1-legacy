Pop PHP Framework
=================

Documentation : Dir
-------------------

Die Regie-Komponenten ist nützlich für die Auflistung von Dateien in einem Verzeichnis rekursiv oder nicht rekursiv. Außerdem gibt es eine Methode, um vollständig zu entleeren Sie ein Verzeichnis, aber das sollte natürlich mit Vorsicht verwendet werden.

<pre>
use Pop\Dir\Dir;

// Create the Dir object
$dir = new Dir('../mydir);

// Loop through the files in the directory
foreach ($dir->files as $file) {
    echo $file;
}
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
