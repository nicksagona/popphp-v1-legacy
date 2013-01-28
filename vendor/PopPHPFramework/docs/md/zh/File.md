Pop PHP Framework
=================

Documentation : File
--------------------

Home

æ–‡ä»¶ç»„ä»¶æ??ä¾›äº†ä¸€ä¸ªæœ‰ç”¨çš„APIæ?¥ç®¡ç?†å’Œæ“?ä½œç£?ç›˜ä¸Šçš„æ–‡ä»¶ã€‚å®ƒè¿˜æ??ä¾›äº†åŠŸèƒ½ï¼Œè½»æ?¾ç®¡ç?†æ–‡ä»¶ä¸Šä¼
ã€‚

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

å®ƒè¿˜æ??ä¾›äº†ä¸€ä¸ªç®€å?•çš„æ–¹æ³•æ?¥é??åŽ†ç›®å½•ï¼Œåœ¨å…¶ä¸­è®¿é—®å’Œæ“?ä½œæ–‡ä»¶ã€‚

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
