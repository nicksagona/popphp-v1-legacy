Pop PHP Framework
=================

Documentation : Web
-------------------

Home

רכיב האינטרנט הוא אוסף של צורכים מבוססי אינטרנט ופונקציונלי, הפעלות
ניהול כאלה, שרתים, דפדפנים ועוגיות. כמו כן, זה כולל את הפונקציונליות
לאיתור התקנים ניידים, כך שהיישום שלך יכול להגיב בהתאם.

    use Pop\Web\Session;

    $sess = Session::getInstance();
    $sess->username = 'yourname';
    print_r($sess);
    print_r($_SESSION);

    echo $sess->getId();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
