<?php

require_once '../../bootstrap.php';

use Pop\Archive\Archive;

// Create a new TAR archive and add some files to it
// (Make sure the '../tmp' folder is writable)
$archive = new Archive('../tmp/test.tar');
$archive->addFiles('../assets');

// Display the new archive file size
echo '<strong>' . $archive->basename . '</strong>: file size: ' . $archive->getSize() . '<br />' . PHP_EOL;

// Compress the archive (Gzip by default)
$archive->compress();

// Display the newly compressed archive file size
echo '<strong>' . $archive->basename . '</strong>: compressed file size: ' . $archive->getSize() . '<br /><br />' . PHP_EOL;
echo 'Done.';

?>
