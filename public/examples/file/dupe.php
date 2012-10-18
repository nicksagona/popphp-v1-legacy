<?php

require_once '../../bootstrap.php';

use Pop\File\File;

try {
    $filename = File::checkDupe('upload.php');
    echo $filename;
} catch (\Exception $e) {
    echo $e->getMessage();
}

