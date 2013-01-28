Pop PHP Framework
=================

Documentation : Filter
----------------------

Home

å­—ç¬¦ä¸²å¤„ç?†ï¼ŒåŠ
å¯†å’Œé˜µåˆ—æ?œç´¢ç­›é€‰å™¨ç»„ä»¶æ??ä¾›äº†ä¸€äº›æœ‰ç”¨çš„è¿‡æ»¤åŠŸèƒ½ã€‚

    use Pop\Filter\String;

    echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '<br /><br />' . PHP_EOL;

    $key = md5('Pop PHP Framework');

    $encrypted = String::encrypt('Hello World!', $key);
    echo 'Encrypted: ' . $encrypted . '<br /><br />' . PHP_EOL;

    $decrypted = String::decrypt($encrypted, $key);
    echo 'Decrypted: ' . $decrypted . '<br />' . PHP_EOL;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
