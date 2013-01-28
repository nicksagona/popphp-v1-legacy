Pop PHP Framework
=================

Documentation : Db
------------------

Home

DBã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ã€?ã‚¯ã‚¨ãƒªã?®ãƒ‡ãƒ¼ã‚¿ãƒ™ãƒ¼ã‚¹ã?¸ã?®æ­£è¦?åŒ–ã?•ã‚Œã?Ÿã‚¢ã‚¯ã‚»ã‚¹ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚ã‚µãƒ?ãƒ¼ãƒˆã?•ã‚Œã?¦ã?„ã‚‹ã‚¢ãƒ€ãƒ—ã‚¿ã?¯ä»¥ä¸‹ã?®ã?¨ã?Šã‚Šã?§ã?™ã€‚

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

ãƒ—ãƒªãƒšã‚¢ãƒ‰ã‚¹ãƒ†ãƒ¼ãƒˆãƒ¡ãƒ³ãƒˆã?¯MySQLiã?®ã?¯ã€?Oracleã€?PDOã?¯ã€?PostgreSQLã€?SQLiteã?¨SQLSRVã‚¢ãƒ€ãƒ—ã‚¿ã?§ã‚µãƒ?ãƒ¼ãƒˆã?•ã‚Œã?¦ã?„ã?¾ã?™ã€‚ã‚¨ã‚¹ã‚±ãƒ¼ãƒ—ã?•ã‚Œã?Ÿå€¤ã?¯ã€?ã?™ã?¹ã?¦ã?®ã‚¢ãƒ€ãƒ—ã‚¿ãƒ¼ã‚’ã?”åˆ©ç”¨ã?„ã?Ÿã?
ã?‘ã?¾ã?™ã€‚

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

ãƒ‡ãƒ¼ã‚¿ãƒ™ãƒ¼ã‚¹ã?¸ã?®ã‚¢ã‚¯ã‚»ã‚¹ã?«åŠ
ã?ˆã?¦ã€?DBã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã‚‚æ¨™æº–åŒ–ã?•ã‚Œã?ŸSQLã‚¯ã‚¨ãƒªã?®ä½œæˆ?ã‚’æ”¯æ?´ã?™ã‚‹ä¾¿åˆ©ã?ªSQLã?®æŠ½è±¡åŒ–ã‚ªãƒ–ã‚¸ã‚§ã‚¯ãƒˆã‚’æ??ä¾›ã?—ã?¦ã?„ã?¾ã?™ã€‚

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
