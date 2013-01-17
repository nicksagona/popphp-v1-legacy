Pop PHP Framework
=================

Documentation : Version
-----------------------

El componente de la versión sólo proporciona la capacidad para determinar qué versión del pop actual que tienen, y lo que es la última disponible. Además, este componente es utilizado por el componente CLI para realizar la dependencia de verificación.

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
