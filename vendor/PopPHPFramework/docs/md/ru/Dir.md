Pop PHP Framework
=================

Documentation : Dir
-------------------

Dir компонентов полезно для списка файлов в каталоге, рекурсивно или не рекурсивно. Кроме того, есть способ, чтобы полностью очистить каталог, но это, очевидно, следует использовать с осторожностью.


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
