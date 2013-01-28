Pop PHP Framework
=================

Documentation : Db
------------------

Home

La composante Db offre un accÃ¨s normalisÃ© aux bases de donnÃ©es de la
requÃªte. Les adaptateurs pris en charge sont les suivants:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

Les requÃªtes prÃ©parÃ©es sont pris en charge avec le MySQLi, Oracle,
AOP, PostgreSQL, SQLite et adaptateurs sqlsrv. Valeurs Ã©chappÃ©s sont
disponibles pour tous les adaptateurs.

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

En plus de l'accÃ¨s base de donnÃ©es, la composante Db dispose
Ã©galement d'un objet Sql abstraction utile qui vous assiste dans la
crÃ©ation de requÃªtes SQL standard.

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
