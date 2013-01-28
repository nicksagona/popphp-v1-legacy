Pop PHP Framework
=================

Documentation : Filter
----------------------

Home

Ð¤Ð¸Ð»ÑŒÑ‚Ñ€ ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚
Ð½ÐµÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ðµ Ð¿Ð¾Ð»ÐµÐ·Ð½Ñ‹Ðµ Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¸ Ñ„Ð¸Ð»ÑŒÑ‚Ñ€Ð°Ñ†Ð¸Ð¸
Ð´Ð»Ñ? Ñ€Ð°Ð±Ð¾Ñ‚Ñ‹ Ñ?Ð¾ Ñ?Ñ‚Ñ€Ð¾ÐºÐ°Ð¼Ð¸, ÑˆÐ¸Ñ„Ñ€Ð¾Ð²Ð°Ð½Ð¸Ðµ Ð¸
Ð¼Ð°Ñ?Ñ?Ð¸Ð² Ð¿Ð¾Ð¸Ñ?ÐºÐ°.

    use Pop\Filter\String;

    echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '<br /><br />' . PHP_EOL;

    $key = md5('Pop PHP Framework');

    $encrypted = String::encrypt('Hello World!', $key);
    echo 'Encrypted: ' . $encrypted . '<br /><br />' . PHP_EOL;

    $decrypted = String::decrypt($encrypted, $key);
    echo 'Decrypted: ' . $decrypted . '<br />' . PHP_EOL;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
