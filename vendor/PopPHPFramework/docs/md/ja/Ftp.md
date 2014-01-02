Pop PHP Framework
=================

Documentation : Ftp
-------------------

Home

FTPコンポーネントは、単にPHPのftp拡張機能へのオブジェクト指向APIのラッパーを提供します。

    use Pop\Ftp\Ftp;

    $ftp = new Ftp('ftp.yourserver.com', 'username', 'password');
    $ftp->pasv(true)
        ->chdir('./httpdocs/')
        ->put('test.txt', '../assets/files/test.txt', FTP_ASCII);
    echo 'File Sent!';

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
