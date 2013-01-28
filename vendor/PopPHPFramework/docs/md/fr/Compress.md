Pop PHP Framework
=================

Documentation : Compress
------------------------

Home

La composante Compress offre une mÃ©thode normalisÃ©e pour compresser et
dÃ©compresser des donnÃ©es et des fichiers via les mÃ©thodes prises en
charge:

-   bzip2
-   gzip & zlib
-   lzf

<!-- -->

    use Pop\Compress\Bzip2;

    $compressed = Bzip2::compress('Some string');
    $uncompressed = Bzip2::uncompress($compressed);

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
