Pop PHP Framework
=================

Documentation : Ftp
-------------------

Home

Î— Ftp ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Î±Ï€Î»Î¬ Î­Î½Î± object-oriented
Ï€ÎµÏ?Î¹Ï„Ï?Î»Î¹Î³Î¼Î± API Î³Î¹Î± Ï„Î·Î½ ÎµÏ€Î­ÎºÏ„Î±ÏƒÎ· Ï„Î·Ï‚ PHP
FTP.

    use Pop\Ftp\Ftp;

    $ftp = new Ftp('ftp.yourserver.com', 'username', 'password');
    $ftp->pasv(true)
        ->chdir('./httpdocs/')
        ->put('test.txt', '../assets/files/test.txt', FTP_ASCII);
    echo 'File Sent!';

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
