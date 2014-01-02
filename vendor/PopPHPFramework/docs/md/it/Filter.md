Pop PHP Framework
=================

Documentation : Filter
----------------------

Home

Il componente Filtro fornisce alcune utili funzionalità di filtraggio
per la manipolazione di stringhe, la crittografia e la ricerca di
matrice.

    use Pop\Filter\String;

    echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '<br /><br />' . PHP_EOL;

    $key = md5('Pop PHP Framework');

    $encrypted = String::encrypt('Hello World!', $key);
    echo 'Encrypted: ' . $encrypted . '<br /><br />' . PHP_EOL;

    $decrypted = String::decrypt($encrypted, $key);
    echo 'Decrypted: ' . $decrypted . '<br />' . PHP_EOL;

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
