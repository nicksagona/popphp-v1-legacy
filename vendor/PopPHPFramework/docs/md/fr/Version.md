Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

La composante des versions fournit simplement la capacité de déterminer
quelle version de la pop actuelle que vous avez, et quelle est la
dernière disponible est. En outre, ce composant est utilisé par le
composant CLI pour effectuer la dépendance chèque.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
