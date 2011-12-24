<?php

require_once '../../bootstrap.php';

use Pop\Ftp\Ftp;

try {
    $ftp = new Ftp('ftp.yourserver.com', 'user', 'pass');
    $ftp->chdir('./httpdocs/');
    $ftp->put('test.txt', '../assets/files/test.txt', FTP_ASCII);
    echo 'File Sent!' . PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage();
}

?>