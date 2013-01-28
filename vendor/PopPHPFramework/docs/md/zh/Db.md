Pop PHP Framework
=================

Documentation : Db
------------------

Home

DBç»„ä»¶æ??ä¾›äº†æ
‡å‡†åŒ–çš„æŸ¥è¯¢æ•°æ?®åº“çš„è®¿é—®ã€‚æ”¯æŒ?çš„é€‚é…?å™¨ï¼š

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

æ”¯æŒ?é¢„å¤„ç?†è¯­å?¥çš„mysqliï¼Œç”²éª¨æ–‡ï¼ŒPDOæ—¶ï¼ŒPostgreSQLï¼ŒSQLiteå’ŒSQLSRVé€‚é…?å™¨ã€‚è½¬ä¹‰çš„å€¼æ˜¯é€‚ç”¨äºŽæ‰€æœ‰é€‚é…?å™¨ã€‚

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

é™¤äº†æ•°æ?®åº“è®¿é—®ï¼ŒDBç»„ä»¶è¿˜è®¾æœ‰ä¸€ä¸ªæœ‰ç”¨çš„çš„SQLæŠ½è±¡å¯¹è±¡ï¼Œå¸®åŠ©æ‚¨åœ¨åˆ›å»ºæ
‡å‡†åŒ–çš„SQLæŸ¥è¯¢ã€‚

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
