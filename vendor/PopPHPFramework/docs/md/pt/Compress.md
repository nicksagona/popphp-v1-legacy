Pop PHP Framework
=================

Documentation : Compress
------------------------

Home

O componente Compress fornece um método normalizado para compactar e
descompactar arquivos de dados e através dos métodos suportados:

-   bzip2
-   gzip & zlib
-   lzf

<!-- -->

    use Pop\Compress\Bzip2;

    $compressed = Bzip2::compress('Some string');
    $uncompressed = Bzip2::uncompress($compressed);

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
