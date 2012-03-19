Pop PHP Framework
=================

Documentation : File
--------------------

Το στοιχείο αρχείου παρέχει ένα χρήσιμο API για να διαχειριστείτε και να χειριστεί τα αρχεία στο δίσκο. Παρέχει επίσης τη λειτουργικότητα να διαχειρίζεστε εύκολα τις προσθήκες αρχείο.


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
