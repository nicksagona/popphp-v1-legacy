Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

O componente VersÃ£o simplesmente fornece a capacidade de determinar
qual versÃ£o do Pop atual vocÃª tem, e que o mais recente disponÃ­vel
Ã©. AlÃ©m disso, este componente Ã© utilizado pelo componente CLI para
realizar a verificaÃ§Ã£o de dependÃªncia.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
