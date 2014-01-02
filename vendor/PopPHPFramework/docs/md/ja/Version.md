Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

バージョン·コンポーネントは、単にあなたが現在持っているポップのバージョンを判別する能力を提供し、どのような利用可能な最新のです。また、このコンポーネントは、依存性チェックを実行するためのCLIコンポーネントによって使用されます。

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
