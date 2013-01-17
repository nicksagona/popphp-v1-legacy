Pop PHP Framework
=================

Documentation : File
--------------------

Il componente File API fornisce un utile strumento per gestire e manipolare i file su disco. Esso prevede inoltre la funzionalità di gestire facilmente il caricamento di file.

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
<pre>
use Pop\File\Dir;

// Create the Dir object
$dir = new Dir('../mydir');

// Loop through the files in the directory
$files = $dir-&gt;getFiles();
foreach ($files as $file) {
    echo $file;
}
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
