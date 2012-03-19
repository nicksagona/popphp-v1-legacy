Pop PHP Framework
=================

Documentation : Archive
-----------------------

存档组件设计正常化共同归档文件的创建和操纵，通过一个单一的API。所支持的存档类型是：


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

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
