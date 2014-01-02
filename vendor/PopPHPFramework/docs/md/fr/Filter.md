Pop PHP Framework
=================

Documentation : Filter
----------------------

Home

La composante Filter offre des fonctionnalités utiles pour la
manipulation de chaînes de filtrage, de chiffrement et de recherche
ensemble.

    use Pop\Filter\String;

    echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '<br /><br />' . PHP_EOL;

    $key = md5('Pop PHP Framework');

    $encrypted = String::encrypt('Hello World!', $key);
    echo 'Encrypted: ' . $encrypted . '<br /><br />' . PHP_EOL;

    $decrypted = String::decrypt($encrypted, $key);
    echo 'Decrypted: ' . $decrypted . '<br />' . PHP_EOL;

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
