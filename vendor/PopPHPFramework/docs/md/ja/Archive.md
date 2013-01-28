Pop PHP Framework
=================

Documentation : Archive
-----------------------

Home

ã‚¢ãƒ¼ã‚«ã‚¤ãƒ–ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?å?˜ä¸€ã?®APIã‚’ä»‹ã?—ã?¦å…±é€šã?®ã‚¢ãƒ¼ã‚«ã‚¤ãƒ–ãƒ•ã‚¡ã‚¤ãƒ«ã?®ä½œæˆ?ã?¨æ“?ä½œã‚’æ­£è¦?åŒ–ã?™ã‚‹ã?Ÿã‚?ã?«è¨­è¨ˆã?•ã‚Œã?¦ã?„ã?¾ã?™ã€‚ã‚µãƒ?ãƒ¼ãƒˆã?•ã‚Œã?¦ã?„ã‚‹ã‚¢ãƒ¼ã‚«ã‚¤ãƒ–ã?®ç¨®é¡žã?¯ä»¥ä¸‹ã?®ã?¨ã?Šã‚Šã?§ã?™ã€‚

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
