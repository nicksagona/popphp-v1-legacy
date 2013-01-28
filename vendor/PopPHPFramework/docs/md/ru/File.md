Pop PHP Framework
=================

Documentation : File
--------------------

Home

Ð¤Ð°Ð¹Ð» ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚ Ð¿Ð¾Ð»ÐµÐ·Ð½Ñ‹Ðµ
API Ð´Ð»Ñ? ÑƒÐ¿Ñ€Ð°Ð²Ð»ÐµÐ½Ð¸Ñ? Ð¸ Ñ€Ð°Ð±Ð¾Ñ‚Ñ‹ Ñ? Ñ„Ð°Ð¹Ð»Ð°Ð¼Ð¸ Ð½Ð°
Ð´Ð¸Ñ?ÐºÐµ. ÐžÐ½Ð° Ñ‚Ð°ÐºÐ¶Ðµ Ð¾Ð±ÐµÑ?Ð¿ÐµÑ‡Ð¸Ð²Ð°ÐµÑ‚
Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð¾Ñ?Ñ‚ÑŒ Ð»ÐµÐ³ÐºÐ¾ ÑƒÐ¿Ñ€Ð°Ð²Ð»Ñ?Ñ‚ÑŒ
Ð·Ð°Ð³Ñ€ÑƒÐ·ÐºÐ¸ Ñ„Ð°Ð¹Ð»Ð¾Ð².

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

ÐžÐ½ Ñ‚Ð°ÐºÐ¶Ðµ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚ Ð»ÐµÐ³ÐºÐ¸Ð¹ Ñ?Ð¿Ð¾Ñ?Ð¾Ð±
Ð´Ð»Ñ? Ð¾Ð±Ñ…Ð¾Ð´Ð° ÐºÐ°Ñ‚Ð°Ð»Ð¾Ð³Ð¾Ð² Ð¸ Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿Ð° Ð¸
ÑƒÐ¿Ñ€Ð°Ð²Ð»ÐµÐ½Ð¸Ñ? Ñ„Ð°Ð¹Ð»Ð°Ð¼Ð¸ Ð²Ð½ÑƒÑ‚Ñ€Ð¸ Ð½Ð¸Ñ….

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
