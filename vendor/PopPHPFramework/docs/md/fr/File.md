Pop PHP Framework
=================

Documentation : File
--------------------

Home

La composante fichier fournit une API utile pour gÃ©rer et manipuler des
fichiers sur le disque. Il fournit Ã©galement la fonctionnalitÃ© de
gÃ©rer facilement les tÃ©lÃ©chargements de fichiers.

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

Il fournit Ã©galement un moyen facile de parcourir les rÃ©pertoires et
accÃ©der et manipuler des fichiers en leur sein.

    use Pop\File\Dir;

    // Create the Dir object
    $dir = new Dir('../mydir');

    // Loop through the files in the directory
    $files = $dir->getFiles();
    foreach ($files as $file) {
        echo $file;
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
