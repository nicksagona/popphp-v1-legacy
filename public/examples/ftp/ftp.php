<?php

require_once '../../bootstrap.php';

use Pop\Ftp\Ftp;

try {
    $ftp = new Ftp('ftp.yourserver.com', 'username', 'password');
    $ftp->pasv(true)
        ->chdir('./httpdocs/')
        ->put('test.pdf', '../assets/files/test.pdf', FTP_BINARY);
    echo 'File Sent!';
} catch (\Exception $e) {
    echo $e->getMessage();
}

