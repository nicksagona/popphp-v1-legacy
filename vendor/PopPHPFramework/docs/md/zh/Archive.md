Pop PHP Framework
=================

Documentation : Archive
-----------------------

Home

å­˜æ¡£ç»„ä»¶çš„è®¾è®¡æ­£å¸¸åŒ–çš„é€šç”¨å½’æ¡£æ–‡ä»¶çš„åˆ›å»ºå’Œæ“?çºµï¼Œé€šè¿‡ä¸€ä¸ªå?•ä¸€çš„APIã€‚æ”¯æŒ?çš„å­˜æ¡£ç±»åž‹ï¼Œåˆ†åˆ«æ˜¯ï¼š

-   tar
-   tar.gz
-   tar.bz2
-   zip
-   phar
-   rar

<!-- -->

    use Pop\Archive\Archive;

    // Create a new TAR archive and add some files to it
    $archive = new Archive('../tmp/test.tar');
    $archive->addFiles('../files');

    // Compress the archive, gzip by default.
    // Using 'bz', will produce '../tmp/test.tar.bz2'
    $archive->compress('bz');

    // Extract an existing archive file to specified folder,
    // will automatically uncompress the gzip file first
    $archive = new Archive('../tmp/existing.tar.gz');
    $archive->extract('/tmp');

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
