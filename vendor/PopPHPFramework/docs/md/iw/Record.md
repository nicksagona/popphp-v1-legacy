Pop PHP Framework
=================

Documentation : Record
----------------------

המרכיב הקובע, כפי שמתואר סקירה תיעוד, הוא "הכלאה" של מיני בין הקלט הפעיל נתונים מהטבלה דפוסי השער. באמצעות ה-API סטנדרטי, היא יכולה לספק גישה לשורה רשומה בודדת או בתוך טבלת מסד נתונים, או מספר שורות או רשומות בבת אחת. הגישה הנפוצה ביותר היא לכתוב בכיתה הילד מרחיב את המעמד שיא המייצג טבלה במסד הנתונים. שם בכיתה ילד צריך להיות שם הטבלה. פשוט על ידי יצירת

<pre>
use Pop\Record\Record;

class Users extends Record { }
</pre>

יצירת המעמד שיש לו את כל הפונקציונליות של רכיב הקלטה מובנה ומעמד יודע את השם של הטבלה במסד הנתונים לשאילתה של שם המחלקה. כך, למשל, מתרגם "של משתמשים אל תוך ג` המשתמשים `או מתרגם של DbUsers של אל ג` db_users `(CamelCase מומר אוטומטית lower_case_underscore). משם, ניתן לכוונן את מעמד הילד המייצג את הטבלה עם תכונות ברמה שונים כגון :

<pre>
// Table prefix, if applicable
protected $prefix = null;

// Primary ID, if applicable, defaults to 'id'
protected $primaryId = 'id';

// Whether the table is auto-incrementing or not
protected $auto = true;

// Whether to use prepared statements or not, defaults to true
protected $usePrepared = true;
</pre>

משם, השימוש הבסיסי הוא כדלקמן:

<pre>
use Users;

// Get a single user
$user = Users::findById(1001);
echo $user->name;
echo $user->email;

// Get multiple users
$users = Users::findAll('last_name ASC');
foreach ($users->rows as $user) {
    echo $user->name;
    echo $user->email;
}
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
