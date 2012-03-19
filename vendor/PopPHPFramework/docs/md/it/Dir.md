Pop PHP Framework
=================

Documentation : Dir
-------------------

I componenti Dir è utile per l'elenco dei file in una directory, in modo ricorsivo o non ricorsivo. Inoltre, vi è un metodo per svuotare completamente una directory, ma che dovrebbe ovviamente essere usato con cautela.

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
