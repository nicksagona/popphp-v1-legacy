Pop PHP Framework
=================

Documentation : Dir
-------------------

ディレクトリコンポーネントを再帰的または非再帰的に、ディレクトリ内のファイルをリストするために有用である。また、完全にディレクトリを空にする方法はありますが、それは明らかに注意して使用する必要があります。

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
