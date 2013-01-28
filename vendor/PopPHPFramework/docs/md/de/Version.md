Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

Die Version Komponente stellt lediglich die MÃ¶glichkeit zu bestimmen,
welche Version von Pop Sie Strom haben, und was die neuesten zur
VerfÃ¼gung steht. Auch diese Komponente durch die CLI-Komponente
verwendet, um die AbhÃ¤ngigkeit-PrÃ¼fung durchzufÃ¼hren.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
