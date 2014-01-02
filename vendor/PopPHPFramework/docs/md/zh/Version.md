Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

版本组件仅仅提供了能力，以确定哪个版本的流行你目前有什么最新的是。此外，此组件被用于由CLI组件来执行的依赖检查。

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
