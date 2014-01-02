Pop PHP Framework
=================

Documentation : Compress
------------------------

Home

רכיב הדחיסה מספק שיטה מנורמלת לדחיסה ולביטול דחיסה של נתונים וקבצים
באמצעות השיטות הנתמכות:

-   bzip2
-   gzip & zlib
-   lzf

<!-- -->

    use Pop\Compress\Bzip2;

    $compressed = Bzip2::compress('Some string');
    $uncompressed = Bzip2::uncompress($compressed);

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
