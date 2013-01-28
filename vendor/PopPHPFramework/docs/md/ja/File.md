Pop PHP Framework
=================

Documentation : File
--------------------

Home

Fileã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?ãƒ‡ã‚£ã‚¹ã‚¯ä¸Šã?®ãƒ•ã‚¡ã‚¤ãƒ«ã‚’ç®¡ç?†ã?Šã‚ˆã?³æ“?ä½œã?™ã‚‹ã?Ÿã‚?ã?®ä¾¿åˆ©ã?ªAPIã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚ã?¾ã?Ÿã€?ç°¡å?˜ã?«ãƒ•ã‚¡ã‚¤ãƒ«ã?®ã‚¢ãƒƒãƒ—ãƒ­ãƒ¼ãƒ‰ã‚’ç®¡ç?†ã?™ã‚‹æ©Ÿèƒ½ã‚’æ??ä¾›ã?™ã‚‹ã€‚

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

ã?¾ã?Ÿã€?ãƒ‡ã‚£ãƒ¬ã‚¯ãƒˆãƒªã‚’ãƒˆãƒ©ãƒ?ãƒ¼ã‚¹ã?—ã?¦ã€?ã??ã?®ä¸­ã?«ãƒ•ã‚¡ã‚¤ãƒ«ã?«ã‚¢ã‚¯ã‚»ã‚¹ã?—ã?¦æ“?ä½œã?™ã‚‹ç°¡å?˜ã?ªæ–¹æ³•ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚

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
