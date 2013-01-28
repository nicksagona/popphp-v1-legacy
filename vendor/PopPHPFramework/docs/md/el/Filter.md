Pop PHP Framework
=================

Documentation : Filter
----------------------

Home

Î¤Î¿ Î¦Î¯Î»Ï„Ï?Î¿ ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ Ï€Î±Ï?Î­Ï‡ÎµÎ¹ ÎºÎ¬Ï€Î¿Î¹ÎµÏ‚
Ï‡Ï?Î®ÏƒÎ¹Î¼ÎµÏ‚ Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¯ÎµÏ‚ Ï†Î¹Î»Ï„Ï?Î±Ï?Î¯ÏƒÎ¼Î±Ï„Î¿Ï‚
Î³Î¹Î± ÏƒÎµÎ¹Ï?Î¬ Ï‡ÎµÎ¹Ï?Î±Î³ÏŽÎ³Î·ÏƒÎ·, Ï„Î·Î½
ÎºÏ?Ï…Ï€Ï„Î¿Î³Ï?Î¬Ï†Î·ÏƒÎ· ÎºÎ±Î¹ Ï„Î·Î½ Î±Î½Î±Î¶Î®Ï„Î·ÏƒÎ·
Ï€Î¯Î½Î±ÎºÎ±.

    use Pop\Filter\String;

    echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '<br /><br />' . PHP_EOL;

    $key = md5('Pop PHP Framework');

    $encrypted = String::encrypt('Hello World!', $key);
    echo 'Encrypted: ' . $encrypted . '<br /><br />' . PHP_EOL;

    $decrypted = String::decrypt($encrypted, $key);
    echo 'Decrypted: ' . $decrypted . '<br />' . PHP_EOL;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
