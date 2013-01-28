Pop PHP Framework
=================

Documentation : Archive
-----------------------

Home

Î¤Î¿ ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î¿ Î‘Ï?Ï‡ÎµÎ¯Î¿ Î­Ï‡ÎµÎ¹ ÏƒÏ‡ÎµÎ´Î¹Î±ÏƒÏ„ÎµÎ¯ Î³Î¹Î±
Î½Î± Î¿Î¼Î±Î»Î¿Ï€Î¿Î¹Î·Î¸ÎµÎ¯ Î· Î´Î·Î¼Î¹Î¿Ï…Ï?Î³Î¯Î± ÎºÎ±Î¹
Ï‡ÎµÎ¹Ï?Î±Î³ÏŽÎ³Î·ÏƒÎ· Ï„Î·Ï‚ ÎºÎ¿Î¹Î½Î®Ï‚ Î±Ï?Ï‡ÎµÎ¯Î±
Î±Ï?Ï‡ÎµÎ¹Î¿Î¸Î­Ï„Î·ÏƒÎ·Ï‚ Î¼Î­ÏƒÏ‰ ÎµÎ½ÏŒÏ‚ ÎµÎ½Î¹Î±Î¯Î¿Ï… API.
Î‘Ï?Ï‡ÎµÎ¯Î¿ Ï„Ï?Ï€Î¿Î¹ Ï€Î¿Ï… Ï…Ï€Î¿ÏƒÏ„Î·Ï?Î¯Î¶Î¿Î½Ï„Î±Î¹ ÎµÎ¯Î½Î±Î¹
Î¿Î¹ ÎµÎ¾Î®Ï‚:

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
