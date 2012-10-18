Pop PHP Framework
=================

Documentation : Filter
----------------------

O componente de filtro oferece algumas funcionalidades úteis filtragem para criptografia corda, manipulação e pesquisa de matriz.

<pre>
echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '&lt;br /&gt;&lt;br /&gt;' . PHP_EOL;

$key = md5('Pop PHP Framework');

$encrypted = String::encrypt('Hello World!', $key);
echo 'Encrypted: ' . $encrypted . '&lt;br /&gt;&lt;br /&gt;' . PHP_EOL;

$decrypted = String::decrypt($encrypted, $key);
echo 'Decrypted: ' . $decrypted . '&lt;br /&gt;' . PHP_EOL;
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
