Pop PHP Framework
=================

Documentation : File
--------------------

El componente de archivos proporciona una API útil para gestionar y manipular los archivos en el disco. También proporciona la funcionalidad para administrar fácilmente la carga de archivos.

<pre>
use Pop\File\File;

// Create a new file and write to it.
$file = new File('new-file.txt');
$file->write('Some text to the file.')
     ->save();

// Upload a file from a multipart POST form.
$upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
echo 'File uploaded.';
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
