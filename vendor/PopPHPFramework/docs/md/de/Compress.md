Pop PHP Framework
=================

Documentation : Compress
------------------------

Die Compress-Komponente stellt eine normalisierte Methode zum Komprimieren und Dekomprimieren von Daten und Dateien über die unterstützten Methoden:

* bzip2
* gzip &amp; zlib
* lzf

<pre>
use Pop\Compress\Bzip2;

$compressed = Bzip2::compress('Some string');
$uncompressed = Bzip2:uncompress($compressed);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
