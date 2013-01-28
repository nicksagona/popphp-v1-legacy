Pop PHP Framework
=================

Documentation : Ftp
-------------------

Home

Ftp ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€Ð¾Ñ?Ñ‚Ð¾ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚
Ð¾Ð±ÑŠÐµÐºÑ‚Ð½Ð¾-Ð¾Ñ€Ð¸ÐµÐ½Ñ‚Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ñ‹Ð¹ API Ð¾Ð±Ð¾Ð»Ð¾Ñ‡ÐºÐ¸
Ð´Ð»Ñ? FTP Ñ€Ð°Ñ?ÑˆÐ¸Ñ€ÐµÐ½Ð¸Ñ? PHP.

    use Pop\Ftp\Ftp;

    $ftp = new Ftp('ftp.yourserver.com', 'username', 'password');
    $ftp->pasv(true)
        ->chdir('./httpdocs/')
        ->put('test.txt', '../assets/files/test.txt', FTP_ASCII);
    echo 'File Sent!';

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
