Pop PHP Framework
=================

Documentation : Compress
------------------------

Home

Die Compress-Komponente stellt eine normalisierte Methode zum
Komprimieren und Entpacken von Daten und Dateien über die unterstützten
Methoden:

-   bzip2
-   gzip & zlib
-   lzf

<!-- -->

    use Pop\Compress\Bzip2;

    $compressed = Bzip2::compress('Some string');
    $uncompressed = Bzip2::uncompress($compressed);

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
