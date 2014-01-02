Pop PHP Framework
=================

Documentation : Version
-----------------------

Home

מרכיב הגרסה פשוט מספק את היכולת לקבוע איזו גרסה של פופ יש לך נוכחי, ומה
הזמין האחרון הוא. כמו כן, רכיב זה משמש מרכיב CLI לבצע את התלות במכונה.

    use Pop\Version;

    echo Version::getVersion();

    if (Version::compareVersion(1.0) == 1) {
        echo 'The current version is less than 1.0';
    } else {
        echo 'The current version is greater than or equal to 1.0';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
