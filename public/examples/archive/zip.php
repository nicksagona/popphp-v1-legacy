<?php

require_once '../../bootstrap.php';

use Pop\Archive\Archive;

try {
    // Create a new ZIP archive and add some files to it
    // (Make sure the '../tmp' folder is writable)
    $archive = new Archive('../tmp/test.zip');
    $archive->addFiles('../assets');

    // Display the new archive file size
    echo $archive->basename . ': compressed file size => ' . $archive->getSize() . PHP_EOL;
    echo 'Done.' . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
?>