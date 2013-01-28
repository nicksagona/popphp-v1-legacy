Pop PHP Framework
=================

Documentation : Db
------------------

Home

×ž×¨×›×™×‘ Db ×ž×¡×¤×§ ×’×™×©×” ×œ×ž×?×’×¨×™ ×ž×™×“×¢ ×ž× ×•×¨×ž×œ
×©×?×™×œ×ª×?. ×”×ž×ª×?×ž×™×? ×”× ×ª×ž×›×™×? ×”×?:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

×”×”×¦×”×¨×•×ª ×ž×•×›× ×•×ª × ×ª×ž×›×•×ª ×¢×? MySQLi, ×?×•×¨×§×œ, PDO,
PostgreSQL, SQLite ×•×ž×ª×?×ž×™ SQLSrv. ×¢×¨×›×™×? × ×ž×œ×˜×• ×–×ž×™×
×™×? ×œ×›×œ ×ž×ª×?×ž×™×?.

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

×‘× ×•×¡×£ ×œ×’×™×©×” ×œ×ž×¡×“ × ×ª×•× ×™×?, ×¨×›×™×‘ Db ×›×•×œ×œ ×’×?
×?×•×‘×™×™×§×˜ ×”×¤×©×˜×ª Sql ×©×™×ž×•×©×™ ×©×ž×¡×™×™×¢ ×œ×š
×‘×™×¦×™×¨×ª ×©×?×™×œ×ª×•×ª SQL ×¡×˜× ×“×¨×˜×™×•×ª.

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
