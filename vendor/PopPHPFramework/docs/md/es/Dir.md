Pop PHP Framework
=================

Documentation : Dir
-------------------

Los componentes de Dir es útil para crear listas de archivos en un directorio, de forma recursiva o no recursiva. Además, hay un método para vaciar completamente un directorio, pero que, obviamente, se debe utilizar con precaución.

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
