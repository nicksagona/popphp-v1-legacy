Pop PHP Framework
=================

Documentation : Ftp
-------------------

El componente del ftp simplemente proporciona una capa API orientada a objetos a la extensión ftp de PHP.

<pre>
use Pop\Ftp\Ftp;

$ftp = new Ftp('ftp.yourserver.com', 'username', 'password');
$ftp->pasv(true)
    ->chdir('./httpdocs/')
    ->put('test.txt', '../assets/files/test.txt', FTP_ASCII);
echo 'File Sent!';
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
