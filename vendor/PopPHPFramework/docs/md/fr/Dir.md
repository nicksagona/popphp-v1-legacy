Pop PHP Framework
=================

Documentation : Dir
-------------------

Les composants Dir est utile pour le listage des fichiers dans un répertoire, récursivement ou non récursive. En outre, il existe une méthode pour vider complètement un répertoire, mais cela ne devrait évidemment être utilisée avec prudence.

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
