Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

El componente Version simplemente proporciona la capacidad para
determinar qué versión del pop actual que tenemos, y lo que es el último
disponible. Además, este componente se utiliza el componente de CLI para
realizar la dependencia de verificación.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
