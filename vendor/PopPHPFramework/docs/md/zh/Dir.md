Pop PHP Framework
=================

Documentation : Dir
-------------------

迪尔组件是上市文件在一个目录，递归和非递归。此外，还有一种方法来完全清空目录，但显然应该谨慎使用。

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
