Pop PHP Framework
=================

Documentation : File
--------------------

Home

El componente de archivos proporciona una API Ãºtil para gestionar y
manipular los archivos en el disco. TambiÃ©n proporciona la
funcionalidad para administrar fÃ¡cilmente la carga de archivos.

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

TambiÃ©n proporciona una manera fÃ¡cil de recorrer directorios y acceder
y manipular los archivos en su interior.

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
