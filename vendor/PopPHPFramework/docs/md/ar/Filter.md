Pop PHP Framework
=================

Documentation : Filter
----------------------

Home

ÙŠÙˆÙ?Ø± Ø¹Ù†ØµØ± ØªØµÙ?ÙŠØ© Ø¨Ø¹Ø¶ Ø§Ù„ÙˆØ¸Ø§Ø¦Ù? Ø§Ù„Ù…Ù?ÙŠØ¯Ø©
ØªØµÙ?ÙŠØ© Ù„Ù„ØªØ´Ù?ÙŠØ± Ø³Ù„Ø³Ù„Ø©ØŒ ÙˆØ§Ù„ØªÙ„Ø§Ø¹Ø¨ ÙˆØ§Ù„Ø¨Ø­Ø«
Ø§Ù„ØµÙ?ÙŠÙ?.

    use Pop\Filter\String;

    echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '<br /><br />' . PHP_EOL;

    $key = md5('Pop PHP Framework');

    $encrypted = String::encrypt('Hello World!', $key);
    echo 'Encrypted: ' . $encrypted . '<br /><br />' . PHP_EOL;

    $decrypted = String::decrypt($encrypted, $key);
    echo 'Decrypted: ' . $decrypted . '<br />' . PHP_EOL;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
