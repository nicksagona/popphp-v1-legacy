Pop PHP Framework
=================

Documentation : File
--------------------

ファイルコンポーネントは、ディスク上のファイルを管理および操作するための有用なAPIを提供します。また、簡単にファイルのアップロードを管理する機能を提供します。

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
