Pop PHP Framework
=================

Documentation : Ftp
-------------------

Home

FTPã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?å?˜ã?«PHPã?®ftpæ‹¡å¼µæ©Ÿèƒ½ã?¸ã?®ã‚ªãƒ–ã‚¸ã‚§ã‚¯ãƒˆæŒ‡å?‘APIã?®ãƒ©ãƒƒãƒ‘ãƒ¼ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚

    use Pop\Ftp\Ftp;

    $ftp = new Ftp('ftp.yourserver.com', 'username', 'password');
    $ftp->pasv(true)
        ->chdir('./httpdocs/')
        ->put('test.txt', '../assets/files/test.txt', FTP_ASCII);
    echo 'File Sent!';

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
