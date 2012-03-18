Pop PHP Framework
=================

Documentation : Dir
-------------------

The Dir components is useful for listing files in a directory, recursively or non-recursively. Also, there is a method to completely empty a directory, but that should obviously be used with caution.

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
