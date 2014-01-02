Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

Il componente versione fornisce solo la capacità di determinare quale
versione di Pop che hanno in corso, e che è l'ultima disponibile.
Inoltre, il componente viene usato dal componente CLI per eseguire la
dipendenza-controllo.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
