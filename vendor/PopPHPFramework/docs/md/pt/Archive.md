Pop PHP Framework
=================

Documentation : Archive
-----------------------

Home

O componente de Arquivo Ã© projetado para normalizar a criaÃ§Ã£o e
manipulaÃ§Ã£o de arquivos de arquivo comuns atravÃ©s de uma Ãºnica API.
Tipos de arquivos suportados sÃ£o:

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
