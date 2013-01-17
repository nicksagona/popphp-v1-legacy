Pop PHP Framework
=================

Documentation : Version
-----------------------

Die Version Komponente bietet die Möglichkeit, einfach zu bestimmen, welche Version von Pop Sie haben Strom, und was die neuesten zur Verfügung steht. Auch wird diese Komponente durch die CLI-Komponente verwendet, um die Abhängigkeit-Prüfung durchzuführen.

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
