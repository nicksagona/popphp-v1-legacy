Pop PHP Framework
=================

Documentation : File
--------------------

文件组件提供了一个有用的API来管理和操作磁盘上的文件。它还提供了功能，可以轻松地管理文件上传。


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
