Pop PHP Framework
=================

Documentation : Loader
----------------------

Home

מרכיב Loader הוא כנראה המרכיב הבסיסי ביותר, אך החשוב ביותר של מסגרת PHP
פופ. זה המרכיב שמניע את היכולות של מסגרת autoloading, והיישום שלך יכול
בקלות להיות רשום בautoloader לטעון השיעורים שלך. זה לבדו מחליף את כל
ההצהרות האלה ישנות כוללות אתה רגיל יש בכל המקום. עכשיו, כל מה שאתה צריך
זה אחד דורש הצהרה של 'bootstrap.php' בראש ואתה טוב ללכת. כברירת מחדל,
הקובץ מכיל bootstrap התייחסות הנדרשת לכיתת autoloader של המסגרת ולאחר
מכן טוען את זה. בתוך קובץ bootstrap, אתה יכול בקלות לבצע פעולות טעינה
אחרות, כגון רישום מרחב השמות של היישום שלך עם הטעינה אוטומטית, או טעינת
קובץ classmap כדי להקטין את זמן טעינה.

    // Instantiate the autoloader object
    $autoloader = new Pop\Loader\Autoloader();
    $autoloader->splAutoloadRegister();

    $autoloader->register('YourLib', '../vendor/YourLib/src');
    $autoloader->loadClassMap('../vendor/YourLib/classmap.php');

ואם אתה צריך קובץ classmap נוצר, רכיב Loader יש הפונקציונלי קל כדי ליצור
קובץ classmap גם לך.

    // Generate a classmap file
    Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
