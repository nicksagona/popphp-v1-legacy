Pop PHP Framework
=================

Documentation : Compress
------------------------

圧縮コンポーネントがサポートされているメソッドを介してデータやファイルを圧縮し、解凍するために正規化されたメソッドを提供します。

* bzip2
* gzip &amp; zlib
* lzf

<pre>
use Pop\Compress\Bzip2;

$compressed = Bzip2::compress('Some string');
$uncompressed = Bzip2:uncompress($compressed);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
