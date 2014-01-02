Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

Компонент Validator просто обеспечивает проверку функциональности для
различных случаев использования, например, проверку или нет номер имеет
определенное значение или строка буквенно-цифровой. Более продвинутые
проверяющие также доступны, такие как проверка электронной почты и
IP-адрес или номер кредитной карты. И, если то, что вам нужно, это не
доступно, компонент может быть легко расширен.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
