Pop PHP Framework
=================

Documentation : Filter
----------------------

Home

ãƒ•ã‚£ãƒ«ã‚¿ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?æ–‡å­—åˆ—æ“?ä½œã€?æš—å?·åŒ–ã?Šã‚ˆã?³é…?åˆ—æ¤œç´¢ã?®ã?Ÿã‚?ã?®ã?„ã??ã?¤ã?‹ã?®æœ‰ç”¨ã?ªãƒ•ã‚£ãƒ«ã‚¿ãƒªãƒ³ã‚°æ©Ÿèƒ½ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚

    use Pop\Filter\String;

    echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '<br /><br />' . PHP_EOL;

    $key = md5('Pop PHP Framework');

    $encrypted = String::encrypt('Hello World!', $key);
    echo 'Encrypted: ' . $encrypted . '<br /><br />' . PHP_EOL;

    $decrypted = String::decrypt($encrypted, $key);
    echo 'Decrypted: ' . $decrypted . '<br />' . PHP_EOL;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
