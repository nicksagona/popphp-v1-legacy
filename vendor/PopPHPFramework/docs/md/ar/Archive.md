Pop PHP Framework
=================

Documentation : Archive
-----------------------

Home

ØªÙ… ØªØµÙ…ÙŠÙ… Ù…ÙƒÙˆÙ† Ø§Ù„Ø£Ø±Ø´ÙŠÙ? Ù„ØªØ·Ø¨ÙŠØ¹ Ø®Ù„Ù‚
ÙˆØ§Ù„ØªÙ„Ø§Ø¹Ø¨ Ù…Ù† Ù…Ù„Ù?Ø§Øª Ø§Ù„Ø£Ø±Ø´ÙŠÙ? Ø§Ù„Ù…Ø´ØªØ±ÙƒØ© Ù…Ù†
Ø®Ù„Ø§Ù„ API ÙˆØ§Ø­Ø¯Ø©. Ø£Ù†ÙˆØ§Ø¹ Ø§Ù„Ø£Ø±Ø´ÙŠÙ? Ø§Ù„ØªÙŠ ÙŠØªÙ…
Ø¯Ø¹Ù…Ù‡Ø§ Ù‡ÙŠ:

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
