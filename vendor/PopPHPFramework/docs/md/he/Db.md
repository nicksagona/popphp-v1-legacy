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

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
