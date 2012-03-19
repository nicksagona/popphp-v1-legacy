Pop PHP Framework
=================

Documentation : Compress
------------------------

عنصر ضغط يوفر طريقة طبيعية لضغط وإلغاء ضغط البيانات والملفات عن طريق الأساليب المعتمدة:


* bzip2
* gzip &amp; zlib
* lzf

<pre>
use Pop\Compress\Bzip2;

$compressed = Bzip2::compress('Some string');
$uncompressed = Bzip2:uncompress($compressed);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
