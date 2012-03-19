Pop PHP Framework
=================

Documentation : Version
-----------------------

版本组件简单地提供的能力，以确定流行的版本，你目前有最新可用的是什么。此外，此组件使用的CLI组件进行依赖检查。

<pre>
use Pop\Version;

echo Version::getVersion();

if (Version::compareVersion(1.0) == 1) {
    echo 'The current version is less than 1.0';
} else {
    echo 'The current version is greater than or equal to 1.0';
}
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
