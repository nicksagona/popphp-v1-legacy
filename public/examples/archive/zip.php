<?php

require_once '../../bootstrap.php';

use Pop\Archive\Archive;

// Create a new ZIP archive and add some files to it
// (Make sure the '../tmp' folder is writable)
$archive = new Archive('../tmp/test.zip');
$archive->addFiles('../assets');

// Display the new archive file size
echo '<strong>' . $archive->basename . '</strong>: compressed file size: ' . $archive->getSize() . '<br />' . PHP_EOL;
echo 'Done.';

?>
