Pop PHP Framework
=================

Documentation : Version
-----------------------

O componente Versão simplesmente fornece a capacidade de determinar qual versão do Pop atual você tem, e que o mais recente disponível é. Além disso, este componente é usado pelo componente CLI para realizar a verificação de dependência.

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
