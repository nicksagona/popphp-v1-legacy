Pop PHP Framework
=================

Documentation : Record
----------------------

Home

המרכיב הקובע, כפי שמתואר בסקירת התיעוד, הוא "היברידי" של מיני בין הרשומה
הפעילה ודפוסי Gateway נתוני טבלה. באמצעות API סטנדרטי, היא יכולה לספק
גישה לשורה או רשומה בודדה בטבלת מסד נתונים, או שורות או רשום המרובות בבת
אחת. הגישה הנפוצה ביותר היא לכתוב בכיתת ילד שמרחיבה את המחלקה הרשומה
שמייצגת טבלה במסד הנתונים. שמו של הילד בכיתה צריך להיות השם של הטבלה.
פשוט על ידי יצירה

    use Pop\Record\Record;

    class Users extends Record { }

אתה יוצר בכיתה שיש את כל הפונקציונליות של הרכיב הרשום ונבנה בכיתה יודעת
את השם של הטבלה במסד הנתונים לשאילתא משם המחלקה. לדוגמה, מתרגם
'המשתמשים' למשתמשי \`\` או מתרגם 'DbUsers' ל\` db\_users \`(CamelCase
הופך אוטומטי lower\_case\_underscore.) משם, אתה יכול לכוונן את כיתת הילד
שמייצגת את הטבלה עם מאפיינים ברמה שונים, כגון :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

אם אתה בתוך פרויקט מובנה שיש מתאם מסד נתונים מוגדרים, אז מרכיב השיא יהיה
להרים את זה ולהשתמש בו. עם זאת, אם אתה פשוט כותב כמה תסריטים מהירים
באמצעות רכיב ההקלטה, אז אתה צריך להגיד את זה מתאם מסד נתונים כדי להשתמש
בו:

    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    );

    // Create DB object
    $db = \Pop\Db\Db::factory('Mysqli', $creds);

    Record::setDb($db);

משם, שימוש בסיסי הוא כדלקמן:

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
