<?php

require_once '../../bootstrap.php';

use Pop\File\File;

try {
    $file = File::upload($_FILES['upload_file']['tmp_name'], '../tmp/' . $_FILES['upload_file']['name']);
    echo 'The file has been successfully uploaded.<br />' . PHP_EOL;
    print_r($file);
} catch (\Exception $e) {
    echo $e->getMessage();
}

