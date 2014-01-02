Pop PHP Framework
=================

Documentation : File
--------------------

Home

מרכיב הקובץ מספק API נוח לניהול ולטפל בקבצים בדיסק. הוא גם מספק את
הפונקציונליות כדי לנהל בקלות העלאת קבצים.

    use Pop\File\File;

    // Create a new file and write to it.
    $file = new File('new-file.txt');
    $file->write('Some text to the file.')
         ->save();

    // Upload a file from a multipart POST form.
    $upload = File::upload($_FILES['upload_file']['tmp_name'], '../uploads/' . $_FILES['upload_file']['name']);
    echo 'File uploaded.';

הוא גם מספק דרך קלה לעבור ספריות ולגשת ולטפל בקבצים בתוכם.

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
