Pop PHP Framework
=================

Documentation : Archive
-----------------------

Home

存档组件的设计正常化的通用归档文件的创建和操纵，通过一个单一的API。支持的存档类型，分别是：

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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
