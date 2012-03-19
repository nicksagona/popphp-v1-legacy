Pop PHP Framework
=================

Documentation : Dir
-------------------

Os componentes Dir é útil para listar arquivos em um diretório, recursivamente ou não-recursivamente. Além disso, existe um método para esvaziar completamente um directório, mas que devem, evidentemente, ser usado com cuidado.

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
