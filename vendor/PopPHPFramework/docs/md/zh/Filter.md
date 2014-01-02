Pop PHP Framework
=================

Documentation : Filter
----------------------

Home

字符串处理，加密和阵列搜索筛选器组件提供了一些有用的过滤功能。

    use Pop\Filter\String;

    echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '<br /><br />' . PHP_EOL;

    $key = md5('Pop PHP Framework');

    $encrypted = String::encrypt('Hello World!', $key);
    echo 'Encrypted: ' . $encrypted . '<br /><br />' . PHP_EOL;

    $decrypted = String::decrypt($encrypted, $key);
    echo 'Decrypted: ' . $decrypted . '<br />' . PHP_EOL;

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
