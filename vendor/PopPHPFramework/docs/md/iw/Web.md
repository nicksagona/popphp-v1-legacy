Pop PHP Framework
=================

Documentation : Web
-------------------

רכיב האינטרנט הוא אוסף של מבוססי אינטרנט לצרכים ופונקציונליות, הפעלות ניהול כאלה, שרתים, דפדפנים ועוגיות. כמו כן, היא כוללת את פונקציונליות לאיתור התקנים ניידים, כך שהיישום יוכל להגיב בהתאם.

<pre>
use Pop\Web\Session;

$sess = Session::getInstance();
$sess->username = 'yourname';
print_r($sess);
print_r($_SESSION);

echo $sess->getId();
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
