Pop PHP Framework
=================

Documentation : Compress
------------------------

Home

的压缩组件提供了一个标准化的方法，通过支持的方法来压缩和解压的数据和文件：

-   bzip2
-   gzip & zlib
-   lzf

<!-- -->

    use Pop\Compress\Bzip2;

    $compressed = Bzip2::compress('Some string');
    $uncompressed = Bzip2::uncompress($compressed);

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
