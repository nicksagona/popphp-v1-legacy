Pop PHP Framework
=================

Documentation : Loader
----------------------

מרכיב Loader הוא כנראה מרכיב בסיסי ביותר, אך החשוב ביותר של המסגרת PHP פופ. זה מרכיב שמניע יכולות autoloading של מסגרת, ויישום שלך יכול בקלות להיות רשומים AUTOLOADER לטעון כיתות משלך. זה במו מחליף את כל ההצהרות הישנות כוללות פעם היה לך בכל מקום. עכשיו, כל מה שאתה צריך הוא אחד דורשים הצהרה של "bootstrap.php" בראש ואתה טוב ללכת. כברירת מחדל, קובץ bootstrap מכיל התייחסות לשיעור הנדרש AUTOLOADER של המסגרת ולאחר מכן טוען את זה. בתוך הקובץ bootstrap, אתה יכול בקלות לבצע פעולות טעינה אחרות, כגון רישום מרחב שם היישום שלך עם AUTOLOADER, או טוען קובץ classmap כדי להקטין את זמן הטעינה.

<pre>
// Instantiate the autoloader object
$autoloader = new Pop\Loader\Autoloader();
$autoloader->splAutoloadRegister();

$autoloader->register('YourLib', '../vendor/YourLib/src');
$autoloader->loadClassMap('../vendor/YourLib/classmap.php');
</pre>

ואם אתה צריך קובץ classmap שנוצר, המרכיב Loader יש פונקציונליות בקלות ליצור קובץ classmap גם לך.

<pre>
// Generate a classmap file
Pop\Loader\Classmap::generate('your/src/folder', 'your/src/folder/classmap.php');
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
