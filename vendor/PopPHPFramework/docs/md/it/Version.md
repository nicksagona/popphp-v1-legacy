Pop PHP Framework
=================

Documentation : Version
-----------------------

Il componente Version fornisce semplicemente la capacità di determinare quale versione di Pop che hanno in corso, e che l'ultima disponibile è. Inoltre, questo componente è utilizzato dal componente CLI per eseguire la dipendenza-controllo.

<pre>
use Pop\Version;

echo Version::getVersion();

if (Version::compareVersion(1.0) == 1) {
    echo 'The current version is less than 1.0';
} else {
    echo 'The current version is greater than or equal to 1.0';
}
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
