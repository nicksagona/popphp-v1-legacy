Pop PHP Framework
=================

Documentation : Ftp
-------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø¨Ø±ÙˆØªÙˆÙƒÙˆÙ„ Ù†Ù‚Ù„ Ø§Ù„Ù…Ù„Ù?Ø§Øª ÙŠÙˆÙ?Ø±
Ø§Ù„Ù…Ø¬Ù…Ø¹ API Ù…Ø¬Ø±Ø¯ ÙˆØ¬ÙˆÙ‡ Ø§Ù„Ù…Ù†Ø­Ù‰ Ù„Ù„ØªÙ…Ø¯ÙŠØ¯ Ù„PHP
FTP.

    use Pop\Ftp\Ftp;

    $ftp = new Ftp('ftp.yourserver.com', 'username', 'password');
    $ftp->pasv(true)
        ->chdir('./httpdocs/')
        ->put('test.txt', '../assets/files/test.txt', FTP_ASCII);
    echo 'File Sent!';

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
