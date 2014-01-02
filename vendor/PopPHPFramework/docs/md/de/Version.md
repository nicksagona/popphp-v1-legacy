Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

Die Version Komponente stellt lediglich die Möglichkeit zu bestimmen,
welche Version von Pop Sie Strom haben, und was die neuesten zur
Verfügung steht. Auch diese Komponente durch die CLI-Komponente
verwendet, um die Abhängigkeit-Prüfung durchzuführen.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
