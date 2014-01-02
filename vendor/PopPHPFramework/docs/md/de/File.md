Pop PHP Framework
=================

Documentation : File
--------------------

Home

Das File-Komponente stellt eine nützliche API zur Verwaltung und
Bearbeitung von Dateien auf der Festplatte. Es bietet auch die
Funktionalität auf einfache Weise verwalten Datei-Uploads.

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

Es bietet auch eine einfache Möglichkeit, Verzeichnisse durchqueren
zugreifen und Bearbeiten von Dateien in ihnen.

    use Pop\File\Dir;

    // Create the Dir object
    $dir = new Dir('../mydir');

    // Loop through the files in the directory
    $files = $dir->getFiles();
    foreach ($files as $file) {
        echo $file;
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
