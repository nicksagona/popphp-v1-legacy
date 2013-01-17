Pop PHP Framework
=================

Documentation : Version
-----------------------

バージョンのコンポーネントは、単にあなたが現在持っているポップのバージョンを判別する機能を提供し、どのような利用可能な最新です。また、このコンポーネントは、依存関係チェックを実行するためのCLIコンポーネントで使用されます。

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
