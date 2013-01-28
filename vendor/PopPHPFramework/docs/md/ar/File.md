Pop PHP Framework
=================

Documentation : File
--------------------

Home

Ù…Ù„Ù? Ù…ÙƒÙˆÙ† ÙŠÙˆÙ?Ø± API Ù…Ù?ÙŠØ¯Ø© Ù„Ø¥Ø¯Ø§Ø±Ø© ÙˆØ§Ù„ØªØ¹Ø§Ù…Ù„
Ù…Ø¹ Ø§Ù„Ù…Ù„Ù?Ø§Øª Ø§Ù„Ù…ÙˆØ¬ÙˆØ¯Ø© Ø¹Ù„Ù‰ Ø§Ù„Ù‚Ø±Øµ. ÙƒÙ…Ø§ ÙŠÙˆÙ?Ø±
ÙˆØ¸Ø§Ø¦Ù? Ù„Ø¥Ø¯Ø§Ø±Ø© Ø¨Ø³Ù‡ÙˆÙ„Ø© ØªØ­Ù…ÙŠÙ„ Ø§Ù„Ù…Ù„Ù?.

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

ÙƒÙ…Ø§ ÙŠÙˆÙ?Ø± Ø·Ø±ÙŠÙ‚Ø© Ø³Ù‡Ù„Ø© Ù„Ø§Ø¬ØªÙŠØ§Ø² Ø§Ù„Ø¯Ù„Ø§Ø¦Ù„
ÙˆØ§Ù„ÙˆØµÙˆÙ„ ÙˆØ§Ù„ØªØ¹Ø§Ù…Ù„ Ù…Ø¹ Ù…Ù„Ù?Ø§Øª Ø¯Ø§Ø®Ù„Ù‡Ø§.

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
