Pop PHP Framework
=================

Documentation : File
--------------------

Home

Î¤Î¿ ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î¿ Î±Ï?Ï‡ÎµÎ¯Î¿Ï… Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Î­Î½Î±
Ï‡Ï?Î®ÏƒÎ¹Î¼Î¿ API Î³Î¹Î± Ï„Î· Î´Î¹Î±Ï‡ÎµÎ¯Ï?Î¹ÏƒÎ· ÎºÎ±Î¹ Î½Î±
Ï‡ÎµÎ¹Ï?Î¹ÏƒÏ„ÎµÎ¯Ï„Îµ Î±Ï?Ï‡ÎµÎ¯Î± ÏƒÏ„Î¿ Î´Î¯ÏƒÎºÎ¿. Î Î±Ï?Î­Ï‡ÎµÎ¹
ÎµÏ€Î¯ÏƒÎ·Ï‚ Ï„Î· Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¹ÎºÏŒÏ„Î·Ï„Î± Î½Î±
Î´Î¹Î±Ï‡ÎµÎ¹Ï?Î¹ÏƒÏ„ÎµÎ¯Ï„Îµ ÎµÏ?ÎºÎ¿Î»Î± upload Î±Ï?Ï‡ÎµÎ¯Ï‰Î½.

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

Î•Ï€Î¯ÏƒÎ·Ï‚, Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Î­Î½Î±Î½ ÎµÏ?ÎºÎ¿Î»Î¿ Ï„Ï?ÏŒÏ€Î¿ Î³Î¹Î±
Î½Î± Î´Î¹Î±ÏƒÏ‡Î¯ÏƒÎµÎ¹ ÎºÎ±Ï„Î±Î»ÏŒÎ³Î¿Ï…Ï‚ ÎºÎ±Î¹ Î½Î± Î­Ï‡Î¿Ï…Î½
Ï€Ï?ÏŒÏƒÎ²Î±ÏƒÎ· ÎºÎ±Î¹ Î½Î± Ï‡ÎµÎ¹Ï?Î¹ÏƒÏ„ÎµÎ¯ Ï„Î± Î±Ï?Ï‡ÎµÎ¯Î± ÏƒÏ„Î¿
ÎµÏƒÏ‰Ï„ÎµÏ?Î¹ÎºÏŒ Ï„Î¿Ï…Ï‚.

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
