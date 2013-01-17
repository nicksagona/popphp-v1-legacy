Pop PHP Framework
=================

Documentation : Version
-----------------------

Версия компонент просто дает возможность определить, какую версию вы Поп текущих есть, и то, что последняя доступна. Кроме того, этот компонент используется компонентом CLI для выполнения проверки зависимостей.

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
