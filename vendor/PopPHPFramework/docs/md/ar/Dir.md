Pop PHP Framework
=================

Documentation : Dir
-------------------

مكونات دير مفيد لسرد الملفات في دليل، بشكل متكرر أو غير متكرر. أيضا، هناك طريقة لتفريغ تماما دليل، ولكن ينبغي من الواضح أن استخدامها بحذر.

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
