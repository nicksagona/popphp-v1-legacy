Pop PHP Framework
=================

Documentation : Db
------------------

Home

Db ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¾Ð±ÐµÑ?Ð¿ÐµÑ‡Ð¸Ð²Ð°ÐµÑ‚ Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿ Ðº
Ð½Ð¾Ñ€Ð¼Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ð¾Ð¹ Ð·Ð°Ð¿Ñ€Ð¾Ñ?Ð¾Ð² Ðº Ð±Ð°Ð·Ð°Ð¼ Ð´Ð°Ð½Ð½Ñ‹Ñ….
ÐŸÐ¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÐ¼Ñ‹Ñ… Ð°Ð´Ð°Ð¿Ñ‚ÐµÑ€Ð¾Ð² Ñ?Ð²Ð»Ñ?ÑŽÑ‚Ñ?Ñ?:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

ÐŸÐ¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²Ð»ÐµÐ½Ð½Ñ‹Ðµ Ð·Ð°Ñ?Ð²Ð»ÐµÐ½Ð¸Ñ?
Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÑŽÑ‚Ñ?Ñ? Ñ? MySQLi, Oracle, PDO, PostgreSQL, SQLite
Ð¸ SQLSRV Ð°Ð´Ð°Ð¿Ñ‚ÐµÑ€Ð¾Ð². Ð¡Ð±ÐµÐ¶Ð°Ð²ÑˆÐ¸Ð¹ Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ñ?
Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿Ð½Ñ‹ Ð´Ð»Ñ? Ð²Ñ?ÐµÑ… Ð°Ð´Ð°Ð¿Ñ‚ÐµÑ€Ð¾Ð².

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

Ð’ Ð´Ð¾Ð¿Ð¾Ð»Ð½ÐµÐ½Ð¸Ðµ Ðº Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿ Ðº Ð±Ð°Ð·Ðµ Ð´Ð°Ð½Ð½Ñ‹Ñ…, Db
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ñ‚Ð°ÐºÐ¶Ðµ Ð¸Ð¼ÐµÐµÑ‚ Ð¿Ð¾Ð»ÐµÐ·Ð½Ñ‹Ðµ
Ð°Ð±Ñ?Ñ‚Ñ€Ð°ÐºÑ†Ð¸Ð¸ SQL Ð¾Ð±ÑŠÐµÐºÑ‚Ð°, ÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ð¹ Ð¿Ð¾Ð¼Ð¾Ð³Ð°ÐµÑ‚
Ð²Ð°Ð¼ Ð² Ñ?Ð¾Ð·Ð´Ð°Ð½Ð¸Ð¸ Ñ?Ñ‚Ð°Ð½Ð´Ð°Ñ€Ñ‚Ð¸Ð·Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ð¾Ð³Ð¾ SQL
Ð·Ð°Ð¿Ñ€Ð¾Ñ?Ð¾Ð².

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
