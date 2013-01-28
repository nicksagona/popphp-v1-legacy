Pop PHP Framework
=================

Documentation : Archive
-----------------------

Home

Ð?Ñ€Ñ…Ð¸Ð² ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€ÐµÐ´Ð½Ð°Ð·Ð½Ð°Ñ‡ÐµÐ½ Ð´Ð»Ñ?
Ð½Ð¾Ñ€Ð¼Ð°Ð»Ð¸Ð·Ð°Ñ†Ð¸Ð¸ Ñ?Ð¾Ð·Ð´Ð°Ð½Ð¸Ñ? Ð¸ ÑƒÐ¿Ñ€Ð°Ð²Ð»ÐµÐ½Ð¸Ñ?
Ð¾Ð±Ñ‰Ð¸Ð¼Ð¸ Ñ„Ð°Ð¹Ð»Ð°Ð¼Ð¸ Ð°Ñ€Ñ…Ð¸Ð²Ð° Ñ‡ÐµÑ€ÐµÐ· ÐµÐ´Ð¸Ð½Ñ‹Ð¹ API.
Ð?Ñ€Ñ…Ð¸Ð² Ñ‚Ð¸Ð¿Ð¾Ð², ÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ðµ Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÑŽÑ‚Ñ?Ñ?:

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
