Pop PHP Framework
=================

Documentation : Db
------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø¯ÙŠØ³ÙŠØ¨Ù„ ÙŠÙˆÙ?Ø± Ø§Ù„ÙˆØµÙˆÙ„ Ø¥Ù„Ù‰ Ù‚ÙˆØ§Ø¹Ø¯
Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª ØªØ·Ø¨ÙŠØ¹ Ø§Ù„Ø§Ø³ØªØ¹Ù„Ø§Ù…. Ù…Ø­ÙˆÙ„Ø§Øª
Ø§Ù„Ù…Ø¹ØªÙ…Ø¯Ø© Ù‡ÙŠ:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

ÙŠØªÙ… Ø§Ø¹ØªÙ…Ø§Ø¯ Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ù…Ø¹Ø¯Ø© Ù…Ø¹ MySQLiØŒ
Ø£ÙˆØ±Ø§ÙƒÙ„ØŒ Ø´Ø±ÙƒØ© ØªÙ†Ù…ÙŠØ© Ù†Ù?Ø· Ø¹Ù…Ø§Ù†ØŒ Ø§Ù„Ø¥Ù†ØªØ±Ù†ØªØŒ
Ø³ÙƒÙ„ÙŠØªÙŠ ÙˆÙ…Ø­ÙˆÙ„Ø§Øª SQLSrv. Ø§Ù„Ù‚ÙŠÙ… Ù‡Ø±Ø¨ Ù…ØªØ§Ø­Ø©
Ù„Ø¬Ù…ÙŠØ¹ Ø§Ù„Ù…Ø­ÙˆÙ„Ø§Øª.

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

Ø¨Ø§Ù„Ø¥Ø¶Ø§Ù?Ø© Ø¥Ù„Ù‰ Ø§Ù„ÙˆØµÙˆÙ„ Ø¥Ù„Ù‰ Ù‚Ø§Ø¹Ø¯Ø©
Ø§Ù„Ø¨ÙŠØ§Ù†Ø§ØªØŒ Ø§Ù„Ù…ÙƒÙˆÙ† Ø¯ÙŠØ³ÙŠØ¨Ù„ ÙƒÙ…Ø§ ØªØ­ØªÙˆÙŠ Ø¹Ù„Ù‰
Ø§Ù„ØªØ¬Ø±ÙŠØ¯ Ù…Ø²ÙˆØ¯ Ù…Ù?ÙŠØ¯Ø© Ø§Ù„ÙƒØ§Ø¦Ù† Ø§Ù„Ø°ÙŠ ÙŠØ³Ø§Ø¹Ø¯Ùƒ
Ù?ÙŠ Ø¥Ù†Ø´Ø§Ø¡ Ø§Ø³ØªØ¹Ù„Ø§Ù…Ø§Øª SQL Ù…ÙˆØ­Ø¯Ø©.

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
