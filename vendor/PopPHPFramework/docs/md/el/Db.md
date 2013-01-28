Pop PHP Framework
=================

Documentation : Db
------------------

Home

Î— ÏƒÏ…Î½Î¹ÏƒÏ„ÏŽÏƒÎ± Db Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Ï€Ï?ÏŒÏƒÎ²Î±ÏƒÎ· ÏƒÎµ
ÎºÎ±Î½Î¿Î½Î¹ÎºÎ¿Ï€Î¿Î¹Î·Î¼Î­Î½Î· ÎµÏ?Ï‰Ï„Î®Î¼Î±Ï„Î± ÏƒÎµ Î²Î¬ÏƒÎµÎ¹Ï‚
Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½. ÎŸÎ¹ Ï€Ï?Î¿ÏƒÎ±Ï?Î¼Î¿Î³ÎµÎ¯Ï‚
Ï…Ï€Î¿ÏƒÏ„Î·Ï?Î¯Î¶Î¿Î½Ï„Î±Î¹ ÎµÎ¯Î½Î±Î¹ Î¿Î¹ ÎµÎ¾Î®Ï‚:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

ÎŸÎ¹ Î´Î·Î»ÏŽÏƒÎµÎ¹Ï‚ Ï€Î¿Ï… Ï…Ï€Î¿ÏƒÏ„Î·Ï?Î¯Î¶Î¿Î½Ï„Î±Î¹
Ï€Î±Ï?Î±ÏƒÎºÎµÏ…Î±ÏƒÎ¼Î­Î½Î± Î¼Îµ Ï„Î· MySQLi, Oracle, Î ÎŸÎ ,
PostgreSQL, SQLite ÎºÎ±Î¹ SQLSrv Ï€Ï?Î¿ÏƒÎ±Ï?Î¼Î¿Î³ÎµÎ¯Ï‚. Escaped
Ï„Î¹Î¼Î­Ï‚ ÎµÎ¯Î½Î±Î¹ Î´Î¹Î±Î¸Î­ÏƒÎ¹Î¼Î± Î³Î¹Î± ÏŒÎ»Î¿Ï…Ï‚ Ï„Î¿Ï…Ï‚
Ï€Ï?Î¿ÏƒÎ±Ï?Î¼Î¿Î³ÎµÎ¯Ï‚.

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

Î•ÎºÏ„ÏŒÏ‚ Î±Ï€ÏŒ Ï„Î·Î½ Ï€Ï?ÏŒÏƒÎ²Î±ÏƒÎ· ÏƒÎµ Î²Î¬ÏƒÎµÎ¹Ï‚
Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½, Î· ÏƒÏ…Î½Î¹ÏƒÏ„ÏŽÏƒÎ± Db Î´Î¹Î±Î¸Î­Ï„ÎµÎ¹
ÎµÏ€Î¯ÏƒÎ·Ï‚ Î­Î½Î± Ï‡Ï?Î®ÏƒÎ¹Î¼Î¿ Î±Î½Ï„Î¹ÎºÎµÎ¯Î¼ÎµÎ½Î¿
Î±Ï†Î±Î¯Ï?ÎµÏƒÎ· Sql Ï€Î¿Ï… ÏƒÎ±Ï‚ Î²Î¿Î·Î¸Î¬ ÏƒÏ„Î·
Î´Î·Î¼Î¹Î¿Ï…Ï?Î³Î¯Î± Ï„Ï…Ï€Î¿Ï€Î¿Î¹Î·Î¼Î­Î½Ï‰Î½ ÎµÏ?Ï‰Ï„Î·Î¼Î¬Ï„Ï‰Î½
SQL.

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
