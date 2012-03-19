Pop PHP Framework
=================

Documentation : Version
-----------------------

מרכיב גרסה פשוט מספק את היכולת לקבוע איזו גירסה של חלונות יש לך הנוכחית, ומה זמין האחרונה היא. כמו כן, רכיב זה משמש מרכיב CLI כדי לבצע את התלות-הסימון.

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
