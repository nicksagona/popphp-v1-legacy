Pop PHP Framework
=================

Documentation : File
--------------------

Home

文件组件提供了一个有用的API来管理和操作磁盘上的文件。它还提供了功能，轻松管理文件上传。

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

它还提供了一个简单的方法来遍历目录，在其中访问和操作文件。

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
