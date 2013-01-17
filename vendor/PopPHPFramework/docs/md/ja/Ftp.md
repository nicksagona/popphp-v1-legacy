Pop PHP Framework
=================

Documentation : Ftp
-------------------

FTPコンポーネントは、単にPHPのftp拡張機能のオブジェクト指向のAPIのラッパーを提供します。

<pre>
use Pop\Ftp\Ftp;

$ftp = new Ftp('ftp.yourserver.com', 'username', 'password');
$ftp->pasv(true)
    ->chdir('./httpdocs/')
    ->put('test.txt', '../assets/files/test.txt', FTP_ASCII);
echo 'File Sent!';
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
