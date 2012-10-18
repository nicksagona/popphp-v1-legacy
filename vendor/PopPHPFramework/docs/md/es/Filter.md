Pop PHP Framework
=================

Documentation : Filter
----------------------

El componente Filter proporciona algunas funciones útiles para la manipulación de cadenas de filtrado, cifrado y búsqueda de matriz.

<pre>
echo 'Random String: ' . String::random(6, String::ALPHANUM, String::UPPER) . '&lt;br /&gt;&lt;br /&gt;' . PHP_EOL;

$key = md5('Pop PHP Framework');

$encrypted = String::encrypt('Hello World!', $key);
echo 'Encrypted: ' . $encrypted . '&lt;br /&gt;&lt;br /&gt;' . PHP_EOL;

$decrypted = String::decrypt($encrypted, $key);
echo 'Decrypted: ' . $decrypted . '&lt;br /&gt;' . PHP_EOL;
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
