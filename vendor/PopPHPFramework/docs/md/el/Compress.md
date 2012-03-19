Pop PHP Framework
=================

Documentation : Compress
------------------------

Το στοιχείο Συμπίεση παρέχει μια τυποποιημένη μέθοδο για τη συμπίεση και αποσυμπίεση των δεδομένων και αρχείων μέσω τις μεθόδους που υποστηρίζονται:

* bzip2
* gzip &amp; zlib
* lzf

<pre>
use Pop\Compress\Bzip2;

$compressed = Bzip2::compress('Some string');
$uncompressed = Bzip2:uncompress($compressed);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
