Pop PHP Framework
=================

Documentation : Db
------------------

Home

מרכיב Db מספק גישה למאגרי מידע מנורמל שאילתא. המתאמים הנתמכים הם:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

ההצהרות מוכנות נתמכות עם MySQLi, אורקל, PDO, PostgreSQL, SQLite ומתאמי
SQLSrv. ערכים נמלטו זמינים לכל מתאמים.

    use Pop\Db\Db;

    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    );

    // Create DB object
    $db = Db::factory('Mysqli', $creds);

    // Perform the query
    $db->adapter()->query('SELECT * FROM users');

    // Fetch the results
    while (($row = $db->adapter()->fetch()) != false) {
        print_r($row);
    }

בנוסף לגישה למסד נתונים, רכיב Db כולל גם אובייקט הפשטת Sql שימושי שמסייע
לך ביצירת שאילתות SQL סטנדרטיות.

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

            מעמד השיא, כפי שמתואר בסקירת התיעוד, הוא "היברידי" של מיני בין הרשומה הפעילה ודפוסי Gateway טבלה. באמצעות API סטנדרטי, היא יכולה לספק גישה לשורה או רשומה בודדה בטבלת מסד נתונים, או שורות או רשום המרובות בבת אחת.הגישה הנפוצה ביותר היא לכתוב בכיתת ילד שמרחיבה את המחלקה הרשומה שמייצגת טבלה במסד הנתונים.שמו של הילד בכיתה צריך להיות השם של הטבלה. פשוט על ידי יצירה:

    use Pop\Db\Record;

    class Users extends Record { }

            ליוצרך מחלקה שכוללת את כל הפונקציונליות של מעמד השיא שנבנה בכיתה ויודעת את השם של טבלת מסד הנתונים לשאילתא משם המחלקה. לדוגמה, מתרגם 'המשתמשים' למשתמשי `` או מתרגם 'DbUsers' ל` db_users `(CamelCase הופך אוטומטי lower_case_underscore.) משם, אתה יכול לכוונן את כיתת הילד שמייצגת את הטבלה עם מאפיינים ברמה שונים, כגון :

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

            אם אתה בתוך פרויקט מובנה שיש מתאם מסד נתונים מוגדרים, אז הכיתה הרשומה תאסוף את זה ולהשתמש בו. עם זאת, אם אתה פשוט כותב כמה תסריטים מהירים באמצעות רכיב ההקלטה, אז אתה צריך להגיד את זה מתאם מסד נתונים כדי להשתמש בו:

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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
