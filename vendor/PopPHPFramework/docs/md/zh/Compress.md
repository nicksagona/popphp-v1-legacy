Pop PHP Framework
=================

Documentation : Compress
------------------------

压缩组件提供了一个标准化的方法来压缩和解压文件支持的方法，并通过数据：


* bzip2
* gzip &amp; zlib
* lzf

<pre>
use Pop\Compress\Bzip2;

$compressed = Bzip2::compress('Some string');
$uncompressed = Bzip2:uncompress($compressed);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
