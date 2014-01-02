Pop PHP Framework
=================

Documentation : Compress
------------------------

Home

圧縮コンポーネントは、サポートされているメソッドを介して、データやファイルを圧縮、解凍する正規化された方法を提供する：

-   bzip2
-   gzip & zlib
-   lzf

<!-- -->

    use Pop\Compress\Bzip2;

    $compressed = Bzip2::compress('Some string');
    $uncompressed = Bzip2::uncompress($compressed);

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
