Pop PHP Framework
=================

Documentation : Compress
------------------------

La composante Compress offre une méthode normalisée pour compresser et décompresser des données et des fichiers via les méthodes prises en charge:


* bzip2
* gzip &amp; zlib
* lzf

<pre>
use Pop\Compress\Bzip2;

$compressed = Bzip2::compress('Some string');
$uncompressed = Bzip2:uncompress($compressed);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
