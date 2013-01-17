Pop PHP Framework
=================

Documentation : Archive
-----------------------

The Archive component is designed to normalize the creation and manipulation of common archive files through a single API. Archive types that are supported are:

* tar
* tar.gz
* tar.bz2
* zip
* phar
* rar

<pre>
use Pop\Archive\Archive;

// Create a new TAR archive and add some files to it
$archive = new Archive('../tmp/test.tar');
$archive->addFiles('../files');

// Compress the archive, gzip by default,
// will produce '../tmp/test.tar.gz'
$archive->compress();

// Extract an existing archive file to specified folder,
// will automatically uncompress the gzip file first
$archive = new Archive('../tmp/existing.tar.gz');
$archive->extract('/tmp');
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
