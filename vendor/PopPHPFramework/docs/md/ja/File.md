Pop PHP Framework
=================

Documentation : File
--------------------

Home

Fileコンポーネントは、ディスク上のファイルを管理および操作するための便利なAPIを提供します。また、簡単にファイルのアップロードを管理する機能を提供する。

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

また、ディレクトリをトラバースして、その中にファイルにアクセスして操作する簡単な方法を提供します。

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
